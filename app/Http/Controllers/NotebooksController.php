<?php

namespace App\Http\Controllers;

use App\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotebooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Http\Resources\Notebook::collection(Notebook::ownedBy(Auth::user())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notebook = new Notebook($request->only('slug', 'page_count'));
        $notebook->user_id = Auth::user()->id;
        $notebook->save();

        return \App\Http\Resources\Notebook::make($notebook);
    }

    public function destroy(Notebook $notebook)
    {
        if (!$notebook->owner->is(Auth::user())) {
            abort(403);
        }

        $notebook->delete();
        return response(null, 204);
    }
}
