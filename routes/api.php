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
    return response(["message" => "Welcome to exchanger"]);
});

//Authenticated as User
Route::group(['namespace' => 'User'], function () {
    Route::group(['prefix' => 'user', 'middleware' => 'assign.guard:users'], function(){
        Route::post('register', 'RegisterController@create');
        Route::post('login', 'LoginController@login');
        //jwt.auth will check for validation of jwt token
        Route::group(['middleware' => ['jwt.auth']],function ()
        {
            Route::get('show', 'RegisterController@show');
        });
    
    });
});


//Authenticated as Admin
Route::group(['namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'admin', 'middleware' => 'assign.guard:admins'], function(){
        Route::post('register', 'RegisterController@create');
        Route::post('login', 'LoginController@login');
        Route::group(['middleware' => ['jwt.auth']],function ()
        {
            // Route Here
        });
    
    });
});



//General route but Authenticated
//api.auth will check against all guards
Route::group(['prefix' => 'user','middleware' => ['api.auth']],function ()
{
    // Route Here;	
});


//General route but Not Authenticated
    //Route Here
