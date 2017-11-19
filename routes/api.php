<?php

Route::apiResource('/notebooks', 'NotebooksController');
Route::apiResource('/tags', 'TagsController');
Route::apiResource('/notebooks/{notebook_id}/tags', 'NotebookTagsController');
