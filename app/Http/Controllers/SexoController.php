<?php

namespace App\Http\Controllers;

use App\Model\Sexo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sexos = Sexo::all();
        return response()->json($sexos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //'nombre','descripcion'
        $sexo = new Sexo([
            'nombre' => $request->get('nombre'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $sexo->save();
        return response()->json('success', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sexo = Sexo::find($id);
        return response()->json($sexo, 200);
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
        $sexo = Sexo::find($id);
        $sexo->nombre = $request->get('nombre');
        $sexo->updated_at = Carbon::now('America/Santiago');
        $sexo->save();
        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sexo = Sexo::find($id);
        $sexo->delete();
        return response()->json('success', 200);
    }
}
