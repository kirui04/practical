<?php


Route::get('/', function () {
    return redirect('home');
});

Route::get('home', 'HomeController@home');
Route::any('form/{id?}', 'HomeController@form');

Route::get('data', 'HomeController@data');
