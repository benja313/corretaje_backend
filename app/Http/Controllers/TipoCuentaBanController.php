<?php

namespace App\Http\Controllers;

use App\Model\TipoCuentaBan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoCuentaBanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposCuenta = TipoCuentaBan::all();
        return response()->json($tiposCuenta, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try{
            $tipoCuenta = new TipoCuentaBan([
                'nombre' => $request->get('nombre'),
                'descripcion' => $request->get('descripcion'),
                'created_at' => Carbon::now('America/Santiago')
            ]);
            $tipoCuenta->save();
            return response()->json('success', 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
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
        $tipoCuenta = Restriccion::find($id);
        return response()->json($tipoCuenta, 200);
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
        $tipoCuenta = TipoCuentaBan::find($id);
        $tipoCuenta->nombre = $request->get('nombre');
        $tipoCuenta->descripcion = $request->get('descripcion');
        $tipoCuenta->updated_at = Carbon::now('America/Santiago');
        $tipoCuenta->save();
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
        $tipoCuenta = Restriccion::find($id);
        $tipoCuenta->delete();
        return response()->json('success', 200);
    }
}
