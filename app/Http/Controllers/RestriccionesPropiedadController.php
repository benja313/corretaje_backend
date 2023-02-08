<?php

namespace App\Http\Controllers;

use App\Model\RestriccionesPropiedad;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RestriccionesPropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restriccionesPropiedad = RestriccionesPropiedad::all();
        return response()->json($restriccionesPropiedad, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //'nombre','descripcion'
        $restriccionPropiedad = new RestriccionesPropiedad([
            'id_propiedad' => $request->get('id_propiedad'),
            'id_restriccion' => $request->get('id_restriccion'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $restriccionPropiedad->save();
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function destroyOnIdPropiedadIdRestriccion($idPropiedad, $idRestriccion)
    {
        $restriccionPropiedad = DB::table('restricciones_propiedads')
            ->where('id_propiedad', $idPropiedad)
            ->where('id_restriccion', $idRestriccion)
            ->get();
        $restriccionPropiedad->delete();
        return response()->json('success', 200);
    }

    public  function showRestriccionesOnIdPropiedad(){

    }
}
