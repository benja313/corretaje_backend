<?php

namespace App\Http\Controllers;

use App\Model\TipoEstadoPubli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoEstadoPubliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposEstado = TipoEstadoPubli::all();
        return response()->json($tiposEstado, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //'nombre','descripcion'
        $tipoEstado = new TipoEstadoPubli([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $tipoEstado->save();
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
        $tipoEstado = TipoEstadoPubli::find($id);
        return response()->json($tipoEstado, 200);
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
        $tipoEstado = TipoEstadoPubli::find($id);
        $tipoEstado->nombre = $request->get('nombre');
        $tipoEstado->descripcion = $request->get('descripcion');
        $tipoEstado->updated_at = Carbon::now('America/Santiago');
        $tipoEstado->save();
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
        $tipoEstado = TipoEstadoPubli::find($id);
        $tipoEstado->delete();
        return response()->json('success', 200);
    }
}
