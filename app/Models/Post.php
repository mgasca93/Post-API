<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'extract', 'body', 'status' ];

    /**
     * Relation one tom many inverse of user
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Relation one to many inverso of categoty
     */
    public function category()
    {
        return $this->belongsTo( Category::class );
    }

    /**
     * Relation many to many of post and tag
     */
    public function tags()
    {
        return $this->belongsToMany( Tag::class );
    }

    /**
     * Relation one to many morph
     */
    public function images()
    {
        return $this->morphMany( Image::class, 'imageable' );
    }
}
