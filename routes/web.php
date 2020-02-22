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

Route::get('/', 'Home@index');
Route::get('/home', 'Home@index');
Route::get('/home/page/{page_no}', 'Home@index');
Route::get('/read/{title}', 'Home@read_content');
Route::get('/search/', 'Home@search_content');
Route::get('/login', function () {
    return view('login');
});
Route::get('/admin', 'Admin@dashboard')->middleware('userauth');
Route::post('/Admin/savePost', 'Admin@savePost')->middleware('userauth');
Route::post('/Authentication/login/', 'Authentication@login');

