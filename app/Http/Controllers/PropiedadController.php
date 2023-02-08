<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use  App\Model\Propiedad;

class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propiedads = Propiedad::all();
        return response()->json($propiedads, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $propiedad = new Propiedad([
            'direccion' => $request->get('direccion'),
            'coordenadas' => $request->get('coordenadas'),
            'id_tipo_propiedad' => $request->get('id_tipo_propiedad'),
            'id_comuna' => $request->get('id_comuna'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $propiedad->save();
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
        $propiedad = Propiedad::find($id);
        return response()->json($propiedad, 200);
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
        $propiedad = Propiedad::find($id);
        $propiedad->direccion = $request->get('direccion');
        $propiedad->coordenadas = $request->get('coordenadas');
        $propiedad->id_tipo_propiedad = $request->get('id_tipo_propiedad');
        $propiedad->id_comuna = $request->get('id_comuna');
        $propiedad->updated_at = Carbon::now('America/Santiago');
        $propiedad->save();
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
        $propiedad = Propiedad::find($id);
        $propiedad->delete();
        return response()->json('success', 200);
    }
}
