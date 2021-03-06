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

//Admin commands
Route::get('/AdminPage', 'SDPController@AdminPage');

Route::get('/AdminPage/{category}', 'SDPController@AddProduct');

Route::post('/StoreProduct', 'SDPController@StoreProduct');

Route::get('AdminPage/addSDP/{category}', 'SDPController@AddSDP');

Route::post('/StoreSDP', 'SDPController@StoreSDP');

Route::post('/AddAcc', 'SDPController@AddAcc');

//Supply Demand And Feature of Agriculture
Route::get('/agriculture', 'SDPController@index');

Route::post('agriculture/getchartdata', 'SDPController@retrieveData');

Route::post('gettopchartdata', 'SDPController@retrieveTopData');

Route::get('/agriculture/{id}', 'SDPController@show');

//messages feature
Route::get('/message/{id}', 'MessagesController@message');

Route::get('/message', 'MessagesController@index');

Route::post('message/chatMessages', 'MessagesController@chatMessages');

Route::post('message/retrieveMessages', 'MessagesController@retrieveMessages');

//Products 
Route::resource('products', 'ProductsController');