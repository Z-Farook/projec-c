<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * The movies that belong to the actor.
     */
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }
}
