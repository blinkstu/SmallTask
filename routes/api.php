<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth',], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'UserController@show');
});

//client
Route::get('tickets', 'TicketController@index'); //show user's tickets
Route::get('tickets/{ticket}', 'TicketController@show'); // show user's one ticket
Route::post('tickets', 'TicketController@store'); // new ticket
Route::post('tickets/{ticket}/messages', 'MessageController@store'); //add a new message to ticket

//admin
Route::group(['prefix' => 'admin'], function($router){

    Route::get('tickets', 'TicketController@index');
    Route::get('tickets/{ticket}/messages', 'MessageController@index');
    Route::post('tickets/{ticket}/message', 'MessageController@store');
});