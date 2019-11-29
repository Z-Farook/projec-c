<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['amount', 'user_id', 'movie_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
