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

Route::get('xix-login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('xix-login', 'Auth\LoginController@login');
Route::post('xix-logout', 'Auth\LoginController@logout')->name('logout');
Route::get('xix-register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('xix-register', 'Auth\RegisterController@register');
Route::get('xix-password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('xix-password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('xix-password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('xix-password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('xix-password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('xix-password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::get('xix-email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('xix-email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('xix-email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(
    [
        'prefix' => 'xix-admin'
    ], function () {
        Route::get('', 'HomeController@index')->name('home');
    }
);
