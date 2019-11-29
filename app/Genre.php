<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * The movies that belong to the actor.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'genre__movies', 'id', 'genre_id');
    }
}
