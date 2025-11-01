<?php

use App\Http\Controllers\AlojamientoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\TiposAlojamientoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

//RUTAS LOGIN & REGISTER
Route::get('/login', [UsuarioController::class, 'index'])->name('login');
Route::get('/register', [UsuarioController::class, 'indexR'])->name('register');
Route::post('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
//RUTAS LOGIN & REGISTER END

//RUTA PARA CREAR USUARIO O ADMIN -> REGISTER
Route::post('/createuser', [UsuarioController::class, 'store'])->name('create.user');
//RUTA PARA CREAR USUARIO O ADMIN -> REGISTER END

//RUTA PARA LA PAGINA LANDING PAGE
Route::get('/home', [AlojamientoController::class, 'index'])->name('home');
//RUTA PARA LA PAGINA LANDING PAGE END

Route::get('/lodging', [TiposAlojamientoController::class, 'index'])->name('index.lodging');

//RUTAS CREAR TIPOS ALOJAMIENTOS
Route::post('/createlodging', [TiposAlojamientoController::class, 'store'])->name('create.typelodging');
Route::put('/editlodging/{id}', [TiposAlojamientoController::class, 'update'])->name('edit.typelodging');
Route::delete('/deletelodging/{id}', [TiposAlojamientoController::class, 'destroy'])->name('delete.typelodging');

//RUTAS CREAR ALOJAMINETOS
Route::post('/createalojamiento', [AlojamientoController::class, 'store'])->name('create.alojamineto');
Route::put('/editalojamiento/{id}', [AlojamientoController::class, 'update'])->name('edit.alojamiento');
//Route::delete('/deletealojamiento/{id}', [AlojamientoController::class, 'destroy'])->name('delete.alojamiento');

//RESEÑA
Route::get('/alojamiento/{alojamiento}/review', [ReseñaController::class, 'index'])->name('review.index');
Route::post('/createreview',  [ReseñaController::class, 'store'])->name('review.create');

//RESERVA
Route::get('/detail/{id}', [ReservaController::class, 'show'])->name('detail.show');

Route::middleware('auth')->group(function() {
    Route::get('/mi-cuenta', [ReservaController::class, 'misReservas'])->name('reserva.index');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reserva.create');
    Route::delete('/reserva/{reserva}', [ReservaController::class, 'destroy'])->name('reserva.delete');
});

