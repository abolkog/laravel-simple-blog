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

// Route::('/', function() {
//     return 'Hello World';
// });


// Landing PAge
Route::get('/', 'PagesController@index');

//Pages
Route::get('/about', 'PagesController@about')->name('aboutPage');
Route::get('/contact', 'PagesController@contact');
Route::post('/dosend', 'PagesController@dosend');

// Posts
Route::resource('posts','PostsController');

//Comments
Route::post('/comments/{slug}', 'CommentsController@store')->name('comments.store');

//Tags 
Route::resource('tags','TagsController');
Route::get('/home/tags', 'TagsController@index')->name('tags');

//Auth
Auth::routes();
Route::get('user/verify/{token}','Auth\RegisterController@verifyEmail');

Route::get('/home', 'HomeController@index')->name('home');
