<?php

namespace App\Http\Controllers;

use App\Notebook;
use Illuminate\Http\Request;

class NotebooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Http\Resources\Notebook::collection(Notebook::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notebook = new Notebook($request->only('slug'));
        $notebook->save();

        return \App\Http\Resources\Notebook::make($notebook);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function show(Notebook $notebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notebook $notebook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notebook $notebook)
    {
        //
    }
}
