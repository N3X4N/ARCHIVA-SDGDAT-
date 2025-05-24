<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SerieDocumental;
use App\Models\TipoDocumental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SerieController extends Controller
{

    public function index(Request $request)
    {
        // Lista para el dropdown
        $tiposDocumentales = TipoDocumental::where('is_active', true)
            ->pluck('nombre', 'id');

        // Query base (con eager-load de tipos)
        $query = SerieDocumental::with('tiposDocumentales');

        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . trim($request->codigo) . '%');
        }
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . trim($request->nombre) . '%');
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filtro por tipo documental
        if ($request->filled('tipo_documental_id')) {
            $query->whereHas('tiposDocumentales', function ($q) use ($request) {
                // Indicas explícitamente la tabla:
                $q->where('tipos_documentales.id', $request->tipo_documental_id);
            });
        }

        $series = $query
            ->orderBy('codigo')
            ->paginate(20)
            ->appends($request->only(['codigo', 'nombre', 'tipo_documental_id', 'is_active']));

        return view('inventarios.series.index', compact('series', 'tiposDocumentales'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $padres        = SerieDocumental::whereNull('serie_padre_id')->pluck('nombre', 'id');
        $tipos         = TipoDocumental::where('is_active', true)->pluck('nombre', 'id');
        $seleccionados = []; // Al crear no hay ninguno aún

        return view('inventarios.series.create', compact(
            'padres',
            'tipos',
            'seleccionados'
        ));
    }

    /**
     * Actualizar serie.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'serie_padre_id'           => ['nullable', 'exists:series_documentales,id'],
            'codigo'                   => ['required','string','max:20'],
            'nombre'                   => ['required', 'string', 'max:150', 'unique:series_documentales,nombre'],
            'observaciones'            => ['nullable', 'string'],
            'is_active'                => ['required', 'boolean'],
            'tipos_documentales_ids'   => ['required', 'array', 'min:1'],
            'tipos_documentales_ids.*' => ['exists:tipos_documentales,id'],
        ]);

        // Crear serie
        $series = SerieDocumental::create([
            'serie_padre_id' => $data['serie_padre_id'] ?? null,
            'codigo'         => $data['codigo'],
            'nombre'         => $data['nombre'],
            'observaciones'  => $data['observaciones']  ?? null,
            'is_active'      => $data['is_active'],
        ]);

        // Sincronizar pivote
        $series->tiposDocumentales()->sync($data['tipos_documentales_ids']);

        return redirect()
            ->route('inventarios.series.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Serie creada correctamente.');
    }

    public function edit(SerieDocumental $series)
    {
        $padres        = SerieDocumental::whereNull('serie_padre_id')
            ->where('id', '!=', $series->id)
            ->pluck('nombre', 'id');
        $tipos         = TipoDocumental::where('is_active', true)->pluck('nombre', 'id');
        $seleccionados = $series->tiposDocumentales->pluck('id')->toArray();

        return view('inventarios.series.edit', compact(
            'series',
            'padres',
            'tipos',
            'seleccionados'
        ));
    }

    public function update(Request $request, SerieDocumental $series)
    {
        $data = $request->validate([
            'serie_padre_id'           => ['nullable', 'exists:series_documentales,id'],
            'codigo'                   => [
                'required',
                'string',
                'max:20',
                Rule::unique('series_documentales', 'codigo')->ignore($series->id)
            ],
            'nombre'                   => [
                'required',
                'string',
                'max:150',
                Rule::unique('series_documentales', 'nombre')->ignore($series->id)
            ],
            'observaciones'            => ['nullable', 'string'],
            'is_active'                => ['required', 'boolean'],
            'tipos_documentales_ids'   => ['required', 'array', 'min:1'],
            'tipos_documentales_ids.*' => ['exists:tipos_documentales,id'],
        ]);

        // Actualiza todos los campos del modelo de una vez (no dará error unique si no cambian)
        $series->update([
            'serie_padre_id' => $data['serie_padre_id'] ?? null,
            'codigo'         => ['required','string','max:20'],
            'nombre'         => $data['nombre'],
            'observaciones'  => $data['observaciones']  ?? null,
            'is_active'      => $data['is_active'],
        ]);

        // Siempre resync: si no cambian, no toca nada en la pivote
        $series->tiposDocumentales()->sync($data['tipos_documentales_ids']);

        return redirect()
            ->route('inventarios.series.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Serie actualizada correctamente.');
    }
    /**
     * Eliminar serie (soft delete).
     */
    public function destroy(SerieDocumental $series)
    {
        // Si tiene subseries, no dejas borrar
        if ($series->subseries()->exists()) {
            return redirect()
                ->route('inventarios.series.index')
                ->with('alertType', 'warning')
                ->with('alertMessage', 'No puedes eliminar una serie que tiene subseries.');
        }

        // Soft‐delete: rellena deleted_at en lugar de eliminar físicamente
        $series->delete();

        return redirect()
            ->route('inventarios.series.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Serie eliminada correctamente.');
    }
}
