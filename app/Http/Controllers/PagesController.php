<?php

namespace App\Http\Controllers;

use App\Notebook;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function store(Request $request)
    {
        $page = new Page($request->only(['description', 'start_number', 'end_number']));
        $page->notebook_id = Notebook::ownedBy(Auth::user())->where('id',$request->notebook)->firstOrFail()->id;
        $page->save();
        $page->tags()->attach(Tag::ownedBy(Auth::user())->find($request->tags));

        return response(null, 204);
    }

    public function destroy(Page $page)
    {
        if (!$page->owner->is(Auth::user())) {
            abort(403);
        }

        $page->delete();
        return response(null, 204);
    }
}
