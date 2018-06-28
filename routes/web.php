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

Auth::routes();

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

//rotas de controladores de videos
Route::get('/criar-video', array(
    'as'=> 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));
Route::post('/guardar-video', array(
    'as'=> 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));

Route::get('/miniatura/{filename}', [
    'as'=> 'imageVideo',
    'uses'=> 'VideoController@getImage'
]);

Route::get('/video/{video_id}', [
    'as'=>'detailVideo',
    'uses'=> 'VideoController@getVideoDetail'
]);

Route::get('/video-file/{filename}', [
    'as'=> 'fileVideo',
    'uses'=> 'VideoController@getVideo'
]);

Route::get('/delete-video/{video_id}', [
    'as' => 'videoDelete',
    'middleware'=>'auth',
    'uses'=> 'VideoController@delete'
]);

Route::get('/editar-video/{video_id}', [
    'as' => 'videoEdit',
    'middleware'=>'auth',
    'uses'=> 'VideoController@edit'
]);

Route::post('/update-video/{video_id}', array(
    'as'=> 'updateVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@update'
));

Route::get('/buscar/{search?}/{filter?}', [
    'as'=> 'videoSearch',
    'uses' => 'VideoController@search'
]);

//comentários
Route::post('/comment', [
    'as'=>'comment',
    'middleware'=>'auth',
    'uses'=>'CommentController@store'
]);

Route::get('/delete-comment/{comment_id}', [
    'as'=>'commentDelete',
    'middleware'=>'auth',
    'uses'=>'CommentController@delete'
]);
//usuários
Route::get('/canal/{user_id}', [
    'as' => 'channel',
    'uses' => 'UserController@channel'
]);

//cache
Route::get('/clear-cache', function () {
    $code = Artisan::call('cache: clear');
});
