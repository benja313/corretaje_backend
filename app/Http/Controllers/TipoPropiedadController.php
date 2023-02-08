<?php

namespace App\Http\Controllers;

use App\Model\TipoPropiedad;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoPropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposPropiedad = TipoPropiedad::all();
        return response()->json($tiposPropiedad, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $tipoPropiedad = new TipoPropiedad([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $tipoPropiedad->save();
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
        $tipoPropiedad = TipoPropiedad::find($id);
        return response()->json($tipoPropiedad, 200);
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
        $tipoPropiedad = TipoPropiedad::find($id);
        $tipoPropiedad->nombre = $request->get('nombre');
        $tipoPropiedad->descripcion = $request->get('descripcion');
        $tipoPropiedad->updated_at = Carbon::now('America/Santiago');
        $tipoPropiedad->save();
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
        $tipoPropiedad = TipoPublicacion::find($id);
        $tipoPropiedad->delete();
        return response()->json('success', 200);
    }
}
