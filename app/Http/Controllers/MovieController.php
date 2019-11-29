<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Movie::with('actors.actor')
            ->with('actors.role')
            ->with('actors.role.type')
            ->with('genres')
            ->with('prodcomps')
            ->with('reviews')
            ->get();
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
        $movie = Movie::create($request->all());
        if($movie)
            return response()->json($movie, 200);
        else
            return response()->json("error");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $movie = Movie::find($id);
        $movie->title = ($request->input('title'));
        $movie->description = ($request->input('description'));
        $movie->releaseDate = ($request->input('releaseDate'));
        $movie->spokenLang = ($request->input('spokenLang'));
        $movie->ageRestriction   = ($request->input('ageRestriction'));
        $movie->trailerLink = ($request->input('trailerLink'));
        $movie->duration  = ($request->input('duration'));
        $movie->director  = ($request->input('director'));
        $movie->header_img = ($request->input('header_img'));
        $movie->thumbnail_img = ($request->input('thumbnail_img'));
        $movie-> save();
        echo 'Movie is edited';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        if($movie) {
            $movie->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
