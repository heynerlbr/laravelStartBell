<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use  App\Http\Controllers\UsuariosController;
use  App\Http\Controllers\rolesController;
use  App\Http\Controllers\EmpresasSistemasController;
use  App\Http\Controllers\HomeController; 
use  App\Http\Controllers\LugaresController; 
use  App\Http\Controllers\ElementosLugaresController; 
use  App\Http\Controllers\ReservasController; 
use  App\Http\Controllers\AuthController; 
//modelos para filemaker
use App\Models\User;
use App\Models\Role;
// use App\Models\preoperacionales;
// use App\Models\preoperacionales_lines;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    if (Auth::check()) {      
        $Tipouser = Auth::user()->roles->first()->name;       
        if ($Tipouser=='admin') {
            return redirect()->route('home');
        }else if ($Tipouser=='Conductor'){
            return redirect()->route('vistaConductor');
        }else{
            return redirect()->route('home');
        }
        // else {
        //     return redirect('/ordenes');    
        // }
    }
    return view('auth.login');
});
Auth::routes();
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/perfil', [HomeController::class, 'perfil'])->name('perfil');
Route::post('MostrarInformacionPerfil', [HomeController::class,'MostrarInformacionPerfil'])->middleware('auth');
Route::post('updatePassword', [HomeController::class,'updatePassword'])->middleware('auth');
Route::post('actualizarDatosPersonales', [HomeController::class,'actualizarDatosPersonales'])->middleware('auth');
Route::post('actualizarCorreoFacturacion', [HomeController::class,'actualizarCorreoFacturacion'])->middleware('auth');
Route::get('/vistaConductor', [HomeController::class, 'vistaConductor'])->name('vistaConductor');
Route::post('GuardarFilePerfil', [HomeController::class,'GuardarFilePerfil'])->middleware('auth');
// rutas para usuarios
Route::apiResource('usuarios', UsuariosController::class) ->middleware('auth');
Route::post('ListarUsuarios', [UsuariosController::class,'Listar'])->middleware('auth');
Route::post('ListarDocumetosUsuarios', [UsuariosController::class,'ListarDocumetosUsuarios'])->middleware('auth');
Route::post('EliminarUsuario', [UsuariosController::class,'Eliminar'])->middleware('auth');
Route::post('CrearUsuario', [UsuariosController::class,'Crear'])->middleware('auth');
Route::post('MostrarUsuario', [UsuariosController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarUsuario', [UsuariosController::class,'Actualizar'])->middleware('auth');
Route::post('obtenerSucursales', [UsuariosController::class,'obtenerSucursales'])->middleware('auth');
Route::post('actualizarFechaVencimiento', [UsuariosController::class,'actualizarFechaVencimiento'])->middleware('auth');
Route::post('enviarMailCreacionUsuario', [UsuariosController::class,'enviarMailCreacion'])->middleware('auth');
Route::post('guardarArchivoUsuario', [UsuariosController::class,'guardarArchivoUsuario'])->middleware('auth');
Route::post('GuardarDocumentoUsuario', [UsuariosController::class,'GuardarDocumentoUsuario'])->middleware('auth');
Route::post('EliminarDocumentoUsuario', [UsuariosController::class,'EliminarDocumentoUsuario'])->middleware('auth');
Route::post('ListarArchivosUsuario', [UsuariosController::class,'ListarArchivosUsuario'])->middleware('auth');
Route::post('obtenerIdCreacionUsuario', [UsuariosController::class,'obtenerIdCreacionUsuario'])->middleware('auth');
//rutas roles
Route::resource('roles', rolesController::class)->middleware('auth');
Route::post('ListarRoles', [rolesController::class,'Listar'])->middleware('auth');
Route::post('EliminarRole', [rolesController::class,'Eliminar'])->middleware('auth');
Route::post('CrearRole', [rolesController::class,'Crear'])->middleware('auth');
Route::post('MostrarRole', [rolesController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarRole', [rolesController::class,'Actualizar'])->middleware('auth');
//empresas sistema
Route::resource('empresas', EmpresasSistemasController::class)->middleware('auth');
Route::post('ListarEmpresaSistemas', [EmpresasSistemasController::class,'Listar'])->middleware('auth');
Route::post('EliminarEmpresaSistemas', [EmpresasSistemasController::class,'Eliminar'])->middleware('auth');
Route::post('CrearEmpresaSistemas', [EmpresasSistemasController::class,'Crear'])->middleware('auth');
Route::post('MostrarEmpresaSistemas', [EmpresasSistemasController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarEmpresaSistemas', [EmpresasSistemasController::class,'Actualizar'])->middleware('auth');
//
Route::get('lugares', [LugaresController::class,'index'])->middleware('auth');
Route::post('ListarLugares', [LugaresController::class,'Listar'])->middleware('auth');
Route::post('EliminarLugar', [LugaresController::class,'Eliminar'])->middleware('auth');
Route::post('CrearLugar', [LugaresController::class,'Crear'])->middleware('auth');
Route::post('MostrarLugar', [LugaresController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarLugar', [LugaresController::class,'Actualizar'])->middleware('auth');
//
Route::get('elementos', [ElementosLugaresController::class,'index'])->middleware('auth');
Route::post('ListarElementos', [ElementosLugaresController::class,'Listar'])->middleware('auth');
Route::post('EliminarElemento', [ElementosLugaresController::class,'Eliminar'])->middleware('auth');
Route::post('CrearElemento', [ElementosLugaresController::class,'Crear'])->middleware('auth');
Route::post('MostrarElemento', [ElementosLugaresController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarElemento', [ElementosLugaresController::class,'Actualizar'])->middleware('auth');
Route::post('MostrarElementosLugares', [ElementosLugaresController::class,'MostrarElementosLugares'])->middleware('auth');
Route::post('SubirImagenElemento', [ElementosLugaresController::class,'SubirImagenElemento'])->middleware('auth');
Route::post('ListarImagenesElemento', [ElementosLugaresController::class,'ListarImagenesElemento'])->middleware('auth');
Route::post('EliminarImagenElemento', [ElementosLugaresController::class,'EliminarImagenElemento'])->middleware('auth');
Route::post('SeleccionarImagenPrincipal', [ElementosLugaresController::class,'SeleccionarImagenPrincipal'])->middleware('auth');
//reservas elementos
Route::post('ListarReservasElemento', [ElementosLugaresController::class,'ListarReservasElemento'])->middleware('auth');
Route::post('CrearReservaElemento', [ElementosLugaresController::class,'CrearReservaElemento'])->middleware('auth');
Route::post('ObtenerReservaElemento', [ElementosLugaresController::class,'ObtenerReservaElemento'])->middleware('auth');
Route::post('ActualizarReservaElemento', [ElementosLugaresController::class,'ActualizarReservaElemento'])->middleware('auth');
Route::post('EliminarReservaElemento', [ElementosLugaresController::class,'EliminarReservaElemento'])->middleware('auth');
Route::post('CambiarEstadoReserva', [ElementosLugaresController::class,'CambiarEstadoReserva'])->middleware('auth');


//reservas
Route::get('reservas', [ReservasController::class,'index'])->middleware('auth');
Route::post('ListarReservas', [ReservasController::class,'Listar'])->middleware('auth');
Route::post('EliminarReserva', [ReservasController::class,'Eliminar'])->middleware('auth');
Route::post('CrearReserva', [ReservasController::class,'Crear'])->middleware('auth');
Route::post('MostrarReserva', [ReservasController::class,'Mostrar'])->middleware('auth');
Route::post('ActualizarReserva', [ReservasController::class,'Actualizar'])->middleware('auth');

//
Route::post('/auth/google', [AuthController::class, 'googleAuth']);
//rutas de limpieza
Route::get('/clear-cache', function() {
    echo Artisan::call('optimize');
    echo Artisan::call('route:clear');
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
// return "Cleared!";
//      return 'what you want';
});
//para host compartidos
Route::get('/storage-link', function () {
    $targetFolder=storage_path('app/public');
    $linkFolder=$_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder,$linkFolder);
});
