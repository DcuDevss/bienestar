<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class NuevoUsuarioController extends Controller
{
    public function create()
    {
        $datos = User::all();
        $roles = Role::all();
        return view('admin-users.index', compact('datos','roles'));
    }

    public function store(Request $request)
    {
        /* $datos = $request->except('_token');
        return response()->json($datos, 200); */
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            // 'email' => ['required', 'unique:users'],
            'password' => 'required|confirmed'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('new-user')->with('info','EL usuario se creo con exito');
    }
}
