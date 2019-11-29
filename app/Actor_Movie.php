<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor_Movie extends Model
{
    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function actor() {
        return $this->belongsTo(Actor::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
