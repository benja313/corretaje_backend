<?php

namespace App\Http\Controllers;

use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Caracteristica;
use mysql_xdevapi\Exception;

class CaracteristicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $caracteristicas = Caracteristica::all();
            return response()->json($caracteristicas);
        }catch (\Exception $e){
            return response()->json($e);
        }

    }
    public function getAllCaracteristicasState (){
        try{
            $caracteristicas = Caracteristica::all();
            foreach ($caracteristicas as $item) {
                $item->state = false;
            }
            return response()->json($caracteristicas);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->id_tipo_persona == 7){
            try{
                $caracteristica = new Caracteristica([
                    'nombre' => $request->get('nombre'),
                    'descripcion' => $request->get('descripcion'),
                    'created_at' => Carbon::now('America/Santiago')
                ]);

                $caracteristica->save();

                $caracteristicas = Caracteristica::all();
                return response()->json($caracteristicas, '200');
            }catch (\Exception $e){
                return response()->json($e, '404');
            }
        }else{
            return response()->json('Error credenciales', '401');
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
        $caracteristica = Caracteristica::find($id);
        return response()->json($caracteristica);
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
        if(auth()->user()->id_tipo_persona == 7){
            try{
                $caracteristica = Caracteristica::find($id);
                //$caracteristica ->update($request->all());
                $caracteristica->nombre = $request->get('nombre');
                $caracteristica->descripcion = $request->get('descripcion');
                $caracteristica->updated_at = Carbon::now('America/Santiago');
                $caracteristica->save();
                $caracteristicas = Caracteristica::all();
                return response()->json($caracteristicas, '200');
            }catch (\Exception $e){
                return response()->json($e, '404');
            }
        }else{
            return response()->json('Error credenciales', '401');
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
    if (auth()->user()->id_tipo_persona == 7){
            try{
                $caracteristica = Caracteristica::find($id);
                $caracteristica->delete();


                $caracteristicas = Caracteristica::all();
                return response()->json($caracteristicas, '200');
            }catch (\Exception $e){
                return response()->json($e, '404');
            }
    }else{
        return response()->json('Error credenciales', '401');
        }
    }
}
