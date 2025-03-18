<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()//cada middlewure manejara una funcion del controlador
    {

       // $this->middleware('can:users.index')->only('index');
       // $this->middleware('can:users.create')->only('create');
       // $this->middleware('can:users.store')->only('store');
       // $this->middleware('can:users.show')->only('show');
       // $this->middleware('can:users.update')->only('update');
       // $this->middleware('can:users.edit')->only('edit');
       // $this->middleware('can:users.destroy')->only('destroy');
       // $this->middleware('can:roles.index')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $role=Role::all();
        //$users = User::all();
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users',));
    }
    /*public function indexOld()
    {
       // $users = User::all();
        return view('admin.users.index');
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $userRole=$user->roles()->first();
        if($userRole){$userRoleId = $userRole->id;}else{$userRoleId=0;};
        //$roles=Role::All();
        $roles=Role::where('id','>=',3)->get();
        $title="Editar usuario";
        $btn="Editar";
        return view('admin.users.edit',compact('user','title','btn','roles','userRoleId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
       $role=$request->input('role');
       $user->roles()->sync($role);
       return redirect()->route('users.index')->with('success','Rol actualizado de forma exitosa!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
