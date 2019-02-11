<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uniq_Video extends Model
{
    public static function add_video_to_database(){
        $raw_video = file_get_contents('../resources/video_raw/video.txt');
//        echo($raw_video);
        $video_arr = explode(PHP_EOL, $raw_video);
        print_r($video_arr);
        echo '<br><hr>';

        foreach ($video_arr as $url){

            if (Uniq_Video::where('video_url', $url)->exists()) {
                echo $url.'<br>';
                continue;
            }
            $video = new Uniq_Video();
            $video->video_url ='<iframe class="theme_video" src="'.trim(str_replace('watch?v=', 'embed/', $url)).'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            $video->used = 0;
            $video->save();

        }
    }

    public static function get_video_url(){
        $url = Uniq_Video::where('used', 0)->first();
        $url->used = 1;
        $url->save();
        return $url->video_url;
    }


}
