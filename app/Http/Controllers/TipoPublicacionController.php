<?php

namespace App\Http\Controllers;

use App\Model\TipoPublicacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoPublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposPubli = TipoPublicacion::all();
        foreach ($tiposPubli as $item) {
            $item->state = false;
        }
        return response()->json($tiposPubli, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $tipoPubli = new TipoPublicacion([
            'nombre' => $request->get('nombre'),
            'descripcion' => $request->get('descripcion'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $tipoPubli->save();
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
        $tipoPubli = TipoPublicacion::find($id);
        return response()->json($tipoPubli, 200);
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
        $tipoPubli = TipoPublicacion::find($id);
        $tipoPubli->nombre = $request->get('nombre');
        $tipoPubli->descripcion = $request->get('descripcion');
        $tipoPubli->updated_at = Carbon::now('America/Santiago');
        $tipoPubli->save();
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
        $tipoPubli = TipoPublicacion::find($id);
        $tipoPubli->delete();
        return response()->json('success', 200);
    }
}
