<?php

use Illuminate\Http\Request;

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [ 'prefix' => 'api' ], function ($api) {

    $api->get('invoices/{contract_id}/{invoice_id?}', 'App\Http\Controllers\Api\InvoicesController@index');
    $api->post('invoices', 'App\Http\Controllers\Api\InvoicesController@store');
    $api->put('invoices/{contract_id}', 'App\Http\Controllers\Api\InvoicesController@update');
    $api->delete('invoices/{invoice}', 'App\Http\Controllers\Api\InvoicesController@destroy');

    $api->post('visits', 'App\Http\Controllers\Api\ObjVisitsController@visits');
    $api->get('visits/{contract_id}/{object_id}', 'App\Http\Controllers\Api\ObjVisitsController@get_visits');

});
