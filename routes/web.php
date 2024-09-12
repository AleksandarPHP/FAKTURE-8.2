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

// Authentication Routes
Route::middleware('guest')->group(function () {

    Route::get('login', function () {
        return view('index');
    })->name('login');

    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
});

Route::middleware(['auth','active'])->group(function () {

    Route::post('logout', [
        'as' => 'logout',
        'uses' => 'App\Http\Controllers\Auth\LoginController@logout'
    ]);

    Route::get('/', 'App\Http\Controllers\HomeController@index');
    Route::get('moj-profil', function () { return view('profil/moj-profil-1'); });
    Route::post('moj-profil', 'App\Http\Controllers\MyProfileController@save');

    Route::get('moj-profil/2', 'App\Http\Controllers\MyProfileController@saving');
    Route::post('moj-profil/2/create', 'App\Http\Controllers\MyProfileController@save_detail');

    Route::get('moj-profil/3', 'App\Http\Controllers\MyProfileController@detail');
    Route::put('moj-profil-3/update', 'App\Http\Controllers\MyProfileController@details');

    Route::get('moj-profil/4', 'App\Http\Controllers\MyProfileController@text');
    Route::put('moj-profil-4/update', 'App\Http\Controllers\MyProfileController@texts');

    Route::get('moj-profil/5', 'App\Http\Controllers\MyProfileController@settings');
    Route::put('moj-profil-5/update', 'App\Http\Controllers\MyProfileController@settingss');

    Route::post('mail-settings', 'App\Http\Controllers\MyProfileController@text');
    Route::post('facture-settings', 'App\Http\Controllers\MyProfileController@settings');

    Route::get('moj-profil-1', function () { return view('profil/moj-profil-1'); });
    Route::get('moj-profil-6', function () { return view('moj-profil-6'); });

    Route::resource('obavjestenja', 'App\Http\Controllers\NotificationsController')->except(['create', 'show'])->middleware('can:obavjestenja');

    Route::middleware(['can:goods'])->group(function () {
        Route::resource('usluge', 'App\Http\Controllers\GoodsController')->except(['show']);
    });

    Route::middleware(['can:klijenti'])->group(function () {
        Route::resource('klijenti', 'App\Http\Controllers\ClientsController')->except(['show']);
    });

    Route::middleware(['can:categories'])->group(function () {
        Route::resource('kategorije', 'App\Http\Controllers\CategorieController')->except(['show']);
    });

    Route::middleware(['can:fakture'])->group(function () {
        Route::resource('fakture', 'App\Http\Controllers\FakturaController')->except(['show']);
        Route::post('roba-add', 'App\Http\Controllers\GoodsController@add');
        Route::delete('roba/{id}/delete', 'App\Http\Controllers\GoodsController@delete');
        Route::get('/api/klijenti/{clientsId}', 'App\Http\Controllers\FakturaController@clients');
        Route::get('/api/goods/{goodsId}', 'App\Http\Controllers\FakturaController@goods');
        Route::get('fakture/{id}/print', 'App\Http\Controllers\FakturaController@print');
        Route::get('fakture/{id}/copy', 'App\Http\Controllers\FakturaController@copy')->name('fakture.copy');
        Route::put('change-status/{id}', 'App\Http\Controllers\FakturaController@status');
        Route::get('fakture/{id}/send-pdf', 'App\Http\Controllers\FakturaController@sendPDF')->name('invoice.sendPDF');
        Route::post('add-to-table', 'App\Http\Controllers\FakturaController@addToTable');
        Route::post('delete-to-table', 'App\Http\Controllers\FakturaController@deleteRow');
        Route::group(['prefix' => 'en'], function () {
            Route::get('fakture/{id}/print', 'App\Http\Controllers\FakturaController@print');
        });
    });

    Route::middleware(['can:repeat-fakture'])->group(function () {
        Route::resource('repeat-fakture', 'App\Http\Controllers\RepeatInvController')->except(['show']);
    });

    Route::middleware(['admin'])->group(function () {
        Route::resource('postavke', 'App\Http\Controllers\UsersController')->except(['show']);
    });
    
});