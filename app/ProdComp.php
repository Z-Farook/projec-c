<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdComp extends Model
{
    /**
     * The movies that belong to the actor.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'prod_comp__movies', 'id', 'prodComp_id');
    }
}
