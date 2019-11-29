<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genres
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genres
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genres)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genres)
    {
        //
    }
}
