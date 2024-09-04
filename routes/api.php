<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UsuariosController;
use  App\Http\Controllers\ApiController;
use App\Http\Controllers\ProgramacionesasesoresController;
use App\Http\Controllers\MyReservasController;
use App\Http\Controllers\ElementosReservablesController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('CancelarReservaApi', [MyReservasController::class,'CancelarReservaApi']);
Route::post('obtenerMisReservasApi', [MyReservasController::class,'Listar']);
Route::post('CrearReservaApi', [ElementosReservablesController::class,'Crear']);
Route::post('validarDiaApi', [ElementosReservablesController::class,'validarDiaApi']);
Route::post('obtenerInformacionElemento', [ApiController::class,'obtenerInformacionElemento']);
Route::post('obtenerElementosFiltrados', [ApiController::class,'obtenerElementosFiltrados']);
Route::post('obtenerlugaresFiltrados', [ApiController::class,'obtenerlugaresFiltrados']);
Route::post('buscarTiposResevas', [ApiController::class,'buscarTiposResevas']);
Route::post('buscarMunicipios', [ApiController::class,'buscarMunicipios']);
Route::post('LoginMovil', [UsuariosController::class,'LoginMovil']);
Route::post('RegisterMovil', [UsuariosController::class,'RegisterMovil']);
Route::get('getMunicipios', [ApiController::class,'getMunicipios']);
Route::get('getDepartamentos', [ApiController::class,'getDepartamentos']);

Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::post('ProfileMovil', [UsuariosController::class,'ProfileMovil']);
    Route::post('LogOutMovil', [UsuariosController::class,'LogOutMovil']);

});

Route::get('ListarApiProgramaciones/{fecha}', [ProgramacionesasesoresController::class,'ListarApiProgramaciones']);
Route::post('validarUsuario', [UsuariosController::class,'validarUsuario']);

Route::post('/ApitraerOpcionesClientes', [ProgramacionesasesoresController::class,'ApitraerOpcionesClientes']);


Route::get('/test-api-connection', function () {
    return response()->json(['message' => 'Conexión exitosa a la API de Laravel desde React Native'], 200);
});


Route::post('/auth/google', [AuthController::class, 'googleAuth']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
