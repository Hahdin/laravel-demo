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
//Pages
Route::get('/', 'PagesController@index');
Route::get('/contact', 'PagesController@contact');
Route::get('/about', 'PagesController@about');

//Projects
Route::resource('projects', 'ProjectController');

//tasks
Route::patch('/tasks/{task}', 'ProjectTasksController@update');
Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
