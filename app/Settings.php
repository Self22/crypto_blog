<?php

namespace App;

use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    public static function createSitemap(){
        SitemapGenerator::create('https://hashgame.io/')->writeToFile(public_path('sitemap.xml'));
    }

}
