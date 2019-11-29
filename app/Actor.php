<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{

   /**
     * The pivot that belong to the actor.
     */
    protected $fillable = ['name','insertion', 'surname', 'gender', 'country','birthDate', 'img'];
    public function movies()
    {
        return $this->hasMany(Actor_Movie::class);
    }
}
