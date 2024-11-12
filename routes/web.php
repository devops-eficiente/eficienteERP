<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebServiceController;
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

Route::get('/', [AdminController::class, 'index'])
    ->middleware('auth')
    ->name('index');

Route::name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::controller(EmployeeController::class)
            ->prefix('empleados')
            ->group(function () {
                Route::get('/', 'index')->name('employees');
                Route::get('crear', 'create')->name('create_employee');
                Route::get('validacion_masiva', 'validationRfc')->name('employee.validationRfc');
                Route::post('agregar', 'store')->name('store_employee');

                Route::post('importacion_masiva', 'uploadZip')->name('employee.uploadZip');
                Route::post('subir_documento/{id}', 'uploadDocument')->name('employee.uploadDocument');
                Route::post('subir_datos/{id}', 'checkCIF')->name('employee.check_rfc');

                Route::get('subir_documento/continue', 'continue')->name('employee.continue_employee');
                Route::get('subir_documento/edit', 'edit_data')->name('employee.edit_data_employee');

                Route::get('exportacion_masiva', 'export_rfc')->name('employee.export_rfc');
                Route::post('exportacion_masiva', 'uploadResponseSat')->name('employee.uploadResponseSat');

                Route::post('crear_documento', 'createByDocument')->name('employee.createByDocument');
                Route::post('subir_datos', 'createByData')->name('employee.createByData');

                Route::get('empleado/{id}', 'show')->name('show_employee');
                Route::get('empleado/{id}/editar', 'edit')->name('edit_employee');
                Route::put('empleado/{id}', 'update')->name('update_employee');
            });

        Route::controller(ClientController::class)
            ->prefix('clientes')
            ->group(function () {
                Route::get('/', 'index')->name('clients');
                Route::get('crear', 'create')->name('create_client');
                Route::post('agregar', 'store')->name('store_client');
                Route::get('cliente/{id}', 'show')->name('show_client');
                Route::get('cliente/{id}/editar', 'edit')->name('edit_client');
                Route::put('cliente/{id}', 'update')->name('update_client');

                Route::get('validacion_masiva', 'validationRfc')->name('client.validationRfc');

                Route::post('importacion_masiva', 'uploadZip')->name('client.uploadZip');
                Route::post('subir_documento/{id}', 'uploadDocument')->name('client.uploadDocument');
                Route::post('subir_datos/{id}', 'checkCIF')->name('client.check_rfc');

                Route::get('subir_documento/continue', 'continue')->name('client.continue_employee');
                Route::get('subir_documento/edit', 'edit_data')->name('client.edit_data_employee');

                Route::get('exportacion_masiva', 'export_rfc')->name('client.export_rfc');
                Route::post('exportacion_masiva', 'uploadResponseSat')->name('client.uploadResponseSat');

                Route::post('crear_documento', 'createByDocument')->name('client.createByDocument');
                Route::post('subir_datos', 'createByData')->name('client.createByData');
            });

        Route::controller(WebServiceController::class)->group(function () {
            Route::get('webservice', 'index')->name('webservice');
        });

        Route::middleware('role:super_admin')->group(function () {
            Route::controller(CompanyController::class)
                ->prefix('empresas')
                ->group(function () {
                    Route::get('/', 'index')->name('company.index');
                    Route::get('/crear', 'create')->name('company.create');
                    Route::post('/guardar', 'store')->name('company.store');
                    Route::get('/editar/{rfc}', 'edit')->name('company.edit');
                    Route::put('/actualizar/{company}', 'update')->name('company.update');
                });
        });
        Route::controller(UserController::class)
        ->prefix('usuarios')
        ->middleware('role:admin_empresa')
        ->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::get('/crear', 'create')->name('user.create');
            Route::post('/guardar', 'store')->name('user.store');
            Route::get('/editar/{user}', 'edit')->name('user.edit');
            Route::put('/actualizar/{user}', 'update')->name('user.update');
        });

        Route::controller(AdminController::class)->group(function () {
            Route::get('conversaciones', 'conversations')->name('conversations');
            Route::get('enviar-notificacion/{id}', 'send_notification')->name('send_notification');
        });
});
