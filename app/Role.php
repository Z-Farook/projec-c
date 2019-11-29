<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The movies that belong to the actor.
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor__movies');
    }

    /**
     * The movies that belong to the actor.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'actor__movies');
    }

    /**
     * The movies that belong to the actor.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
