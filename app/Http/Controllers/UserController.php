<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;


class userController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user){
            $user->password = null;
    }
        return response()->json($users);
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

            $user = new User([
                'rut'=> $request->get('rut'),
                'nombres'=> $request->get('nombres'),
                'apellido_p'=> $request->get('apellido_p'),
                'apellido_m'=> $request->get('apellido_m'),
                'email'=> $request->get('email'),
                'fecha_naci'=> $request->get('fecha_naci'),
                'email_verified_at'=> $request->get('email_verified_at'),
                'telefono'=> $request->get('telefono'),
                'password'=> bcrypt($request->get('password')),
                'id_sexo'=> $request->get('id_sexo'),

                'cuenta_bancaria'=> $request->get('cuenta_bancaria'),
            ]);
                $user->save();
                return  response()->json('Usuario creado existosamente');
            }
        catch(\Exception $e){
            return  response()->json($e);  // insert query
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
        $user = User::find($id);

        return response()->json($user);
    }
    public function getContact($id){
        $user = User::where('id',$id)->select('nombres', 'apellido_p', 'email', 'telefono')->get();
        return response()->json($user);
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
        $user = User::find($id);
        $user->nombres = $request->get('nombres');
        $user->apellido_p = $request->get('apellido_p');
        $user->apellido_m = $request->get('apellido_m');
        $user->email = $request->get('email');
        $user->fecha_naci = $request->get('fecha_naci');
        $user->telefono = $request->get('telefono');
        $user->password = bcrypt($request->get('password'));
        $user->id_sexo = $request->get('id_sexo');
        $user->id_tipo_persona = $request->get('id_tipo_persona');
        $user->save();
        return response()->json('Datos actualizados');
    }

    public function changeTipoPersona (Request $request, $id){
        $user = User::find($id);
        if($user){
            try{
                $user->id_tipo_persona = $request->get('id_tipo_persona');
                $user->save();
                return response()->json('Correctamente cambiado tipo de usuario');
            }catch (\Exception $e){
                return response()->json($e, 200);
            }
        }else{
            return response()->json('Datos incorrectos, no sé a podido actualizar', 200);
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
        $user = User::find($id);
        $user->delete();

        return response()->json('Usuario eliminado correctamente');
    }
}
