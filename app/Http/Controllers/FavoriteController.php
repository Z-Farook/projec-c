<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Favorite::all();
    }

    /**
     * Get a stored object with id
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $favs = Favorite::where('user_id', '=',  $id)
            ->get();
        if($favs) {
            return response()->json($favs, 200);
        } else {
            return response()->json('error', 500);
        }
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
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $movie_id = $request['movie_id'];
        $user_id = $id;

        $check = DB::table('favorites')
            ->where(['movie_id' => $movie_id, 'user_id' => $user_id])
            ->exists();
        if($check) {
            return response()->json("Already favorite, movie_id: " . $movie_id . ", user_id: " . $user_id, 403);
        } else {
            $fav = Favorite::create([
                'movie_id' => $movie_id,
                'user_id' => $user_id
            ]);
            if($fav) {
                return response()->json($fav, 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fav = Favorite::findOrFail($id);
        if($fav) {
            $fav->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
