<?php

Route::apiResource('notebooks', 'NotebooksController', ['only' => ['index', 'store']]);
Route::apiResource('tags', 'TagsController');
Route::apiResource('pages', 'PagesController', ['only' => ['store', 'destroy']]);
Route::apiResource('trash', 'TrashController', ['only' => ['index', 'update']]);

// DELETE /trash destroys all trashed items
Route::delete('trash', 'TrashController@purge');
