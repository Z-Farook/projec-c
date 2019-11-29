<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name'];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
