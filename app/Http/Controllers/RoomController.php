<?php

namespace App\Http\Controllers;

use App\Room;
use App\Seat;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Room::with('seats')->get();
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
        $a = $request->all();
        $room = Room::create(['name' => $a['name']]);
        $rows = $request->all()['rows'];
        $seatsPerRow = $request->all()['seatsPerRow'];
        if ($room) {
            for ($i = 0; $i < $rows; $i++) {
                for ($x = 0; $x < $seatsPerRow; $x++) {
                    $seat = [
                        'row' => $i,
                        'number' => $x,
                        'room_id' => $room->id
                    ];
                    Seat::create($seat);
                }
            }
            return response()->json($room, 200);
        } else {
            return response()->json("error");
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
    public function edit($id, Request $request)
    {
        $room = Room::find($id);
        $room->name = ($request->input('name'));
        $room->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
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
        $room = Room::findOrFail($id);
        if($room) {
            $room->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
