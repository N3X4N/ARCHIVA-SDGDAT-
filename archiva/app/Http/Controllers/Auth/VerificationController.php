<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified; // Importa la clase Verified

class VerificationController extends Controller
{
    public function verify(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/home');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); // Quitar el 'args:'
        }

        return redirect()->intended('/home')->with('verified', true); // Corrección de parámetros
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true); // Agregar respuesta faltante
    }
}