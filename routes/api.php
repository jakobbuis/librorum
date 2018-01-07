<?php

Route::apiResource('notebooks', 'NotebooksController');
Route::apiResource('tags', 'TagsController');
Route::apiResource('notebooks.tags', 'NotebookTagsController');
Route::apiResource('pages', 'PagesController');
Route::apiResource('trash', 'TrashController');

// DELETE /trash destroys all trashed items
Route::delete('trash', 'TrashController@purge');
