<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// });


Route::prefix('/categorias')->group(function () {
    Route::get('/', [CategoriasController::class, 'index'])->name('listar-categoria');
    Route::post('/', [CategoriasController::class, 'crear'])->name('crear-categoria');
    Route::delete('/{id}', [CategoriasController::class, 'eliminar'])->name('eliminar-categoria');
    Route::put('/{id}', [CategoriasController::class, 'modificar'])->name('modificar-categoria');
});

Route::prefix('ventas')->group(function () {
    Route::post('/crear/{idProducto}', [VentasController::class, 'crear'])->name('crear-venta');
    Route::delete('/eliminar/{ventaId}', [VentasController::class, 'eliminar'])->name('eliminar-venta');
    Route::post('/informes', [VentasController::class, 'informes'])->name('informe-ventas');
});

Route::prefix('/productos')->group(function() {
    Route::get('/', [ProductosController::class, 'index'])->name('listar-productos');
    Route::get('/{idProducto}', [ProductosController::class, 'producto'])->name('obtener-producto');
    Route::get('/categoria/{idCategory}', [ProductosController::class, 'categoria'])->name('categoria-productos');
    Route::post('/', [ProductosController::class, 'crear'])->name('crear-productos');
    Route::delete('/{id}', [ProductosController::class, 'eliminar'])->name('eliminar-productos');
    Route::put('/{id}', [ProductosController::class, 'modificar'])->name('modificar-productos');
});


Route::prefix('/usuario')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->name('traer-usuario');
    Route::post('/registrar', [UsuariosController::class, 'registrar'])->name('registrar-usuario');
    Route::post('/autenticar', [UsuariosController::class, 'autenticar'])->name('autenticar-usuario');
    Route::delete('/eliminar/{id}', [UsuariosController::class, 'eliminar'])->name('eliminar-usuario');
});