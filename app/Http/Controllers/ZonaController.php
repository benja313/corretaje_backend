<?php

namespace App\Http\Controllers;

use App\Model\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;


class ZonaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Zona::all();
        return response()->json($zonas);
    }

    public function getAllZonasState(){
        try{
            $zonas = Zona::all();
            foreach ($zonas as $item) {
                $item->state = false;
            }
            return response()->json($zonas);
        }catch (\Exception $e){
            return response()->json($e);
        }
    }
    public function getAllZonasComunaRegion(){
        try{
            $zonas = DB::table('zonas')
                ->Join('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE zonas.id_comuna = comunas.id LIMIT 1)'));
                })
                ->Join('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE comunas.id_region = regions.id LIMIT 1)'));
                })
                ->select('zonas.*', 'comunas.nombre AS nombre_comuna', 'regions.nombre AS nombre_region')
                ->orderBy('zonas.id', 'desc')
                ->get();
            return response()->json($zonas);
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
        try{
            $zona = new Zona([
                'nombre' => $request->get('nombre'),
                'id_comuna' => $request->get('id_comuna'),
                'descripcion_zona' => $request->get('descripcion'),
                'created_at' => Carbon::now('America/Santiago')
            ]);
            $zona->save();
            $zonas = Zona::all();
            return response()->json($zonas, 200);
        }catch (\Exception $e){
            return response()->json($e, '404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show(zona $zona)
    {
        $zona = Zona::find($zona);
        return response()->json($zona, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $zona = Zona::find($id);
            $zona->nombre = $request->get('nombre');
            $zona->descripcion_zona = $request->get('descripcion_zona');
            $zona->id_comuna = $request->get('id_comuna');
            $zona->updated_at = Carbon::now('America/Santiago');
            $zona->save();
            return $this->getAllZonasComunaRegion();
        }catch (\Exception $e){
            return response()->json($e, '404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try{
            $zona = Zona::find($id);
            $zona->delete();
            return $this->getAllZonasComunaRegion();
        }catch (\Exception $e){
            return response()->json($e, '404');
        }
    }

    public function getZonaInComuna (int $comuna){
        $zonas = Zona::where('id_comuna',$comuna)->get();
        //where('lesson_id' , $lesson->id)->get();
        return response()->json($zonas);
    }
}
