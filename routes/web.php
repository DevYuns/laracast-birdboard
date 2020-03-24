<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'projectTasksController@update');

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();


