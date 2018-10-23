<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    protected $fillable = [
        'tag', 'slug', 'title', 'description'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'tag'
            ]
        ];
    }


    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public function uniqTexts()
    {
        return $this->belongsToMany('App\UniqText','uniq_text_tag', 'tag_id','uniq_text_id');
    }

}
