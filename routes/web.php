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
/// test routes

Route::get('test', 'ParseController@index');


/// user routes

Route::get('/', 'PostsController@index')->name('blog');
Route::get('blog.show/{slug}', 'PostsController@show')->name('blog.show');
Route::get('category.filter/{id}', 'PostsController@filter_cat')->name('category.filter');
Route::get('tag.filter/{id}', 'PostsController@filter_tag')->name('tag.filter');

// Admin
//
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('admin', 'Admin\DashboardController@index')->name('admin');
    Route::resource('posts', 'Admin\PostsController');
    Route::resource('categories', 'Admin\CategoriesController');
    Route::resource('tags', 'Admin\TagsController');
    Route::get('settings', 'Admin\SettingsController@edit')->name('settings');
    Route::post('settings_update', 'Admin\SettingsController@update')->name('settings.update');;
});
;





Route::get('/home', 'HomeController@index')->name('home');
