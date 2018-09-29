<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag', 'title_page', 'description'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public function uniqTexts()
    {
        return $this->belongsToMany('App\UniqText','uniq_text_tag', 'tag_id','uniq_text_id');
    }

}
