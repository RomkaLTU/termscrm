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
        return redirect('users');
    })->name('dashboard');

    Route::resource('users', 'UsersController')->middleware(['role:Admin']);
    Route::resource('contracts', 'ContractsController')->middleware(['role:Admin']);
    Route::resource('contracts.objects', 'ObjsController')->middleware(['role:Admin']);

    Route::post('api/media', 'MediaController@upload')->name('upload');
    Route::delete('api/media/{media}', 'MediaController@remove')->name('remove');

});
