<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $fillable = ['movie_id', 'room_id', 'startTime'];

    /**
     * The movie that belongs to the show.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * The room companies that belongs to the show.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
