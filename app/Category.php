<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use App\UniqText;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use Sluggable;

    protected $fillable = [
        'name', 'slug', 'title_page', 'description'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts()
    {
        // Получить статьи блога.
        return $this->hasMany('App\Post');

    }

    public function uniqtexts()
    {

        return $this->hasMany('App\UniqText');

    }
}
