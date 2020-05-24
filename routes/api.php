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
Route::get('/', function(){
    return response(["message" => "Welcome to reporde"]);
});

//Authenticated as User
Route::prefix('user')->namespace('User')->middleware('assign.guard:users')->group(function(){
    Route::post('/register', 'RegisterController@create');
    Route::post('/login', 'LoginController@login');
    Route::group(['middleware' => ['jwt.auth']],function ()
    {
        // Route Here
    });

});


//Authenticated as Admin
Route::prefix('admin')->namespace('Admin')->middleware('assign.guard:admins')->group(function(){
    Route::post('/create', 'RegisterController@register');
    Route::post('/login', 'LoginController@login');
    Route::group(['middleware' => ['jwt.auth']],function ()
    {
        // Route Here;	
    });

});


//General route but Authenticated
Route::group(['prefix' => 'auth','middleware' => ['jwt.auth']],function ()
{
    // Route Here;	

});


//General route but Not Authenticated
    //Route Here
