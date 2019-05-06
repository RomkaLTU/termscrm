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
        return redirect('contracts');
    })->name('dashboard');

    Route::get('contracts/json', 'ContractsController@json');
    Route::get('contracts/{contract}/objects/json', 'ObjsController@json');
    Route::get('contracts/{contract}/objects/{object}/tasks/json', 'TasksController@json');

    Route::resource('users', 'UsersController')->middleware(['role:Admin']);
    Route::resource('contracts', 'ContractsController');
    Route::resource('contracts.objects', 'ObjsController');
    Route::resource('contracts.objects.tasks', 'TasksController');

    Route::post('api/media', 'MediaController@upload')->name('upload');
    Route::delete('api/media/{media}', 'MediaController@remove')->name('remove');

});
