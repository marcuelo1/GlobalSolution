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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/search', 'HomeController@search');

Route::get('/AgriAddSDP', 'SDPController@AgricultureAddData');

Route::post('/AgriStoreSDP', 'SDPController@Agriculture');

Route::get('/agriculture', 'SDPController@index');

Route::post('agriculture/getchartdata', 'SDPController@retrieveData');

Route::post('gettopchartdata', 'SDPController@retrieveTopData');

Route::get('/agriculture/{id}', 'SDPController@show');

Route::get('/chat/{id}', 'MessagesController@chat');

Route::get('/chat', 'MessagesController@index');

Route::post('chat/chatMessages', 'MessagesController@chatMessages');

Route::post('chat/retrieveMessages', 'MessagesController@retrieveMessages');

Route::resource('products', 'ProductsController');

Route::get('/test', function(){
    return view('pages.test');
});