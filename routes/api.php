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

Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function ($router) {

    // AUTHENTICATION ROUTES
    Route::group(['middleware' => 'api', 'prefix' => 'auth', 'namespace' => 'Auth'], function ($router) {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::post('refresh', 'LoginController@refresh');
        Route::post('forgot', 'ForgotPasswordController@forgot');
        Route::post('reset', 'ResetPasswordController@reset');
        Route::post('register', 'RegistrationController@register');
        Route::post('activate', 'RegistrationController@activate');
        Route::post('resend', 'RegistrationController@resend');
        Route::post('me', 'UserController@me');
        Route::post('email', 'EmailController@update');
        Route::post('email/activate', 'EmailController@activate');
    });
});