<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Dependencia;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perfil = $user->perfil;

        return view('perfiles.index', compact('user', 'perfil'));
    }

    public function edit()
    {
        $user = Auth::user();
        $perfil = Perfil::where('user_id', $user->id)->first();

        if ($perfil) {
            $this->authorize('update', $perfil);
        } else {
            $perfil = new Perfil(['user_id' => $user->id]);
        }

        $dependencias = Dependencia::pluck('nombre', 'id');

        return view('perfiles.edit', compact('perfil', 'dependencias'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $perfil = Perfil::where('user_id', $user->id)->first();

        if ($perfil) {
            $this->authorize('update', $perfil);
        }

        $data = $request->validate([
            'nombres'         => 'required|string|max:255',
            'apellidos'       => 'required|string|max:255',
            'dependencia_id'  => 'nullable|exists:dependencias,id',
            'firma_digital'   => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($request->hasFile('firma_digital')) {
            if ($perfil && $perfil->firma_digital) {
                Storage::disk('public')->delete($perfil->firma_digital);
            }
            $path = $request->file('firma_digital')->store('firmas', 'public');
            $data['firma_digital'] = $path;
        }

        Perfil::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()
            ->route('perfiles.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Perfil actualizado correctamente.');
    }
}
