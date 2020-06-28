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


/* USERS */
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/config', 'UserController@config')->name('config');
Route::post('/update','UserController@update')->name('update');
Route::get('/user/avatar/{filename}','UserController@getImage')->name('user.avatar');
Route::get('/user/detail/{id}','UserController@getUser')->name('user.detail');
Route::get('/user/search/{word?}','UserController@people')->name('user.people');


/* IMAGES */
Route::get('images/formUpload','ImageController@formUpload')->name('image.formUpload');
Route::post('images/upload','ImageController@upload')->name('image.upload');
Route::get('/images/{filename}','ImageController@getImage')->name('image.get');
Route::get('/images/comments/{id}','ImageController@comments')->name('image.comment');
Route::get('/images/delete/{id}','ImageController@delete')->name('image.delete');
Route::get('/images/likes/{id}','ImageController@showLikes')->name('image.likes');

/* COMMENTS */

Route::post('/comments','CommentController@save')->name('comment');
Route::get('/comments/edit/{id}','CommentController@edit')->name('comment.edit');
Route::post('/comments/update','CommentController@update')->name('comment.update');
Route::get('/comments/delete/{id}','CommentController@delete')->name('comment.delete');


/* LIKES */
Route::get('/like/{image_id}','LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}','LikeController@dislike')->name('like.delete');



/* FOLLOWERS */

Route::get('/follower/follow/{id}','FollowerController@save')->name('follower.follow');
Route::get('/follower/unfollow/{id}','FollowerController@delete')->name('follower.unfollow');
Route::get('followed','FollowerController@getAll')->name('followed.home');
Route::get('followers','FollowerController@getMyFollowers')->name('followers.home');




