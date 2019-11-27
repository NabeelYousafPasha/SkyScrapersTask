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

Route::group(['prevent-back-history'], function() {

    Route::get('/', function () {
        return view('welcome');
    })->name('/');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    /*
     * Admin Routes
     */
    Route::get('/admin_dashboard', 'AdminController@dashboard')->name('admin_dashboard');

    Route::get('/admins', 'AdminController@index')->name('admins');
    Route::get('/admins/create', 'AdminController@create')->name('admins.create');
    Route::post('/admins', 'AdminController@store')->name('admins.store');
    Route::get('/admins/{admin}/edit', 'AdminController@edit')->name('admins.edit');
    Route::patch('/admins/{admin}', 'AdminController@update')->name('admins.update');
    Route::delete('/admins/{admin}', 'AdminController@destroy')->name('admins.delete');
    // permissions
    Route::get('/permission_role', 'AdminController@getPermissionRole')->name('permission_role');
    Route::post('/permission_role', 'AdminController@savePermissionRole')->name('permission_role');

    /*
     * User Routes
     */
    Route::get('/user_dashboard', 'UserController@dashboard')->name('user_dashboard');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::patch('/users/{user}', 'UserController@update')->name('users.update');
    Route::delete('/users/{user}', 'UserController@destroy')->name('users.delete');

    /*
     * Blogger Routes
     */
    Route::get('/blogger_dashboard', 'BloggerController@dashboard')->name('blogger_dashboard');

    Route::get('/bloggers', 'BloggerController@index')->name('bloggers');
    Route::get('/bloggers/create', 'BloggerController@create')->name('bloggers.create');
    Route::post('/bloggers', 'BloggerController@store')->name('bloggers.store');
    Route::get('/bloggers/{blogger}/edit', 'BloggerController@edit')->name('bloggers.edit');
    Route::patch('/bloggers/{blogger}', 'BloggerController@update')->name('bloggers.update');
    Route::delete('/bloggers/{blogger}', 'BloggerController@destroy')->name('bloggers.delete');

    /*
     * Blog Routes
     */
    Route::get('/blogs', 'BlogController@index')->name('blogs');
    Route::get('/blogs/create', 'BlogController@create')->name('blogs.create');
    Route::post('/blogs', 'BlogController@store')->name('blogs.store');
    Route::get('/blogs/{blog}/edit', 'BlogController@edit')->name('blogs.edit');
    Route::patch('/blogs/{blog}', 'BlogController@update')->name('blogs.update');
    Route::delete('/blogs/{blog}', 'BlogController@destroy')->name('blogs.delete');

});
