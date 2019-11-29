<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Actor::with('movies')
            ->with('movies.role')
            ->with('movies.role.type')
            ->with('movies.movie')
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
        $actor =  Actor::create($request->all());
        if($actor)
            return response()->json($actor, 200);
        else
            return response()->json("error");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */ 
    //protected $fillable = ['name','insertion', 'surname', 'gender', 'country','birthDate', 'img'];
    public function edit($id, Request $request)
    {
        $actor = Actor::find($id);
        $actor->name = ($request->input('name'));
        $actor->insertion = ($request->input('insertion'));
        $actor->surname = ($request->input('surname'));
        $actor->gender = ($request->input('gender'));
        $actor->country   = ($request->input('country'));
        $actor->birthDate = ($request->input('birthDate'));
        $actor->img  = ($request->input('img'));
        $actor-> save();
        echo 'Actor is edited';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actor $actor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);
        if($actor) {
            $actor->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
