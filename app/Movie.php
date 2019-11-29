<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'description', 'releaseDate', 'spokenLang', 'ageRestriction', 'trailerLink', 'duration', 'director', 'header_img', 'thumbnail_img'];

    /**
     * The genres that belong to the movie.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre__movies', 'movie_id', 'id');
    }

    /**
     * The productions companies that belong to the movie.
     */
    public function prodComps()
    {
        return $this->belongsToMany(ProdComp::class, 'prod_comp__movies', 'movie_id', 'id');
    }

    /**
     * The pivot for actors that belongs to the movie.
     */
    public function actors()
    {
        return $this->hasMany(Actor_Movie::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}