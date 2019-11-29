<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['number', 'row', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
