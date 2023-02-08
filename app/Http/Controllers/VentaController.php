<?php

namespace App\Http\Controllers;

use App\Model\Publicacion;
use App\Model\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class VentaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Venta::all();
        return response()->json($ventas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $venta = new Venta([
            'precio_transado' => $request->get('precio_transado'),
            'comision' => $request->get('comision'),
            'id_publicacion' => $request->get('id_publicacion'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $publicacion = Publicacion::find($request->get('id_publicacion'));
        $publicacion->id_estado = 2;
        $publicacion->save();
        $venta->save();
        $ventas = Venta::all();
        return response()->json($ventas, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = Venta::find($id);
        return response()->json($venta, 200);
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
        $venta = Venta::find($id);
        $venta->precio_transado = $request->get('precio_transado');
        $venta->comision = $request->get('comision');
        $venta->pagado_autor = $request->get('pagado_autor');
        $venta->id_publicacion = $request->get('id_publicacion');
        $venta->updated_at = Carbon::now('America/Santiago');
        $venta->save();
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
        $venta = Venta::find($id);
        $venta->delete();
        return response()->json('success', 200);
    }
    public function showAllSales($idUser){
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->rightJoin('ventas', function ($join) {
                    $join->on('ventas.id_venta', '=', DB::raw('(SELECT id_venta FROM ventas WHERE ventas.id_publicacion = publicacions.id LIMIT 1)'));
                })
                ->leftJoin('zonas', function ($join2) {
                    $join2->on('zonas.id', '=', DB::raw('(SELECT id FROM zonas WHERE zonas.id = propiedads.id_zona LIMIT 1)'));
                })
                ->leftJoin('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE comunas.id = zonas.id_comuna  LIMIT 1)'));
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE regions.id = comunas.id_region  LIMIT 1)'));
                })->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', DB::raw('(SELECT id FROM users WHERE users.id = publicacions.id_autor  LIMIT 1)'));
                })
                ->join('tipo_propiedads', 'propiedads.id_tipo_propiedad', '=', 'tipo_propiedads.id')
                ->select('publicacions.*', 'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                    'comunas.nombre AS comuna', 'regions.nombre AS region', 'ventas.pagado_autor')
                ->where([
                    ['publicacions.id_autor', '=', $idUser],
                    ['publicacions.id_estado', '=', 2]
                ])
                ->orderBy('publicacions.id', 'desc')
                ->get();
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function showAllSalesCargo($idUser)
    {
        try {
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->rightJoin('ventas', function ($join) {
                    $join->on('ventas.id_venta', '=', DB::raw('(SELECT id_venta FROM ventas WHERE ventas.id_publicacion = publicacions.id LIMIT 1)'));
                })
                ->leftJoin('zonas', function ($join2) {
                    $join2->on('zonas.id', '=', DB::raw('(SELECT id FROM zonas WHERE zonas.id = propiedads.id_zona LIMIT 1)'));
                })
                ->leftJoin('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE comunas.id = zonas.id_comuna  LIMIT 1)'));
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE regions.id = comunas.id_region  LIMIT 1)'));
                })->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', DB::raw('(SELECT id FROM users WHERE users.id = publicacions.id_autor  LIMIT 1)'));
                })
                ->join('tipo_propiedads', 'propiedads.id_tipo_propiedad', '=', 'tipo_propiedads.id')
                ->select('publicacions.*', 'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                    'comunas.nombre AS comuna', 'regions.nombre AS region', 'ventas.pagado_autor')
                ->where([
                    ['publicacions.id_corredor', '=', $idUser],
                    ['publicacions.id_estado', '=', 2]
                ])
                ->orderBy('publicacions.id', 'desc')
                ->get();
            return response()->json($publicacions, 200);
        } catch (\Exception $e) {
            return response()->json($e, 404);
        }
    }
}
