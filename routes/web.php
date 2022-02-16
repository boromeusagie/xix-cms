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

Route::get('/', 'HomeController@show');

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
        'prefix' => 'xix-admin',
        'middleware' => 'auth'
    ], function () {
        Route::get('', 'AdminController@index')->name('admin-dashboard');

        Route::group(
            [
                'prefix' => 'category'
            ], function () {
                Route::get('', 'CategoryController@index')->name('admin-category');
                Route::post('', 'CategoryController@store')->name('admin-category-store');
                Route::post('{id}', 'CategoryController@update')->name('admin-category-update');
                Route::post('{id}/delete', 'CategoryController@destroy')->name('admin-category-destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'tag'
            ], function () {
                Route::get('', 'TagController@index')->name('admin-tag');
                Route::post('', 'TagController@store')->name('admin-tag-store');
                Route::post('{id}', 'TagController@update')->name('admin-tag-update');
                Route::post('{id}/delete', 'TagController@destroy')->name('admin-tag-destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'page'
            ], function () {
                Route::get('', 'PageController@index')->name('admin-page');
                Route::get('add-new', 'PageController@addNewPage')->name('admin-page-add');
                Route::post('add-new', 'PageController@storePage')->name('admin-page-store');
                Route::post('add-new/draft', 'PageController@storePageDraft')->name('admin-page-store-draft');
                Route::get('{id}', 'PageController@showPage')->name('admin-page-show');
                Route::post('{id}', 'PageController@updatePage')->name('admin-page-update');
                Route::post('{id}/delete', 'PageController@destroy')->name('admin-page-destroy');
                // Route::post('', 'TagController@store')->name('admin-tag-store');
                // Route::post('{id}', 'TagController@update')->name('admin-tag-update');
                // Route::post('{id}/delete', 'TagController@destroy')->name('admin-tag-destroy');
            }
        );

        Route::group(
            [
                'prefix' => 'post'
            ], function () {
                Route::get('', 'PostController@index')->name('admin-post');
                Route::get('add-new', 'PostController@addNewPost')->name('admin-post-add');
                // Route::post('add-new/draft', 'PageController@storePageDraft')->name('admin-page-store-draft');
                Route::get('{id}', 'PostController@showPage')->name('admin-post-show');
                Route::post('{id}', 'PostController@updatePage')->name('admin-post-update');
                Route::post('{id}/delete', 'PostController@destroy')->name('admin-post-destroy');
                // Route::post('', 'TagController@store')->name('admin-tag-store');
                // Route::post('{id}', 'TagController@update')->name('admin-tag-update');
                // Route::post('{id}/delete', 'TagController@destroy')->name('admin-tag-destroy');
            }
        );
    }
);
