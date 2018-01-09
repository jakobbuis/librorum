<?php

// Routes that deeplink to the app
Route::view('/', 'app');
Route::view('/tag/{id}', 'app');
Route::view('/add-page', 'app');
Route::view('/add-notebook', 'app');
Route::view('/add-tag', 'app');
Route::view('/trash', 'app');
Route::view('/notebooks', 'app');
