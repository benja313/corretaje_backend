<?php

namespace App\Http\Controllers;

use App\Model\Publicacion;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\CuentaBancaria;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class CuentaBancariaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = CuentaBancaria::all();
        return response()->json($cuentas, 200);
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
            //DB::transaction(function () use ($request) {
                $cuenta = new CuentaBancaria([
                    'numero_cuenta' => $request->get('numero_cuenta'),
                    'nombre_titular' => $request->get('nombre_titular'),
                    'rut' => $request->get('rut'),
                    'email' => $request->get('email'),
                    'id_banco' => $request->get('id_banco'),
                    'id_tipo_cuenta' => $request->get('id_tipo_cuenta'),
                    'created_at' => Carbon::now('America/Santiago')
                ]);
                $cuenta->save();
                $user = User::find($request->get('id_user'));
                $user->cuenta_bancaria = $request->get('numero_cuenta');
                $user->save();
                return response()->json('success', 200);
            //});
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
        //$cuenta = CuentaBancaria::find(id);

        $cuenta = DB::table('cuenta_bancarias')
            ->select('cuenta_bancarias.*')
            ->where('numero_cuenta', '!=', $id)
            ->first();
        return response()->json($cuenta, 200);
    }
    public function getCuentaUser(Request $request, $id)
    {
        //$cuenta = CuentaBancaria::find(id);

        $cuentaUser = DB::table('users')
            ->select('cuenta_bancaria')
            ->where('id', '=', $id)
            ->first();
        //$cuenta = CuentaBancaria::find($cuentaUser->cuenta_bancaria);
        return $this->update($request,$cuentaUser->cuenta_bancaria);

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
        $cuenta = CuentaBancaria::find($id);
        $cuenta->numero_cuenta = $request->get('numero_cuenta');
        $cuenta->nombre_titular = $request->get('nombre_titular');
        $cuenta->rut = $request->get('rut');
        $cuenta->email = $request->get('email');
        $cuenta->id_banco = $request->get('id_banco');
        $cuenta->id_tipo_cuenta = $request->get('id_tipo_cuenta');
        $cuenta->updated_at = Carbon::now('America/Santiago');
        $cuenta->save();
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
        $cuenta = CuentaBancaria::find($id);
        $cuenta->delete();
        return response()->json('success', 200);
    }
}
