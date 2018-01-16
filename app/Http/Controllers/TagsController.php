<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::ownedBy(Auth::user())->with('pages')->naturalOrder()->get();
        return \App\Http\Resources\PartialTag::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag($request->only('tag'));
        $tag->user_id = Auth::user()->id;
        $tag->save();

        return response(null, 204);
    }

    public function show(string $id)
    {
        $tag = Tag::withTrashed()->find($id);
        if ($tag === null) {
            return response(null, 404);
        }

        if ($tag->trashed()) {
            return response(null, 410);
        }

        if (!$tag->owner->is(Auth::user())) {
            return response(null, 403);
        }

        return \App\Http\Resources\Tag::make($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        if (!$tag->owner->is(Auth::user())) {
            abort(403);
        }

        $tag->update($request->only('starred'));
        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (!$tag->owner->is(Auth::user())) {
            abort(403);
        }

        $tag->delete();
        return response(null, 204);
    }
}
