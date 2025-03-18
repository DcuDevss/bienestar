<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()//cada middlewure manejara una funcion del controlador
    {
       // $this->middleware('can:roles.index')->only('index');
       // $this->middleware('can:roles.create')->only('create');
       // $this->middleware('can:roles.store')->only('store');
       // $this->middleware('can:roles.show')->only('show');
       // $this->middleware('can:roles.update')->only('update');
       // $this->middleware('can:roles.edit')->only('edit');
       // $this->middleware('can:roles.destroy')->only('destroy');


        // $this->middleware('can:roles.index')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        $role = new Role();

        $title = "Crear roles";
        $btn = "Crear";
        $permissions_id = [];
        return view('admin.roles.create', compact('title', 'btn', 'permissions', 'role', 'permissions_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array', // Make sure 'permissions' is an array
        ]);

        $name = $request->input('name');
        $permissions = $request->input('permissions', []);
        $role = Role::create(['name' => $name, 'guard_name' => 'web']);

        if (count($permissions) > 0) {
            $permissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        //$role = new Role();

        $title = "Ver roles";
        $btn = "Ver";
        $permissions_id = $role->permissions()->pluck('id')->toArray();
        return view('admin.roles.show', compact('title', 'btn', 'permissions', 'role', 'permissions_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('canDeleteRole',$role);
        $permissions = Permission::orderBy('name', 'asc')->get();
        //$role = new Role();

        $title = "Editar roles";
        $btn = "Editar";
        $permissions_id = $role->permissions()->pluck('id')->toArray();
        return view('admin.roles.edit', compact('title', 'btn', 'permissions', 'role', 'permissions_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('canDeleteRole',$role);
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            //'permissions' => 'array', // Asegúrate de que 'permissions' sea un array
        ]);

        $data = $request->only('name');
        $permissions = $request->input('permissions', []);
        $role->update($data);

        if (count($permissions) > 0) {
            $permissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success','Actualizado correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('canDeleteRole',$role);
        $role->delete();
        return redirect()->route('roles.index');
    }
}
