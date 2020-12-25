<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::get('/api/users/bulk', '\App\Http\Controllers\Controller@createUsers');
Route::get('/api/getUsers', '\App\Http\Controllers\Controller@getUsers');
Route::get('/api/getUsersWithJoin', '\App\Http\Controllers\Controller@getUsersWithJoin');
Route::get('/api/groups/bulk', '\App\Http\Controllers\Controller@createGroups');