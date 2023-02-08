<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Banco;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bancos = Banco::all();
        return response()->json($bancos);
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
        if (auth()->user()->id_tipo_persona == 7){
            try{
                $banco = new Banco([
                    'nombre' => $request->get('nombre'),
                    'rut' => $request->get('rut')
                ]);
                $banco->save();
                return $this->index();
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
        $banco = Banco::find($id);
        return response()->json($banco);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        if (auth()->user()->id_tipo_persona == 7){
            try{
                $banco = Banco::find($id);
                $banco->nombre = $request->get('nombre');
                $banco->rut = $request->get('rut');
                $banco->save();

                return $this->index();
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
                $banco = Banco::find($id);
                $banco->delete();
                return $this->index();
            }catch (\Exception $e){
                return response()->json($e, '404');
            }
        }else{
            return response()->json('Error credenciales ascas', '403');
        }
    }
}
