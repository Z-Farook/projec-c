<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Show::with('movie')
            ->with('room')
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
        $show = Show::create($request->all());
        if($show)
            return response()->json($show, 200);
        else
            return response()->json("error");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function show(Show $show)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id, Request $request)
    {
        //protected $fillable = ['movie_id', 'room_id', 'startTime'];

        $show = Show::find($id);
        $show->movie_id = ($request->input('movie_id'));
        $show->room_id = ($request->input('room_id'));
        $show->startTime = ($request->input('startTime'));
        $show->save();
    }

/* migrattion file
public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('movie_id');
            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');

            $table->unsignedInteger('room_id');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');

            $table->dateTime('startTime');
            $table->timestamps();

            $table->unique(['room_id', 'startTime']);
        });
    } *\

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Show $show)
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
        $show = Show::findOrFail($id);
        if($show) {
            $show->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
