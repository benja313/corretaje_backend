<?php

use App\Http\Controllers\VentaController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CaracteristicasController;
use App\Http\Controllers\ComunaController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'API\RegisterController@login');
Route::get('login1', 'API\RegisterController@login1');
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    Route::resource('zonas', 'ZonaController');
});*/

Route::middleware('auth:api')->group( function () {
    Route::put('changeTipoPersona/{id}', 'UserController@changeTipoPersona');
    Route::post('createNewPublication', 'PublicacionController@createPublication');
    Route::put('getCuentaUser/{id}', 'CuentaBancariaController@getCuentaUser');
    Route::resource('venta', 'VentaController');
    Route::get('showAllSales/{id}', 'VentaController@showAllSales');
    Route::get('showAllSalesCargo/{id}', 'VentaController@showAllSalesCargo');
    Route::put('updatePublication/{id}', 'PublicacionController@updatePublication');
    Route::put('changeStatePublication/{id}', 'PublicacionController@changeStatePublication');
    Route::put('changeStatePublication/{id}', 'PublicacionController@changeStatePublication');
    Route::put('activeDestacatePublication/{id}', 'PublicacionController@activeDestacatePublication');
    Route::put('desactiveDestacatePublication/{id}', 'PublicacionController@desactiveDestacatePublication');
    Route::get('getAllsPublicationsAdmin', 'PublicacionController@getAllsPublicationsAdmin')->middleware('auth', 'role:7');
    Route::delete('deletePublication/{id}', 'PublicacionController@deleteAllPublication')->middleware('auth', 'role:7');
    Route::get('getPublicationsDesactive', 'PublicacionController@getPublicationsDesactive');
    Route::get('getPublicationsAutor/{id}', 'PublicacionController@getPublicationsAutor');
    Route::get('getPublicationsAcargo/{id}', 'PublicacionController@getPublicationsAcargo');
    Route::resource('bancos', 'BancoController');

});
Route::get('getAllPublicationUpdate/{id}', 'PublicacionController@getAllPublicationUpdate');
//Route::get('getAllPublicationUpdate/{id}', 'PublicacionController@getAllPublicationUpdate');//->middleware('role:"7"');
Route::resource('users', 'UserController');
// Route::resource('users', 'UserController');
Route::resource('zonas', 'ZonaController');
Route::resource('regiones', 'RegionController');
Route::resource('comunas', 'ComunaController');
Route::get('getContact/{id}', 'UserController@getContact');

Route::resource('tipoCuentasBancarias', 'TipoCuentaBanController');
Route::resource('cuentasBancarias', 'CuentaBancariaController');
Route::get('getComunasInRegion/{id}', 'ComunaController@showComunasRegion');
Route::get('getZonaInComuna/{id}', 'ZonaController@getZonaInComuna');
Route::get('getAllRegionesState', 'RegionController@getAllRegionesState');
Route::get('getAllComunasState', 'ComunaController@getAllComunasState');
Route::resource('caracteristicas', 'CaracteristicasController');
Route::get('getAllCaracteristicasState', 'CaracteristicasController@getAllCaracteristicasState');
Route::resource('restricciones', 'RestriccionController');
Route::resource('sexos', 'SexoController');
Route::resource('tipoPropiedad', 'TipoPropiedadController');
Route::get('getAllZonasComunaRegion', 'ZonaController@getAllZonasComunaRegion');
Route::get('getAllZonasState', 'ZonaController@getAllZonasState');
Route::resource('tipoPublicacion', 'TipoPublicacionController');
Route::get('getAllPublication/{id}', 'PublicacionController@getAllPublication');
Route::get('getAllsPublications', 'PublicacionController@getAllsPublications');
Route::post('getAllsPublicationsFilter', 'PublicacionController@getAllsPublicationsFilter');
Route::get('getPublicationsDestacadas', 'PublicacionController@getPublicationsDestacadas');
Route::get('publicationDesactivate/{id}', 'PublicacionController@publicationDesactivate');
Route::get('maxMetrosConstruidos', 'PublicacionController@maxMetrosConstruidos');
Route::resource('tipoPersona','TipoPersonaController');
Route::resource('habitaciones','HabitacionController');
