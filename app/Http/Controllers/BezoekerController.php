<?php

namespace App\Http\Controllers;

use App\Bezoekers;
use Illuminate\Http\Request;

class BezoekerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bezoekers::all();
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
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Bezoekers $bezoekers
     * @return void
     */
    public function show(Bezoekers $bezoekers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Bezoekers $bezoekers
     * @return void
     */
    public function edit(Bezoekers $bezoekers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Genre $genres
     * @return void
     */
    public function update(Request $request, Bezoekers $bezoekers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genre $genres
     * @return void
     */
    public function destroy(Genre $genres)
    {
        //
    }
}
