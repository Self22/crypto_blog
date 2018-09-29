<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public static function add_images_to_database()
    {
        $raw_imgs = scandir('img/theme_imgs');


        foreach ($raw_imgs as $key => $img){

            echo($key).'  '.($img).'<br>';

            if (Image::where('url', $img)->exists()) {
                continue;
            }

            if(($key === 0) || ($key === 1)){
                continue;
            }

            $image = new Image;
            $image->url = $img;
            $image->used = 0;
            $image->save();

        }

    }

    public static function get_img_url(){
        $url = Image::where('used', 0)->first();
        $url->used = 1;
        $url->save();
        return $url->url;
    }

}
