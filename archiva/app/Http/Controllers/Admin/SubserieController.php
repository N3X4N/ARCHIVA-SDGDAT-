<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubserieDocumental;
use App\Models\SerieDocumental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubserieController extends Controller
{
    /**
     * Listado de subseries de una serie concreta.
     */
    public function index(Request $request, SerieDocumental $series)
    {
        $query = $series->subseries();

        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . trim($request->codigo) . '%');
        }
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . trim($request->nombre) . '%');
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool)$request->is_active);
        }

        $subseries = $query
            ->orderBy('codigo')
            ->paginate(20)
            ->appends($request->only(['codigo', 'nombre', 'is_active']));

        return view('inventarios.series.subseries.index', compact('series', 'subseries'));
    }

    /**
     * Formulario de creación dentro de la serie.
     */
    public function create(SerieDocumental $series)
    {
        // Cuenta cuántas subseries ya hay
        $count = $series->subseries()->count();

        // El siguiente número
        $next = $count + 1;

        // 3 dígitos con ceros a la izquierda
        $suffix = str_pad($next, 3, '0', STR_PAD_LEFT);

        // Prefijo + guión + secuencia
        $defaultCode = "{$series->codigo}-{$suffix}";

        // Creamos un nuevo modelo con el código por defecto
        $subserie = new SubserieDocumental();
        $subserie->codigo = $defaultCode;

        return view(
            'inventarios.series.subseries.create',
            compact('series', 'subserie')
        );
    }

    /**
     * Almacenar nueva subserie.
     */
    public function store(Request $request, SerieDocumental $series)
    {
        // 1) Validamos sufijo y nombre sin tocar el DB todavía
        $data = $request->validate([
            'suffix'    => ['required', 'digits:3'],
            'nombre'    => ['required', 'string', 'max:150'],
            'is_active' => ['required', 'boolean'],
        ]);

        // 2) Construimos el código completo
        $fullCode = "{$series->codigo}-{$data['suffix']}";

        // 3) Validamos duplicados **sobre el código completo** y el nombre
        $request->merge(['codigo' => $fullCode]); // para poder usar Validator en el closure
        $request->validate([
            'codigo' => [
                Rule::unique('subseries_documentales', 'codigo')
                    ->where(
                        fn($q) => $q
                            ->where('serie_documental_id', $series->id)
                            ->where('codigo', $fullCode)
                    )
            ],
            'nombre' => [
                Rule::unique('subseries_documentales', 'nombre')
                    ->where(
                        fn($q) => $q
                            ->where('serie_documental_id', $series->id)
                            ->where('nombre', $data['nombre'])
                    )
            ],
        ]);

        // 4) Guardamos
        SubserieDocumental::create([
            'serie_documental_id' => $series->id,
            'codigo'              => $fullCode,
            'nombre'              => $data['nombre'],
            'is_active'           => $data['is_active'],
        ]);

        return redirect()
            ->route('inventarios.series.subseries.index', $series)
            ->with('alertType', 'success')
            ->with('alertMessage', 'Subserie creada correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(SerieDocumental $series, SubserieDocumental $subseries)
    {
        return view(
            'inventarios.series.subseries.edit',
            compact('series', 'subseries')
        );
    }

    public function update(Request $request, SerieDocumental $series, SubserieDocumental $subseries)
    {
        // 1) Validamos sufijo y nombre base
        $data = $request->validate([
            'suffix'    => ['required', 'digits:3'],
            'nombre'    => ['required', 'string', 'max:150'],
            'is_active' => ['required', 'boolean'],
        ]);

        // 2) Rehacemos el código entero
        $fullCode = "{$series->codigo}-{$data['suffix']}";

        // 3) Validamos unicidad, ignorando este mismo registro
        $request->merge(['codigo' => $fullCode]);
        $request->validate([
            'codigo' => [
                Rule::unique('subseries_documentales', 'codigo')
                    ->where(
                        fn($q) => $q
                            ->where('serie_documental_id', $series->id)
                            ->where('codigo', $fullCode)
                    )
                    ->ignore($subseries->id)
            ],
            'nombre' => [
                Rule::unique('subseries_documentales', 'nombre')
                    ->where(
                        fn($q) => $q
                            ->where('serie_documental_id', $series->id)
                            ->where('nombre', $data['nombre'])
                    )
                    ->ignore($subseries->id)
            ],
        ]);

        // 4) Actualizamos
        $subseries->update([
            'codigo'    => $fullCode,
            'nombre'    => $data['nombre'],
            'is_active' => $data['is_active'],
        ]);

        return redirect()
            ->route('inventarios.series.subseries.index', $series)
            ->with('alertType', 'success')
            ->with('alertMessage', 'Subserie actualizada correctamente.');
    }

    /**
     * Eliminar subserie.
     */
    public function destroy(SerieDocumental $series, SubserieDocumental $subserie)
    {
        $subserie->delete();

        return redirect()
            ->route('inventarios.series.subseries.index', $series)
            ->with('alertType', 'success')
            ->with('alertMessage', 'Subserie eliminada correctamente.');
    }
}
