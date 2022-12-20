<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//administracion
use App\Http\Controllers\administracion;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProvedorController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\ProductoAlmacenController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\TemporalInventarioController;

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
    // return view('welcome');
    return redirect('/');
});

Route::get('/', [FrontController::class,'index']);
Route::get('cargarcategoria/{id}',[FrontController::class,'cargarcategoria'])->name('cargar.categoria');

//Envio de Correo
Route::get('contactanos',[ContactanosController::class,'index'])->name('contactanos.index');
Route::post('contactanos',[ContactanosController::class,'store'])->name('contactanos.store');

//Carrito de compras
Route::post('/card-add}', [CartController::class,'add'])->name('cart.add');
Route::get('/carrito-agregar/{id}', [CartController::class,'agregar'])->name('cart.agregar');
Route::get('/carrito-leer', [CartController::class,'leer'])->name('cart.leer');

Route::get('/card-checkout', [CartController::class,'cart'])->name('cart.checkout');
Route::post('/card-clear', [CartController::class,'clear'])->name('cart.clear');
Route::post('/card-removeitem', [CartController::class,'removeitem'])->name('cart.removeitem');
Route::post('/card-update', [CartController::class,'update'])->name('cart.update');

Auth::routes();
//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('perfil/{user}', [App\Http\Controllers\HomeController::class, 'perfil']);
Route::post('perfil/update/{user}', [App\Http\Controllers\HomeController::class, 'perfilupdate']);
Route::post('perfil/update/password/{user}', [App\Http\Controllers\HomeController::class, 'perfilupdatepassword']);

//administracion de usuario
Route::get('administracion', [administracion::class,'index']);
Route::get('administracion/usuarios/eliminados', [administracion::class,'eliminados']);
Route::get('administracion/usuarios/create', [administracion::class,'create']);
Route::get('administracion/usuarios/restaurar/{id}',[ administracion::class , 'restaurar']);
Route::get('administracion/usuarios/destroy/{id}',[ administracion::class , 'destroy']);
Route::post('administracion/usuarios/store', [administracion::class,'store']);
Route::get('administracion/usuarios/edit/{id}', [administracion::class,'edit']);// ->can('administracion');
Route::post('administracion/usuarios/update/{id}', [administracion::class,'update']);

//roles
Route::get('administracion/roles', [administracion::class,'indexROL']);
Route::get('administracion/roles/create', [administracion::class,'createROL']);
Route::post('administracion/roles/store', [administracion::class,'storeROL']);
Route::get('administracion/roles/destroy/{id}',[ administracion::class , 'destroyROL']);
Route::get('administracion/roles/eliminados', [administracion::class,'eliminadosROL']);
Route::get('administracion/roles/restaurar/{id}',[ administracion::class , 'restaurarROL']);
Route::get('administracion/roles/edit/{id}', [administracion::class,'editROL']);
Route::post('administracion/roles/update/{id}', [administracion::class,'updateROL']);
//permiso

Route::get('administracion/permisos/{id}', [administracion::class,'indexPERMISO']);
Route::post('administracion/permisos/update/{id}', [administracion::class,'updatePERMISO']);

//clientes
Route::controller(ClienteController::class)->group(function (){
    Route::get('administracion/cliente','index');
    Route::get('administracion/cliente/edit/{id}','edit');
    Route::post('administracion/cliente/update/{cliente}','update');
    Route::get('administracion/cliente/destroy/{cliente}','destroy');
    Route::get('administracion/cliente/eliminados','eliminados');
    Route::get('administracion/cliente/restaurar/{cliente}','restaurar');
});

// Categorias
Route::controller(CategoriaController::class)->group(function (){
    Route::get('/categoria','index');
    Route::get('/categoria/create','create');
    Route::post('/categoria/store','store');
    Route::get('/categoria/edit/{id}','edit');
    Route::put('/categoria/update/{id}','update');
    Route::get('/categoria/destroy/{id}','destroy');
    Route::get('/categoria/eliminados','deletes');
    Route::get('/categoria/restaurar/{id}','restore');
});
// Productos
Route::controller(ProductoController::class)->group(function (){
    Route::get('/producto','index');
    Route::get('/producto/create','create');
    Route::post('/producto/store','store');
    Route::get('/producto/edit/{id}','edit');
    Route::put('/producto/update/{id}','update');
    Route::get('/producto/destroy/{id}','destroy');
    Route::get('/producto/eliminados','deletes');
    Route::get('/producto/restaurar/{id}','restore');
    Route::get('producto/receta','receta');
    Route::post('producto/receta/generar','generar');
    Route::get('producto/receta/verreceta/{producto}','detallereceta');
    Route::get('producto/receta/eliminar/{producto}','destroyreceta');
});
// Almacenes
Route::controller(AlmacenController::class)->group(function (){
    Route::get('/administracion/almacen','index')->name('almacen.index');
    Route::get('/administracion/almacen/create','create')->name('almacen.create');
    Route::post('/administracion/almacen/store','store')->name('almacen.store');
    Route::get('/administracion/almacen/edit/{id}','edit')->name('almacen.edit');
    Route::put('/administracion/almacen/update/{id}','update')->name('almacen.update');
    Route::get('/administracion/almacen/destroy/{id}','destroy')->name('almacen.destroy');
    Route::get('/administracion/almacen/eliminados','deletes')->name('almacen.deletes');
    Route::get('/administracion/almacen/restaurar/{id}','restore')->name('almacen.restore');
});

