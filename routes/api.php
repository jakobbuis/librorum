<?php

Route::post('/login', 'LoginController@login');

Route::middleware('auth:api')->group(function() {
    Route::apiResource('notebooks', 'NotebooksController', ['only' => ['index', 'store', 'destroy']]);
    Route::apiResource('tags', 'TagsController');
    Route::apiResource('pages', 'PagesController', ['only' => ['store', 'destroy']]);
    Route::apiResource('trash', 'TrashController', ['only' => ['index', 'update']]);

    Route::delete('trash', 'TrashController@purge'); // destroys all trashed items
});
