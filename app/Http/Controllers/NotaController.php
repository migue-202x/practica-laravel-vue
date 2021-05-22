<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request){
        //pregunta si esta haciendo una peticion ajax para que no pueda acceder por la url
        if ($request->ajax()) { //OTRO puso --> if ($request->wantsJson()) {
            //filtro de que el usuario_id sea igual, al usuario que este en este momento identificado (que acabo de crear)
            return Nota::where('user_id', auth()->id())->get();//auth para acceder a toda la info del user que estubiera registrado
        }else{
            return view('home');
        }
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nota = new Nota();
        $nota->nombre = $request->nombre;
        $nota->descripcion = $request->descripcion;
        $nota->user_id = auth()->id();
        $nota->save();

        return $nota;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nota = Nota::find($id);
        $nota->nombre = $request->nombre;
        $nota->descripcion = $request->descripcion;
        $nota->save();
        return $nota;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nota = Nota::find($id);
        $nota->delete();
    }
}