//Inventario
Route::controller(ProductoAlmacenController::class)->group(function (){
    Route::get('/administracion/inventario','index')->name('inventario.index');
    Route::get('/administracion/inventario/create','create')->name('inventario.create');
    Route::post('/administracion/inventario/store','store')->name('inventario.store');
    Route::get('/administracion/buscar/{code}','buscarporcodigo');
});

//Temporal Tabla inventario
Route::controller(TemporalInventarioController::class)->group(function (){
    Route::post('/temporalinventario/insertar','insertar');
    Route::get('/temporalinventario/eliminar/{id}','eliminar');
    Route::get('/temporalinventario/vaciar','vaciar');
});

//provedores
Route::controller(ProvedorController::class)->group(function (){
    Route::get('provedor','index')->name('provedor');
    Route::get('provedor/create','create');
    Route::post('provedor/store','store');
    Route::get('provedor/edit/{provedor}/{sw}','edit');
    Route::post('provedor/update/{provedor}','update');
    Route::get('provedor/destroy/{provedor}','destroy');
    Route::get('provedor/eliminados','deletes');
    Route::get('provedor/restaurar/{provedor}','restore');
});
//ingrediente
Route::controller(IngredienteController::class)->group(function (){
    Route::get('ingrediente','index')->name('ingrediente');
    Route::get('ingrediente/create','create');
    Route::post('ingrediente/store','store');
    Route::get('ingrediente/edit/{ingrediente}','edit');
    Route::post('ingrediente/update/{ingrediente}','update');
    Route::get('ingrediente/destroy/{ingrediente}','destroy');
    Route::get('ingrediente/eliminados','deletes');
    Route::get('ingrediente/restaurar/{ingrediente}','restore');
});

//repartidor
Route::controller(RepartidorController::class)->group(function (){
    Route::get('administracion/repartidor','index')->name('repartidor');
    Route::get('administracion/repartidor/create','create');
    Route::post('administracion/repartidor/store','store');
    Route::get('administracion/repartidor/edit/{repartidor}','edit');
    Route::post('administracion/repartidor/update/{repartidor}','update');
    Route::get('administracion/repartidor/destroy/{repartidor}','destroy');
    Route::get('administracion/repartidor/eliminados','deletes');
    Route::get('administracion/repartidor/restaurar/{repartidor}','restore');
    //Pedidos dirigido al repartidor
    Route::get('/solicitudes','solucitudpedidos')->name('pedidos.solicitudes');
    Route::put('/delivery/update','cambiarestado')->name('pedido.estado');
    Route::get('administracion/repartidor/restaurar/{repartidor}','restore');
});

//empleado
Route::controller(EmpleadoController::class)->group(function (){
    Route::get('administracion/empleado','index')->name('empleado');
    Route::get('administracion/empleado/create','create');
    Route::post('administracion/empleado/store','store');
    Route::get('administracion/empleado/edit/{empleado}','edit');
    Route::post('administracion/empleado/update/{empleado}','update');
    Route::get('administracion/empleado/destroy/{empleado}','destroy');
    Route::get('administracion/empleado/eliminados','deletes');
    Route::get('administracion/empleado/restaurar/{empleado}','restore');
});

//Pedido
Route::controller(PedidoController::class)->group(function (){
    Route::get('/pedido','index')->name('pedido.index');
    Route::post('/pedido/store','store')->name('pedido.store');
    Route::post('/pedido/editar','update')->name('pedido.update');
    Route::get('/pedido/ordenes','orders')->name('pedido.ordenes');
    Route::put('/pedido/cancelar','cancelarsolicitud')->name('pedido.cancelar');
});

//producciones
Route::controller(ProduccionController::class)->group(function (){
    Route::get('administracion/produccion','index')->name('produccion');
    Route::get('administracion/produccion/create','create');
    Route::post('administracion/produccion/store','store');
    Route::get('administracion/produccion/{id_produccion}/{fecha}','produccion');
    Route::post('administracion/produccion/generar/{id_produccion}','generar');
    Route::get('verproductos/{produccion}','verdetalle')->name('produccion.verdetalle');
    Route::get('eliminar/{produccion}','destroyproduccion')->name('produccion.destroyproduccion');
    Route::get('anular/{produccion}','anularproduccion')->name('produccion.anularproduccion');
    Route::get('terminar/{produccion}','terminarproduccion')->name('produccion.terminarproduccion');
});

