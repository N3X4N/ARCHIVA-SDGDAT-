<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubserieDocumental;
use App\Models\SerieDocumental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Dependencia;

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
        $dependencias  = Dependencia::active()->pluck('nombre', 'id');
        $seleccionadas = [];

        return view('inventarios.series.subseries.create', compact(
            'series',
            'dependencias',
            'seleccionadas'
        ));
    }

    /**
     * Almacenar nueva subserie.
     */
    public function store(Request $request, SerieDocumental $series)
    {
        $data = $request->validate([
            'codigo'            => [
                'required',
                'string',
                'max:10',
                Rule::unique('subseries_documentales', 'codigo')
                    ->where('serie_documental_id', $series->id)
            ],
            'nombre'           => [
                'required',
                'string',
                'max:150',
                Rule::unique('subseries_documentales', 'nombre')
                    ->where('serie_documental_id', $series->id)
            ],
            'is_active'         => ['required', 'boolean'],
            'dependencias_ids'  => ['required', 'array', 'min:1'],
            'dependencias_ids.*' => ['exists:dependencias,id'],
        ]);

        $subserie = SubserieDocumental::create([
            'serie_documental_id' => $series->id,
            'codigo'              => $data['codigo'],
            'nombre'              => $data['nombre'],
            'is_active'           => $data['is_active'],
        ]);

        $subserie->dependencias()->sync($data['dependencias_ids']);

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
        $dependencias  = Dependencia::active()->pluck('nombre', 'id');
        $seleccionadas = $subseries->dependencias->pluck('id')->toArray();

        return view('inventarios.series.subseries.edit', compact(
            'series',
            'subseries',
            'dependencias',
            'seleccionadas'
        ));
    }

    public function update(Request $request, SerieDocumental $series, SubserieDocumental $subserie)
    {
        $data = $request->validate([
            'codigo'            => [
                'required',
                'string',
                'max:10',
                Rule::unique('subseries_documentales', 'codigo')
                    ->where('serie_documental_id', $series->id)
                    ->ignore($subserie->id)
            ],
            'nombre'            => ['required', 'string', 'max:150'],
            'is_active'         => ['required', 'boolean'],
            'dependencias_ids'  => ['required', 'array', 'min:1'],
            'dependencias_ids.*' => ['exists:dependencias,id'],
        ]);

        $subserie->update([
            'codigo'    => $data['codigo'],
            'nombre'    => $data['nombre'],
            'is_active' => $data['is_active'],
        ]);

        $subserie->dependencias()->sync($data['dependencias_ids']);

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
        // (Opcional) limpiar la tabla pivote
        $subserie->dependencias()->detach();

        // Soft-delete: marca deleted_at, no borra físicamente
        $subserie->delete();

        return redirect()
            ->route('inventarios.series.subseries.index', $series)
            ->with('alertType', 'success')
            ->with('alertMessage', 'Subserie eliminada correctamente.');
    }
}
