<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\EspecialidadUpdateRequest;




class EspecialidadeController extends Controller
{
    public function __construct(){
       /* $this->middleware('can:especialidades.index')->only('index');
        $this->middleware('can:especialidades.create')->only('create');
        $this->middleware('can:especialidades.store')->only('store');
        $this->middleware('can:especialidades.show')->only('show');
        $this->middleware('can:especialidades.update')->only('update');
        $this->middleware('can:especialidades.edit')->only('edit');
        $this->middleware('can:especialidades.destroy')->only('destroy');*/
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidades=Especialidade::orderBy('name','asc')->get();
        return view('admin.especialidades.index',compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidade = new Especialidade();
        $btn = "crear";
        $title="nueva especialidad";
        return view('admin.especialidades.create',compact('especialidade', 'btn','title'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:especialidades,name',
        ]);
        $name = mb_strtolower($request->name);
        $slug = Str::slug($name);
        $especialidades = Especialidade::create([
            'name' => $name,
            'slug' => $slug,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('especialidades.index')->with('success', 'Especialidad creaada de forma exitosa!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidade $especialidade)
    {
        return view('admin.especialidades.show',compact('especialidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidade $especialidade)
    {
        $btn = "update";
        $title="editar especialidad";
        return view('admin.especialidades.edit', compact('especialidade','btn','title'));//
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EspecialidadUpdateRequest $request, Especialidade $especialidade)
    {
        $name = mb_strtolower($request->name);
        $slug = Str::slug($name);
        $especialidade->update([
            'name' => $name,
            'slug' => $slug,
            'descripcion' => $request->descripcion,
        ]);
        $especialidade->save();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad editada de forma correcta!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialidade $especialidade)
    {
        if($especialidade->id>76){
            $especialidade->delete();
       return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada con exito!');

       }else{
        return redirect()->route('especialidades.index')->with('fail', 'Especialidad no borrada');

       }
    }
}
