<?php

namespace App\Http\Controllers;

use App\Notebook;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function store(Request $request)
    {
        $page = new Page($request->only(['description', 'start_number', 'end_number']));
        $page->notebook_id = Notebook::findOrFail($request->notebook)->id;
        $page->save();
        $page->tags()->attach(Tag::find($request->tags));

        return response(null, 204);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response(null, 204);
    }
}
