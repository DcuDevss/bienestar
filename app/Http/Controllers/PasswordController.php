<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    // Mostrar formulario
    public function edit()
    {
        return view('auth.cambiar-password');
    }

    // Procesar formulario
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1) Validamos datos
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        // 2) Verificamos que la contraseña actual sea correcta
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual no es correcta.',
            ]);
        }

        // 3) Actualizamos la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        audit_log(
            'user.password.update',   // acción que quieras usar
            $user,                    // auditable model
            'El usuario actualizó su contraseña desde la pantalla de seguridad.'
        );

        // 4) Mensaje de éxito
        return back()->with('status', 'Contraseña actualizada correctamente.');
    }
}
