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

Route::get('test2', 'ParseController@test2');
Route::get('test3', 'ParseController@test3');
Route::get('test4', 'UniqueController@test4');
Route::get('test5', 'UniqueController@test5');
Route::get('test6', 'UniqueController@test6');
Route::get('clean', 'UniqueController@clean');
Route::get('repair', 'UniqueController@repair');
Route::get('sanitize', 'UniqueController@sanitize');
Route::get('clean_parse', 'ParseController@clean_parse');
Route::get('images', 'UniqueController@add_images_to_database');
Route::get('video', 'UniqueController@add_video_to_database');
Route::get('createsitemap', 'ParseController@createSitemap');






/// user routes

Route::get('/expert_articles', 'PostsController@index')->name('blog');
Route::get('blog.show/{slug}', 'PostsController@show')->name('blog.show');
Route::get('category/{slug}', 'PostsController@filter_cat')->name('category.filter');
Route::get('tag.filter/{slug}', 'PostsController@filter_tag')->name('tag.filter');
Route::get('/', 'UniqueController@index')->name('main');
Route::get('/theme_news/{slug}', 'UniqueController@show')->name('news.show');

// Admin
//
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('admin', 'Admin\DashboardController@index')->name('admin');
    Route::resource('posts', 'Admin\PostsController');
    Route::resource('uniq_texts', 'Admin\UniqTextsController');
    Route::resource('categories', 'Admin\CategoriesController');
    Route::resource('tags', 'Admin\TagsController');
    Route::get('settings', 'Admin\SettingsController@edit')->name('settings');
    Route::post('settings_update', 'Admin\SettingsController@update')->name('settings.update');;
});
;





Route::fallback(function(){
    return response()->view('errors.404', [], 404);
});
