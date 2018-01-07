<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notebook;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    /**
     * Show all contents of the trash
     */
    public function index()
    {
        $tags = Tag::onlyTrashed()->get();
        $pages = Page::onlyTrashed()->get();

        $trash = $tags->union($pages)->sortBy('deleted_at')->values();

        return \App\Http\Resources\TrashItem::collection($trash);
    }
}
