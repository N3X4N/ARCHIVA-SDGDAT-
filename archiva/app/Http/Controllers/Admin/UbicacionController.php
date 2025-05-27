<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UbicacionController extends Controller
{
    /**
     * Muestra el listado de ubicaciones, con filtro opcional por estante
     * y paginación de 15 elementos por página.
     */
    public function index(Request $request)
    {
        $query = Ubicacion::query();

        if ($request->filled('estante')) {
            $query->where('estante', 'like', '%' . trim($request->estante) . '%');
        }

        $ubicaciones = $query
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->appends($request->only('estante'));

        return view('inventarios.ubicaciones.index', compact('ubicaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva ubicación.
     */
    public function create()
    {
        return view('inventarios.ubicaciones.create');
    }

    /**
     * Valida y almacena una nueva ubicación.
     * Se asegura de que la combinación estante+bandeja+caja+carpeta sea única.
     */
    public function store(Request $request)
    {
        $rules = [
            'estante'   => ['nullable', 'string', 'max:30'],
            'bandeja'   => ['nullable', 'string', 'max:30'],
            'caja'      => ['nullable', 'string', 'max:30'],
            'carpeta'   => ['nullable', 'string', 'max:30'],
            'otro'      => ['nullable', 'string', 'max:30'],
            'is_active' => ['required', 'boolean'],
        ];

        // Agregar regla de unicidad compuesta
        $rules['estante'][] = Rule::unique('ubicaciones')
            ->where(
                fn($q) => $q
                    ->where('bandeja', $request->bandeja)
                    ->where('caja',    $request->caja)
                    ->where('carpeta', $request->carpeta)
            );

        $messages = [
            'estante.unique' => 'Ya existe una ubicación con la misma estante, bandeja, caja y carpeta.',
        ];

        $data = $request->validate($rules, $messages);

        // Sanitize: trim y uppercase
        foreach (['estante', 'bandeja', 'caja', 'carpeta', 'otro'] as $f) {
            if (isset($data[$f])) {
                $data[$f] = strtoupper(trim($data[$f]));
            }
        }

        Ubicacion::create($data);

        return redirect()
            ->route('inventarios.ubicaciones.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Ubicación creada correctamente.');
    }

    /**
     * Muestra el formulario de edición para una ubicación existente.
     */
    public function edit(Ubicacion $ubicacion)
    {
        return view('inventarios.ubicaciones.edit', compact('ubicacion'));
    }

    /**
     * Valida y actualiza la ubicación. Mantiene la regla de unicidad compuesta
     * ignorando el registro actual.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $rules = [
            'estante'   => ['nullable', 'string', 'max:30'],
            'bandeja'   => ['nullable', 'string', 'max:30'],
            'caja'      => ['nullable', 'string', 'max:30'],
            'carpeta'   => ['nullable', 'string', 'max:30'],
            'otro'      => ['nullable', 'string', 'max:30'],
            'is_active' => ['required', 'boolean'],
        ];

        $rules['estante'][] = Rule::unique('ubicaciones')
            ->ignore($ubicacion->id)
            ->where(
                fn($q) => $q
                    ->where('bandeja', $request->bandeja)
                    ->where('caja',    $request->caja)
                    ->where('carpeta', $request->carpeta)
            );

        $messages = [
            'estante.unique' => 'Ya existe otra ubicación con la misma estante, bandeja, caja y carpeta.',
        ];

        $data = $request->validate($rules, $messages);

        foreach (['estante', 'bandeja', 'caja', 'carpeta', 'otro'] as $f) {
            if (isset($data[$f])) {
                $data[$f] = strtoupper(trim($data[$f]));
            }
        }

        $ubicacion->update($data);

        return redirect()
            ->route('inventarios.ubicaciones.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Ubicación actualizada correctamente.');
    }

    /**
     * Elimina (soft-delete) la ubicación siempre que no tenga
     * detalles de transferencia asociados.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        if ($ubicacion->detallesTransferencias()->exists()) {
            return redirect()
                ->route('inventarios.ubicaciones.index')
                ->with('alertType', 'error')
                ->with('alertMessage', 'No se puede eliminar: tiene transferencias asociadas.');
        }

        $ubicacion->delete();

        return redirect()
            ->route('inventarios.ubicaciones.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Ubicación eliminada correctamente.');
    }
}
