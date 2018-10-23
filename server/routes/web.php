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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/benefits', function () {
    return view('pages.benefits');
})->name('benefits');
Route::get('/about', function () {
    return view('pages.about');
})->name('about');


Route::post('/admin/login', 'Auth\AdminAuthController@login');
Auth::routes();
Route::get('2fa', 'TwoFactorController@showTwoFactorForm');
Route::post('2fa', 'TwoFactorController@verifyTwoFactor');
Route::post('/files/upload', 'HomeController@uploadFile')->name('upload');
Route::post('/files/remove', 'HomeController@removeFile')->name('remove');
Route::post('/files/restore', 'HomeController@restoreFile')->name('restore');
Route::post('/files/download', 'HomeController@downloadFile')->name('download');
Route::get('/home', 'HomeController@index')->name('home');
