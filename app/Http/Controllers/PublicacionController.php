<?php

namespace App\Http\Controllers;

use App\Model\GaleriaPropiedad;
use App\Model\HabitacionPropiedad;
use App\Model\Propiedad;
use App\Model\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Publicacion;
use App\Model\CaracteristicasPropiedad;
use App\Model\RestriccionesPropiedad;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Object_;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publicacions = Publicacion::all();
        return response()->json($publicacions, 200);
    }
    public function createPublication(Request $request){
        //return response()->json($request->imagenprincipal, 200);
        $datalle =DB::transaction(function () use ($request) {
            try {
                $propiedad = $request->get('propiedad');
                $publicacion = $request;
                $propiedadSave = new Propiedad([
                    'direccion' => $propiedad['direccion'],
                    'longitud' => $propiedad['longitud'],
                    'latitud' => $propiedad['latitud'],
                    'precio' => $propiedad['precio'],
                    'moneda' => $propiedad['moneda'],
                    'id_tipo_propiedad' => $propiedad['id_tipo_propiedad'],
                    'metros_construidos' => $propiedad['metros_construidos'],
                    'superficie_terreno' => $propiedad['superficie_terreno'],
                    'id_zona' => $propiedad['id_zona'],
                    'created_at' => Carbon::now('America/Santiago')
                ]);
                $propiedadSave->save();
                $id_propiedad = $propiedadSave->id;
                // guardar las imagenes
                //comprobar si trae imagenes
                $imagenes = $request->images;
                for ($i = 0; $i < count($imagenes); ++$i) {
                    $exploded = explode(',', $imagenes[$i]);
                    $decode = base64_decode($exploded[1]);

                    if (Str::contains($exploded[0], 'jpeg'))
                        $extension = 'jpg';
                    else
                        $extension = 'png';
                    $fileName = Str::random(20) . '.' . $extension;

                    $path = storage_path() . '/app/public/gallery_products/' . $fileName;
                    file_put_contents($path, $decode);
                    $principal = false;
                    if ($i == $request->imagenprincipal){
                        $principal = true;
                    }
                    $imagen = new GaleriaPropiedad([
                        'id_propiedad' => $id_propiedad,
                        'url' => $fileName,
                        'principal' => $principal,
                        'created_at' => Carbon::now('America/Santiago')
                    ]);
                    $imagen->save();
                }
                //guardar habitaciones
                for ($i = 0; $i < count($propiedad['habitaciones']); $i++) {
                    $habitacion = new HabitacionPropiedad([
                        'id_propiedad' => $id_propiedad,
                        'id_habitacion' => $propiedad['habitaciones'][$i]['id_habitacion'],
                        'cantidad' => $propiedad['habitaciones'][$i]['cantidad']
                    ]);
                    $habitacion->save();
                }
                //guardar las caracteristicas
                for ($i = 0; $i < count($propiedad['caracteristicas']); $i++) {
                    $caracteristca = new CaracteristicasPropiedad ([
                        'id_propiedad' => $id_propiedad,
                        'id_caracteristica' => $propiedad['caracteristicas'][$i]
                    ]);
                    $caracteristca->save();
                }
                for ($i = 0; $i < count($propiedad['restricciones']); $i++) {
                    $restricciones = new RestriccionesPropiedad ([
                        'id_propiedad' => $id_propiedad,
                        'id_restriccion' => $propiedad['restricciones'][$i]
                    ]);
                    $restricciones->save();
                }
                $publicacionSave = new Publicacion([
                    'titulo' => $publicacion->get('titulo'),
                    'video' => $publicacion->get('video'),
                    'descripcion' => $publicacion->get('descripcion'),
                    'id_propiedad' => $id_propiedad,
                    'id_tipo_publi' => $publicacion->get('id_tipo_publi'),
                    'id_autor' => $publicacion->get('id_autor'),
                    'id_corredor' => $publicacion->get('id_corredor'),
                    'created_at' => Carbon::now('America/Santiago')
                ]);
                $publicacionSave->save();

            }catch (\PDOException  $e){
            return response()->json('error');
        }
        });
        return response()->json($datalle);
    }
    public function getPublicationsDestacadas(){
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->leftJoin('zonas', function ($join2) {
                    $join2->on('zonas.id', '=', DB::raw('(SELECT id FROM zonas WHERE zonas.id = propiedads.id_zona LIMIT 1)'));
                })
                ->leftJoin('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE comunas.id = zonas.id_comuna  LIMIT 1)'));
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE regions.id = comunas.id_region  LIMIT 1)'));
                })
                ->join('tipo_propiedads', 'propiedads.id_tipo_propiedad', '=', 'tipo_propiedads.id')
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'propiedads.direccion', 'propiedads.latitud', 'propiedads.longitud',
                    'propiedads.metros_construidos','zonas.id AS zona_id', 'zonas.nombre AS nombre_zona','zonas.descripcion_zona',
                    'tipo_propiedads.nombre AS nombre_tipo_propiedad', 'tipo_publicacions.nombre AS nombre_tipo_publi', 'comunas.id AS id_comuna', 'regions.id AS id_region')
                ->where('id_estado', '=', 3)
                ->inRandomOrder()
                ->limit(3)
                ->get();
            foreach ($publicacions as $item){
                $item->zona_state = true;
                $imagen = DB::table('galeria_propiedads')
                    ->select('galeria_propiedads.url')
                    ->where([['galeria_propiedads.id_propiedad', '=', $item->id_propiedad],
                        ['galeria_propiedads.principal', '=', 1]])
                    ->first();

                if($imagen != null){
                    $item->url = $imagen->url;
                }
            }
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getPublicationsDesactive (){
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
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
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'users.nombres',
                    'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                    'tipo_publicacions.nombre AS  publicaciontiponombre', 'comunas.nombre AS comuna', 'regions.nombre AS region')
                ->where('id_estado', '=', 4)
                ->orderBy('publicacions.id', 'desc')
                ->get();
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getPublicationsAutor ($id){
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
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
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'users.nombres',
                    'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                    'tipo_publicacions.nombre AS  publicaciontiponombre', 'comunas.nombre AS comuna', 'regions.nombre AS region')
                ->where([
                    ['publicacions.id_autor', '=', $id],
                    ['publicacions.id_estado', '!=', 2],
                ])
                ->orderBy('publicacions.id', 'desc')
                ->get();
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getPublicationsAcargo ($id){
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
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
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'users.nombres',
                    'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                    'tipo_publicacions.nombre AS  publicaciontiponombre', 'comunas.nombre AS comuna', 'regions.nombre AS region')
                ->where('publicacions.id_corredor', '=', $id)
                ->orderBy('publicacions.id', 'desc')
                ->get();
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getAllPublication ($id) {

        try{
            $publicacion = Publicacion::find($id);
            $id_propiedad = $publicacion->id_propiedad ;
            $propiedad = Propiedad::find($id_propiedad);
            $zona =  DB::table('zonas')
                ->select('zonas.*')
                ->where('zonas.id', '=', $propiedad->id_zona)
                ->first();
            $comuna = DB::table('comunas')
                ->select('nombre', 'id_region')
                ->where('comunas.id', '=', $zona->id_comuna)
                ->first();


            $restricciones = RestriccionesPropiedad::where('id_propiedad', $id_propiedad) -> get();
            $images = DB::table('galeria_propiedads')
                ->select('galeria_propiedads.url')
                ->where('galeria_propiedads.id_propiedad', '=', $propiedad->id)
                ->get();
            $caracteristicas = CaracteristicasPropiedad::where('id_propiedad', $id_propiedad) -> get('id_caracteristica');
            $habitaciones = HabitacionPropiedad::where('id_propiedad', $id_propiedad)
                ->leftJoin('habitacions', 'habitacions.id', '=', 'habitacion_propiedads.id_habitacion')
                -> select('habitacions.nombre', 'cantidad')->get();
            return response()->json([$propiedad, $publicacion, $restricciones, $caracteristicas, $images, $habitaciones, $zona, $comuna], 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getAllPublicationUpdate ($id) {
        // obtener la comuna, y region
        //middelware para controlar si el autor o el corredor esta editando la publicacion
        try{
            $publicacion = Publicacion::find($id);
            $id_propiedad = $publicacion->id_propiedad ;
            $propiedad = Propiedad::find($id_propiedad);
            $restricciones = RestriccionesPropiedad::where('id_propiedad', $id_propiedad) -> pluck('id_restriccion');
            $images = DB::table('galeria_propiedads')
                ->select('galeria_propiedads.url')
                ->where('galeria_propiedads.id_propiedad', '=', $propiedad->id)
                ->get();
            $propiedad->id_comuna = DB::table('comunas')
                ->join('zonas', 'zonas.id_comuna', '=', 'comunas.id')
                ->select('comunas.id' )
                ->where('zonas.id', '=', $propiedad->id_zona)
                ->pluck('id');
            $propiedad->id_comuna = $propiedad->id_comuna[0];
            $propiedad->id_region = DB::table('regions')
                ->join('comunas', 'regions.id', '=', 'comunas.id_region')
                ->select('regions.id' )
                ->where('comunas.id', '=', $propiedad->id_comuna)
                ->pluck('id');
            $propiedad->id_region = $propiedad->id_region[0];
            $caracteristicas = CaracteristicasPropiedad::where('id_propiedad', $id_propiedad) -> pluck('id_caracteristica');
            $habitaciones = HabitacionPropiedad::where('id_propiedad', $id_propiedad)
                ->leftJoin('habitacions', 'habitacions.id', '=', 'habitacion_propiedads.id_habitacion')
                -> select('habitacions.id AS id_habitacion', 'cantidad')->get();

            return response()->json([$propiedad, $publicacion, $restricciones, $caracteristicas, $images, $habitaciones], 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getAllsPublications () {
        try{

            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->leftJoin('zonas', function ($join2) {
                    $join2->on('zonas.id', '=', DB::raw('(SELECT id FROM zonas WHERE zonas.id = propiedads.id_zona LIMIT 1)'));
                })
                ->leftJoin('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE comunas.id = zonas.id_comuna  LIMIT 1)'));
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE regions.id = comunas.id_region  LIMIT 1)'));
                })
                ->join('tipo_propiedads', 'propiedads.id_tipo_propiedad', '=', 'tipo_propiedads.id')
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'propiedads.direccion', 'propiedads.moneda', 'propiedads.precio', 'propiedads.latitud', 'propiedads.longitud',
                    'propiedads.metros_construidos','zonas.id AS zona_id', 'zonas.nombre AS nombre_zona','zonas.descripcion_zona',
                    'tipo_propiedads.nombre AS nombre_tipo_propiedad', 'tipo_publicacions.nombre AS nombre_tipo_publi', 'comunas.id AS id_comuna', 'regions.id AS id_region')
                ->where('id_estado', '=', 1)
                ->orWhere('id_estado', '=', 3)
                ->orderBy('publicacions.id', 'desc')
                ->paginate(9);

            foreach ($publicacions as $item){
                $item->zona_state = true;
                $imagen = DB::table('galeria_propiedads')
                    ->select('galeria_propiedads.url')
                    ->where([['galeria_propiedads.id_propiedad', '=', $item->id_propiedad],
                        ['galeria_propiedads.principal', '=', 1]])
                    ->first();
                //  ->where('galeria_propiedads.id_propiedad', '=', $item->id_propiedad, 'AND', 'galeria_propiedads.principal', '=', 1)
                if($imagen != null){
                    $item->url = $imagen->url;
                }
            }
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function getAllsPublicationsAdmin () {
        if (auth()->user()->id_tipo_persona == 7){
            try{
                $publicacions = DB::table('publicacions')
                    ->leftJoin('propiedads', function ($join) {
                        $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
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
                    ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                    ->select('publicacions.*', 'users.nombres',
                        'zonas.nombre AS nombre_zona', 'tipo_propiedads.nombre AS tipopropiedadnombre',
                        'tipo_publicacions.nombre AS  publicaciontiponombre', 'comunas.nombre AS comuna', 'regions.nombre AS region')
                    ->orderBy('publicacions.id', 'desc')
                    ->get();
                return response()->json($publicacions, 200);
            }catch (\Exception $e){
                return response()->json($e, 404);
            }
        }else{
            return response()->json('error credenciales', 403);
        }

    }
    public function getAllsPublicationsFilter (Request $request ) {

        $minMetrosCons = $request->get('metrosConstruidos');
        $tipoMoneda = $request->get('tipoMoneda');
        $precio = $request->get('precio');
        $zonas = $request->get('zonas');
        $regiones = $request->get('regiones');
        $comunas = $request->get('comunas');
        $tipoPublicacion = $request->get('tipoPublicacion');
        try{
            $publicacions = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->leftJoin('zonas', function ($join2) {
                    $join2->on('zonas.id', '=', DB::raw('(SELECT id FROM zonas WHERE zonas.id = propiedads.id_zona LIMIT 1)'));
                })
                ->leftJoin('comunas', function ($join) {
                    $join->on('comunas.id', '=', DB::raw('(SELECT id FROM comunas WHERE comunas.id = zonas.id_comuna  LIMIT 1)'));
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', DB::raw('(SELECT id FROM regions WHERE regions.id = comunas.id_region  LIMIT 1)'));
                })
                ->join('tipo_propiedads', 'propiedads.id_tipo_propiedad', '=', 'tipo_propiedads.id')
                ->join('tipo_publicacions', 'publicacions.id_tipo_publi', '=', 'tipo_publicacions.id')
                ->select('publicacions.*', 'propiedads.direccion', 'propiedads.latitud', 'propiedads.longitud',
                    'propiedads.metros_construidos', 'propiedads.precio', 'propiedads.moneda','zonas.id AS zona_id', 'zonas.nombre AS nombre_zona','zonas.descripcion_zona',
                    'tipo_propiedads.nombre AS nombre_tipo_propiedad', 'tipo_publicacions.nombre AS nombre_tipo_publi', 'comunas.id AS id_comuna', 'regions.id AS id_region')
                ->whereBetween('propiedads.metros_construidos', [$minMetrosCons, 3000000])
                ->whereBetween('propiedads.precio', [$precio, 99000000000])
                ->where('propiedads.moneda', $tipoMoneda)
                ->whereIn('id_estado', [1,3])
                ->whereIn('zonas.id', $zonas)
                ->whereIn('regions.id', $regiones)
                ->whereIn('comunas.id', $comunas)
                ->whereIn('publicacions.id_tipo_publi', $tipoPublicacion)
                ->orderBy('publicacions.id', 'desc')
                ->paginate(9);

            /*
            $publicacinesRegiones = [];
            $publicacinesComunas = [];
            $publicacinesZonas = [];
            if(sizeof($regiones)>0){
                for ($i = 0 ; $i<sizeof($publicacions); $i++){
                    for ($j = 0 ; $j<sizeof($regiones); $j++){
                        if($regiones[$j] == $publicacions[$i]->id_region){
                            array_push($publicacinesRegiones, $publicacions[$i]);
                        }
                    }
                }
                $publicacions = $publicacinesRegiones;
            }
            if(sizeof($comunas)>0){
                for ($i = 0 ; $i<sizeof($publicacions); $i++){
                    for ($j = 0 ; $j<sizeof($comunas); $j++){
                        if($comunas[$j] == $publicacions[$i]->id_comuna){
                            array_push($publicacinesComunas, $publicacions[$i]);
                        }
                    }
                }
                $publicacions = $publicacinesComunas;
            }
            if(sizeof($zonas)>0){
                for ($i = 0 ; $i<sizeof($publicacions); $i++){
                    for ($j = 0 ; $j<sizeof($zonas); $j++){
                        if($zonas[$j] == $publicacions[$i]->zona_id){
                            array_push($publicacinesZonas, $publicacions[$i]);
                        }
                    }
                }
                $publicacions = $publicacinesZonas;
            }
            for ($i = 0 ; $i<sizeof($publicacions); $i++){
                if($publicacions[$i]->id_estado == 2 || $publicacions[$i]->id_estado == 4 ){
                    unset($publicacions[$i]);
                }
            }
            foreach ($publicacions as $item){
                $item->zona_state = true;
                $imagen = DB::table('galeria_propiedads')
                    ->select('galeria_propiedads.url')
                    ->where('galeria_propiedads.id_propiedad', '=', $item->id_propiedad)
                    ->first();
                if($imagen != null){
                    $item->url = $imagen->url;
                }
            }*/
            foreach ($publicacions as $item) {
                $item->zona_state = true;
                $imagen = DB::table('galeria_propiedads')
                    ->select('galeria_propiedads.url')
                    ->where([['galeria_propiedads.id_propiedad', '=', $item->id_propiedad],
                        ['galeria_propiedads.principal', '=', 1]])
                    ->first();
                /*$imagen = DB::table('galeria_propiedads')
                    ->select('galeria_propiedads.url')
                    ->where('galeria_propiedads.id_propiedad', '=', $item->id_propiedad)
                    ->first();*/
                if ($imagen != null) {
                    $item->url = $imagen->url;
                }
            }
            return response()->json($publicacions, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'video','descripcion', 'id_propiedad', 'id_estado', 'id_tipo_publi', 'id_autor', 'id_corredor'
        $publicacion = new Publicacion([
            'video' => $request->get('video'),
            'descripcion' => $request->get('descripcion'),
            'id_propiedad' => $request->get('id_propiedad'),
            'id_estado' => $request->get('id_estado'),
            'id_tipo_publi' => $request->get('id_tipo_publi'),
            'id_autor' => $request->get('id_autor'),
            'id_corredor' => $request->get('id_corredor'),
            'created_at' => Carbon::now('America/Santiago')
        ]);
        $publicacion->save();
        return response()->json('success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicacion::find($id);
        return response()->json($publicacion, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePublication(Request $request, $id)
    {
        if($request->get('id_corredor') == auth()->id() || $request->get('id_autor') == auth()->id() || auth()->user()->id_tipo_persona == 7){
            // hacer una transaccion para que la actualizacion se realize de manera segura
            $idPropiedad = $request->get('id_propiedad');
            $propiedadUpdade = $request->get('propiedad');
            $publicacion = $request;


            //  eliminar los datos de las tablas de muchos a muchos inculidas las imagenes
            $restricciones =  DB::table('restricciones_propiedads')
                ->select('*')
                ->where('restricciones_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            $habitaciones =  DB::table('habitacion_propiedads')
                ->select('*')
                ->where('habitacion_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            // return response()->json($restricciones, 200);
            $caracteristicas =  DB::table('caracteristicas_propiedads')
                ->select('*')
                ->where('caracteristicas_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();

            // evaluamos si se modificaron las imagenes
            if($request->get('isNewImage')){
                $imagenes = DB::table('galeria_propiedads')
                    ->select('*')
                    ->where('galeria_propiedads.id_propiedad', '=', $idPropiedad)
                    ->get();
                foreach ($imagenes as $image) {
                    $path = public_path() . '/gallery_products/' . $image->url;

                    if(file_exists($path)){
                        //File::delete($image_path);
                        File::delete( $path);
                    }
                }

                $galeria = DB::table('galeria_propiedads')
                    ->select('*')
                    ->where('galeria_propiedads.id_propiedad', '=', $idPropiedad)
                    ->delete();

                // creamos los campos de las tablas de muchos a muchos
                $imagenes = $request->images;

                for ($i = 0; $i < count($imagenes); ++$i) {
                    $exploded = explode(',', $imagenes[$i]);
                    $decode = base64_decode($exploded[1]);

                    if (Str::contains($exploded[0], 'jpeg'))
                        $extension = 'jpg';
                    else
                        $extension = 'png';
                    $fileName = Str::random(20) . '.' . $extension;

                    $path = storage_path() . '/app/public/gallery_products/' . $fileName;
                    file_put_contents($path, $decode);
                    $principal = false;
                    if ($i == $request->imagenprincipal){
                        $principal = true;
                    }

                    $imagen = new GaleriaPropiedad([
                        'id_propiedad' => $idPropiedad,
                        'url' => $fileName,
                        'principal' => $principal,
                        'created_at' => Carbon::now('America/Santiago')
                    ]);
                    $imagen->save();
                }
            }else{
                $imagenes = $request->images;
                $imagenesDB =  DB::table('galeria_propiedads')
                    ->select('*')
                    ->where('galeria_propiedads.id_propiedad', '=', $idPropiedad)
                    ->get();
                for ($i = 0; $i < count($imagenes); ++$i) {
                    $principal = false;
                    if ($i == $request->imageMain){
                        $imagen =  DB::table('galeria_propiedads')
                            ->where('galeria_propiedads.url', $imagenesDB[$i]->url)
                            ->update(['galeria_propiedads.principal' =>  true]);
                    }else{
                        $imagen =  DB::table('galeria_propiedads')
                            ->where('galeria_propiedads.url', $imagenesDB[$i]->url)
                            ->update(['galeria_propiedads.principal' =>  false]);
                    }


                }
            }

            //guardar habitaciones
            for ($i = 0; $i < count($propiedadUpdade['habitaciones']); $i++) {
                $habitacion = new HabitacionPropiedad([
                    'id_propiedad' => $idPropiedad,
                    'id_habitacion' => $propiedadUpdade['habitaciones'][$i]['id_habitacion'],
                    'cantidad' => $propiedadUpdade['habitaciones'][$i]['cantidad']
                ]);
                $habitacion->save();
            }
            //guardar las caracteristicas
            for ($i = 0; $i < count($propiedadUpdade['caracteristicas']); $i++) {
                $caracteristca = new CaracteristicasPropiedad ([
                    'id_propiedad' => $idPropiedad,
                    'id_caracteristica' => $propiedadUpdade['caracteristicas'][$i]
                ]);
                $caracteristca->save();
            }
            for ($i = 0; $i < count($propiedadUpdade['restricciones']); $i++) {
                $restricciones = new RestriccionesPropiedad ([
                    'id_propiedad' => $idPropiedad,
                    'id_restriccion' => $propiedadUpdade['restricciones'][$i]
                ]);
                $restricciones->save();
            }

            // actualizamos los datos de la propiedad
            $propiedad = Propiedad::find($idPropiedad);
            $propiedad->precio = $propiedadUpdade['precio'];
            $propiedad->moneda = $propiedadUpdade['moneda'];
            $propiedad->direccion = $propiedadUpdade['direccion'];
            $propiedad->latitud = $propiedadUpdade['latitud'];
            $propiedad->longitud = $propiedadUpdade['longitud'];
            $propiedad->metros_construidos = $propiedadUpdade['metros_construidos'];
            $propiedad->superficie_terreno = $propiedadUpdade['superficie_terreno'];
            $propiedad->id_tipo_propiedad = $propiedadUpdade['id_tipo_propiedad'];
            $propiedad->id_zona = $propiedadUpdade['id_zona'];
            $propiedad->updated_at = Carbon::now('America/Santiago');
            $propiedad->save();

            // Actualizamos los datos de publicaciones
            $publicacion = Publicacion::find($id);
            $publicacion->video = $request->get('video');
            $publicacion->titulo = $request->get('titulo');
            $publicacion->descripcion = $request->get('descripcion');
            $publicacion->id_propiedad = $request->get('id_propiedad');
            $publicacion->id_estado = $request->get('id_estado');
            $publicacion->id_tipo_publi = $request->get('id_tipo_publi');
            $publicacion->id_autor = $request->get('id_autor');
            $publicacion->id_corredor = $request->get('id_corredor');
            $publicacion->updated_at = Carbon::now('America/Santiago');
            $publicacion->save();

            return response()->json('success', 200);
        }else{
            return response()->json('error', 404);
        }



    }

    public function changeStatePublication(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);
        $publicacion->id_estado = 1;
        $publicacion->id_corredor = $request[0];
        $publicacion->save();
        return $this->getPublicationsDesactive();
    }
    public  function  maxMetrosConstruidos (){
        try{
            $max = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->whereIn('id_estado', [1,3])
                ->max('propiedads.metros_construidos');

            $priceCLPMax = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->whereIn('id_estado', [1,3])
                ->whereIn('propiedads.moneda', ['clp'])
                ->max('propiedads.precio');
            $priceUFMax = DB::table('publicacions')
                ->leftJoin('propiedads', function ($join) {
                    $join->on('propiedads.id', '=', DB::raw('(SELECT id FROM propiedads WHERE publicacions.id_propiedad = propiedads.id LIMIT 1)'));
                })
                ->whereIn('id_estado', [1,3])
                ->whereIn('propiedads.moneda', ['uf'])
                ->max('propiedads.precio');
            $maximos = new Object_();
            $maximos->maxMetrosConstruidos = $max;
            $maximos->maxCLP = $priceCLPMax;
            $maximos->maxUF = $priceUFMax;
            return response()->json($maximos, 200);
        }catch (\Exception $e){
            return response()->json($e, 404);
        }
    }
    public function publicationDesactivate($id)
    {
        $publicacion = Publicacion::find($id);
        $publicacion->id_estado = 4;
        $publicacion->save();
        return $this->getAllsPublicationsAdmin();
    }
    public function activeDestacatePublication($id){
        $publicacion = Publicacion::find($id);
        $publicacion->id_estado = 3;
        $publicacion->save();
        return response()->json('success', 200);
    }
    public function descativeDestacatePublication($id){
        $publicacion = Publicacion::find($id);
        $publicacion->id_estado = 1;
        $publicacion->save();
        return response()->json('success', 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAllPublication($id)
    {
        if (auth()->user()->id_tipo_persona == 7) {
            $publicacion = Publicacion::find($id);
            $idPropiedad = $publicacion->id_propiedad;
            $propiedad = Propiedad::find($idPropiedad);
            $restricciones = DB::table('restricciones_propiedads')
                ->select('*')
                ->where('restricciones_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            $habitaciones = DB::table('habitacion_propiedads')
                ->select('*')
                ->where('habitacion_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            // return response()->json($restricciones, 200);
            $caracteristicas = DB::table('caracteristicas_propiedads')
                ->select('*')
                ->where('caracteristicas_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            $imagenes = DB::table('galeria_propiedads')
                ->select('*')
                ->where('galeria_propiedads.id_propiedad', '=', $idPropiedad)
                ->get();
            foreach ($imagenes as $image) {
                $path = public_path() . '/gallery_products/' . $image->url;

                if (file_exists($path)) {
                    //File::delete($image_path);
                    File::delete($path);
                }
            }

            $galeria = DB::table('galeria_propiedads')
                ->select('*')
                ->where('galeria_propiedads.id_propiedad', '=', $idPropiedad)
                ->delete();
            //return response()->json($propiedad, 200);
            $venta = DB::table('ventas')
                ->select('*')
                ->where('ventas.id_publicacion', '=', $id)
                ->delete();
            $propiedad->delete();
            $publicacion->delete();

            return $this->getAllsPublicationsAdmin();
        }else{
            return response()->json('error credenciales', 404);
        }
    }

    public  function  getPublicacionActiva(){
        $publicaciones = Publicacion::where('id_estado', 1);
        return response()->json($publicaciones, 200);
    }
    public  function  getPublicacionDestacada(){
        $publicaciones = Publicacion::where('id_estado', 3);
        return response()->json($publicaciones, 200);
    }
    public  function  getPublicacionVendida(){
        $publicaciones = Publicacion::where('id_estado', 2);
        return response()->json($publicaciones, 200);
    }
    public  function  getPublicacionDesactiva(){
        $publicaciones = Publicacion::where('id_estado', 4);
        return response()->json($publicaciones, 200);
    }
    /*public  function  getPublicacionPorUsuario(){
        $publicaciones = Publicacion::where('id_autor');
        return response()->json($publicaciones, 200);
    }*/

}
