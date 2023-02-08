<?php

namespace App\Http\Controllers;

use App\Model\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        return response()->json($regions, 200);
    }

    public function getAllRegionesState(){
        try{
            $regiones = Region::all();
            foreach ($regiones as $item) {
                $item->state = false;
            }
            return response()->json($regiones);
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
        $region = new Region([
            'nombre' => $request->get('nombre'),
            'id' => $request->get('id'),
            'orden' => $request->get('orden'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $region->save();
        $regiones = Region::all();
        return response()->json($regiones, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $region = Region::find($id);
        return response()->json($region, 200);
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
        $region = Region::find($id);
        $region->nombre = $request->get('nombre');
        $region->id = $request->get('id');
        $region->orden = $request->get('orden');
        $region->updated_at = Carbon::now('America/Santiago');
        $region->save();
        $regiones = Region::all();
        return response()->json($regiones, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
        $regiones = Region::all();
        return response()->json($regiones, 200);
    }
}
