<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () 
{
    return view('welcome');
});
//Create tag

Route::get('/tags', 'TagController@gets');

Route::get('/tags/{id}', 'TagController@detail');

Route::post('/tags', 'TagController@post');

Route::put('/tags/{id}', 'TagController@update');

Route::delete('/tags/{id}','TagController@destroy');

// show new post form
Route::get('posts','PostController@gets');

Route::get('posts/{id}','PostController@get');
// save new post
Route::post('posts','PostController@create');
// update post
Route::put('posts/{id}','PostController@update');
// delete post
Route::delete('posts/{id}','PostController@destroy');

Route::get('posts/{id}/tags','PostController@tags');

Route::post('posts/{id}/tags','PostController@assign');
