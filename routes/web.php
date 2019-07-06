<?php

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

Auth::routes();

Route::group(['middleware' => ['auth:web'] ], function() {

    Route::get('/', function(){
        return redirect('dashboard');
    })->name('dashboard');

    Route::get('contracts/{contract}/objects/json', 'ObjsController@json');
    Route::get('contracts/{contract}/objects/{object}/tasks/json', 'TasksController@json');

    Route::get('users/json', 'UsersController@json');
    Route::resource('users', 'UsersController');

    Route::get('dashboard','DashboardController@index')->name('dashboard.index');
    Route::get('dashboard/json', 'DashboardController@json');

    Route::group(['middleware' => ['permission:view_contracts']], function () {
        Route::get('contracts','ContractsController@index')->name('contracts.index');
        Route::get('contracts/json', 'ContractsController@json');
    });

    Route::group(['middleware' => ['permission:manage_contracts']], function () {
        Route::post('contracts','ContractsController@store')->name('contracts.store');
        Route::get('contracts/create', 'ContractsController@create')->name('contracts.create');
        Route::delete('contracts/{contract}', 'ContractsController@destroy')->name('contracts.destroy');
        Route::put('contracts/{contract}', 'ContractsController@update')->name('contracts.update');
        Route::get('contracts/{contract}/edit', 'ContractsController@edit')->name('contracts.edit');
    });
    Route::get('contracts/{contract}', 'ContractsController@show')->name('contracts.show');

    Route::get('tasks/pdf', 'TasksController@generatePdf')->name('generate-pdf');

    Route::resource('contracts.objects', 'ObjsController');
    Route::resource('contracts.objects.tasks', 'TasksController');

    Route::post('api/media', 'MediaController@upload')->name('upload');
    Route::delete('api/media/{media}', 'MediaController@remove')->name('remove');

});
