<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumental;
use Illuminate\Http\Request;

class TipoDocumentalController extends Controller
{
    /**
     * Muestra el listado de tipos documentales con filtros.
     */
    public function index(Request $request)
    {
        $query = TipoDocumental::query();

        // Filtro por nombre
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->input('search') . '%');
        }

        // Filtro por estado sólo si no está vacío
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }

        $tipos = $query
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString();

        return view('inventarios.tipos_documentales.index', compact('tipos'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        return view('inventarios.tipos_documentales.create');
    }

    /**
     * Almacena un nuevo tipo documental.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|unique:tipos_documentales,nombre',
            'is_active' => 'sometimes|boolean',
        ]);

        TipoDocumental::create([
            'nombre'    => $data['nombre'],
            'is_active' => $data['is_active'] ?? true,
        ]);

        return redirect()
            ->route('inventarios.tipos-documentales.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Tipo documental creado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(TipoDocumental $tipo_documental)
    {
        return view('inventarios.tipos_documentales.edit', compact('tipo_documental'));
    }

    /**
     * Actualiza un tipo documental existente.
     */
    public function update(Request $request, TipoDocumental $tipo_documental)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|unique:tipos_documentales,nombre,' . $tipo_documental->id,
            'is_active' => 'sometimes|boolean',
        ]);

        $tipo_documental->update([
            'nombre'    => $data['nombre'],
            'is_active' => $data['is_active'] ?? false,
        ]);

        return redirect()
            ->route('inventarios.tipos-documentales.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Tipo documental actualizado correctamente.');
    }

    /**
     * Elimina (soft delete) un tipo documental.
     */
    public function destroy(TipoDocumental $tipo_documental)
    {
        // 1) Si está asociado a alguna Serie, no permitimos la eliminación
        if ($tipo_documental->seriesDocumentales()->exists()) {
            return back()
                ->with('alertType', 'warning')
                ->with('alertMessage', 'No puedes eliminar este tipo porque está asociado a series documentales.');
        }

        // 2) Soft‐delete: marca deleted_at sin borrar físicamente
        $tipo_documental->delete();

        return back()
            ->with('alertType', 'success')
            ->with('alertMessage', 'Tipo documental eliminado correctamente.');
    }
}
