<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Comuna;

class ComunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comunas = Comuna::all();
        return response()->json($comunas);
    }

    public function getAllComunasState(){
        try{
            $comunas = Comuna::all();
            foreach ($comunas as $item) {
                $item->state = false;
            }
            return response()->json($comunas);
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
        $comuna = new Comuna([
            'nombre' => $request->get('nombre'),
            'id_region' => $request->get('id_region'),
            'created_at' => Carbon::now('America/Santiago')
        ]);

        $comuna->save();
        $comunas = Comuna::all();
        return response()->json($comunas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comuna = Comuna::find($id);
        return response()->json($comuna);
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
        $comuna = Comuna::find($id);
        $comuna->nombre = $request->get('nombre');
        $comuna->id_region = $request->get('id_region');
        $comuna->updated_at = Carbon::now('America/Santiago');
        $comuna->save();
        $comunas = Comuna::all();
        return response()->json($comunas, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comuna = Comuna::find($id);
        $comuna->delete();
        $comunas = Comuna::all();
        return response()->json($comunas, 200);
    }
    /**
     * comunas por region con id de region.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComunasRegion($id)
    {
        $comunas = Comuna::where('id_region',$id)->get();
        //where('lesson_id' , $lesson->id)->get();
        return response()->json($comunas);
    }
}
