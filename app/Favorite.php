<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'movie_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function movie()
    {
        $this->belongsTo(Movie::class);
    }
}
