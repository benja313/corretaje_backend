<?php

namespace App\Http\Controllers;

use App\Model\Restriccion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RestriccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restriccions = Restriccion::all();
        return response()->json($restriccions, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try{
            $restriccion = new Restriccion([
                'nombre' => $request->get('nombre'),
                'descripcion' => $request->get('descripcion'),
                'created_at' => Carbon::now('America/Santiago')
            ]);
            $restriccion->save();
            $restriccions = Restriccion::all();
            return response()->json($restriccions, 200);
        }catch (\Exception $e){
            return response()->json($e, '404');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restriccion = Restriccion::find($id);
        return response()->json($restriccion, 200);
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

        try{
            $restriccion = Restriccion::find($id);
            $restriccion->nombre = $request->get('nombre');
            $restriccion->descripcion = $request->get('descripcion');
            $restriccion->updated_at = Carbon::now('America/Santiago');
            $restriccion->save();
            $restriccions = Restriccion::all();
            return response()->json($restriccions, 200);
        }catch (\Exception $e){
            return response()->json($e, '404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $restriccion = Restriccion::find($id);
            $restriccion->delete();
            $restriccions = Restriccion::all();
            return response()->json($restriccions, 200);
        }catch (\Exception $e){
            return response()->json($e, '404');
        }
    }
}
