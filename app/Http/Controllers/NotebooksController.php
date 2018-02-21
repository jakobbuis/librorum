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
        return \App\Http\Resources\PartialNotebook::collection(Notebook::ownedBy(Auth::user())->get());
    }

    public function show(string $id)
    {
        $notebook = Notebook::withTrashed()->find($id);
        if ($notebook === null) {
            return response(null, 404);
        }

        if ($notebook->trashed()) {
            return response(null, 410);
        }

        if (!$notebook->owner->is(Auth::user())) {
            return response(null, 403);
        }

        return \App\Http\Resources\Notebook::make($notebook);
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
