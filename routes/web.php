<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[AdminController::class,'index'])->middleware('auth')->name('index');

Route::controller(EmployeeController::class)->prefix('empleados')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/','index')->name('employees');
    Route::get('/crear','create')->name('create_employee');
    Route::get('/validacion_masiva','validationRfc')->name('validationRfc');
    Route::post('/agregar','store')->name('store_employee');

    Route::post('importacion_masiva','uploadZip')->name('uploadZip');
    Route::post('subir_documento/{id}','uploadDocument')->name('uploadDocument');
    Route::post('subir_datos/{id}','checkCIF')->name('check_rfc');

    Route::get('subir_documento/continue','continue')->name('continue_employee');
    Route::get('subir_documento/edit','edit_data')->name('edit_data_employee');

    Route::get('/exportacion_masiva','export_rfc')->name('export_rfc');
    Route::post('/exportacion_masiva','uploadResponseSat')->name('uploadResponseSat');

    Route::post('crear_documento','createByDocument')->name('createByDocument');
    Route::post('subir_datos','createByData')->name('createByData');
});

Route::controller(ClientController::class)->prefix('clientes')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/','index')->name('clients');

})
;
