<?php

namespace App;

use DB;
use Htmldom;
use App\Image;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
//use JonnyW\PhantomJs\Client;

class ParseLink extends Model
{
    use Sluggable;

    protected $fillable = ['href', 'anchor', 'site', 'category', 'tag', 'time', 'date', 'news_text', 'slug', 'description', 'uniqued'];

    public static function getDateAttribute()
    {
        setlocale(LC_ALL, 'ru' . '.utf-8', 'ru_RU' . '.utf-8', 'ru', 'ru_RU');
//        return (Carbon::now('Europe/Kiev')->formatLocalized("%d %B, %Y"));
        return '555';
    }

    public static function getTimeAttribute()
    {
        setlocale(LC_ALL, 'ru' . '.utf-8', 'ru_RU' . '.utf-8', 'ru', 'ru_RU');
//        return (Carbon::now('Europe/Kiev')->format('H:i'));
        return '555';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'anchor'
            ]
        ];
    }

    protected static function save_link($href, $anchor, $description, $site, $category, $news_text, $img, $tag = 'null')
    {

        if (ParseLink::where('href', $href)->exists()) {
            return;
        }

        if (ParseLink::where('anchor', $anchor)->exists()) {
            return;
        }

        $link = new ParseLink;
        $link->href = $href;
        $link->anchor = trim(strip_tags(html_entity_decode($anchor)));
        $link->site = $site;
        $link->category = $category;
        $link->tag = $tag;
        $link->news_text = $news_text;
        $link->description = html_entity_decode(html_entity_decode($description));
        $link->img_preview = $img;
        $link->date = ParseLink::getDateAttribute();
        $link->time = ParseLink::getTimeAttribute();
        $link->uniqued = 0;
        $link->save();

    }

    public static function parse_coindesk()
    {

        $html_news = new \Htmldom('https://www.coindesk.com/');
        $links = $html_news->find('a.fade');

        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
        foreach ($links as $element) {
            $anchor = strip_tags($element->innertext);
            $href = $element->href;

            if(!$href){
                continue;
            }

            if (ParseLink::where('href', $href)->exists()) {
                return;
            }

            $raw_text = new \Htmldom($href);

            $e = $raw_text->find('p');
            if((count($e)<10)){
                return;
            }
            $final_text = '';

            // random num for video
            $rand_num = rand(1,6);

            // random num for paragraph image
            $count_e = count($e)-2;
            $rand_p = rand(2, $count_e);

            foreach ($e as $key=>$live) {
                $live->style = null;
                $live->class = null;
                $live = preg_replace("!<a[^>]*>(.*?)</a>!si", "\\1", $live);
                $live = str_replace('align="justify"', '', $live);
                $live = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace('/<input(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace("'<font[^>]*?>.*?</font>'si", "", $live);
                $live = preg_replace("'<em[^>]*?>.*?</em>'si", "", $live);
                $live = preg_replace("'<label[^>]*?>.*?</label>'si", "", $live);
                $live = preg_replace("'<iframe[^>]*?>.*?</iframe>'si", "", $live);
                $live = preg_replace("'Sign up for Blockchain Bites and CoinDesk Weekly, sent Sunday-Friday. By Registering, you agree to the terms and conditions and privacy policy'", '', $live);
                $live = ucfirst($live);
                /*   $live = preg_replace("'<b[^>]*?>.*?</b>'si","",$live);*/



                if($key == $rand_p){
                    $url = Image::get_img_url();
                    $img = '<img src="../img/theme_imgs/'.$url.'" alt="'.$anchor.'" class="theme__image">';
                    $imgPreview = '../img/theme_imgs/'.$url;
                    $final_text = $final_text . $img;
                }


                if($rand_num == 2){
                    if($key == $rand_p){
                        $url = Uniq_Video::get_video_url();
                        $final_text = $final_text . $url;
                    }
                }

                $final_text = $final_text . $live;
            }

            // вытаскиваем дескрипшн, если его нет, то создаём из первого предложения текста

            $meta_tags = get_meta_tags($href);

            if(array_key_exists('twitter:description', $meta_tags)){
                $description = html_entity_decode($meta_tags['twitter:description']);
            }
            else{
                $description = html_entity_decode(strip_tags(stristr($final_text, '.', true)));
            }
            if(empty($description)){
                $description = "The biggest world portal: Cryptocurrency, Crypto Games and Blockchain Technology Latest News - on Hashgame.io";
            }

            $final_text = $anchor.'. Kcoin '.$description.'. Kcoin '.$final_text;

            ParseLink::save_link($href, $anchor, $description, 'coindesk.com', 'news', $final_text, $imgPreview);
        }
    }


    public static function parse_cryptonews(){

        $html_news = new \Htmldom('https://cryptonews.com/news/');
        $links = $html_news->find('h4 a');

        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
        foreach ($links as $element) {
            $anchor = strip_tags($element->innertext);
            $href = 'https://cryptonews.com'.$element->href;
            if(!$href){
                continue;
            }
//            echo($anchor).'<br>'.'<br>'.($href);
            if (ParseLink::where('href', $href)->exists()) {
                return;
            }
            $raw_text = new \Htmldom($href);

            $e = $raw_text->find('.cn-content p');

            $final_text = '';

            // random num for video
            $rand_num = rand(1,6);

            // random num for paragraph image
            $count_e = count($e)-2;
            $rand_p = rand(2, $count_e);


            foreach ($e as $key=>$live) {
                $live->style = null;
                $live->class = null;
                $live = preg_replace("!<a[^>]*>(.*?)</a>!si", "\\1", $live);
                $live = str_replace('align="justify"', '', $live);
                $live = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace('/<input(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace("'<font[^>]*?>.*?</font>'si", "", $live);
                $live = preg_replace("'<em[^>]*?>.*?</em>'si", "", $live);
                $live = preg_replace("'<label[^>]*?>.*?</label>'si", "", $live);
                $live = preg_replace("'<iframe[^>]*?>.*?</iframe>'si", "", $live);
                $live = preg_replace("'<b[^>]*?>.*?</b>'si","",$live);
                $live = ucfirst($live);

                if($key == $rand_p){
                    $url = Image::get_img_url();
                    $img = '<div class="theme__image"><img src="../img/theme_imgs/'.$url.'" alt="'.trim($anchor).'"></div>';
                    $imgPreview = '../img/theme_imgs/'.$url;
                    $final_text = $final_text . $img;
                }


                if($rand_num == 2){
                    if($key == $rand_p){
                        $url = Uniq_Video::get_video_url();
                        $final_text = $final_text . $url;
                    }
                }

                $final_text = $final_text . $live;
            }

            $description = html_entity_decode(strip_tags(stristr($final_text, '.', true)));
            if(empty($description)){
                $description = "The biggest world portal: Cryptocurrency, Crypto Games and Blockchain Technology Latest News - on Hashgame.io";
            }

            $final_text = $anchor.'. Kcoin '.$description.'. Kcoin '.$final_text;

            ParseLink::save_link($href, $anchor, $description,'cryptonews.com', 'news', $final_text, $imgPreview);
        }
    }

    public static function clean_parse_text(){
        $texts = ParseLink::all(['id', 'news_text']);
        foreach ($texts as $text){
            $raw = $text->news_text;
            $raw = htmlspecialchars_decode($raw);
            $newText = ParseLink::find($text->id);
            $newText->news_text = $raw;
            $newText->save();

        }
    }



//    public static function parse_cointelegraph()
//    {
//        set_time_limit(3600);
//        $html_news = new \Htmldom('https://cointelegraph.com/');
//        $links = $html_news->find('.post a[title]');
//
//        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
//        foreach ($links as $element) {
//            $anchor = strip_tags(trim($element->innertext));
//            $href = $element->href;
//            $meta_tags = get_meta_tags($href);
//            $description = $meta_tags['description'];
//
//            if(!$href){
//                continue;
//            }
////            echo($anchor).'<br>'.'<br>'.($href);
//            if (ParseLink::where('href', $href)->exists()) {
//                return;
//            }
//            $raw_text = new \Htmldom($href);
//
//            $e = $raw_text->find('p[dir]');
//            $final_text = '';
//            $rand_num = rand(1,6);
////            echo '<b>Случайное число</b>'.$rand_num.'<br>';
//            $count_e = count($e)-2;
//            $rand_p = rand(0, $count_e);
////            echo '<b>Случайный параграф</b>'.$rand_p.'<br>';
//
//            foreach ($e as $key=>$live) {
//                $live->style = null;
//                $live->class = null;
//                $live->dir = null;
//                $live = preg_replace("!<a[^>]*>(.*?)</a>!si", "\\1", $live);
//                $live = str_replace('align="justify"', '', $live);
/*                $live = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $live);*/
/*                $live = preg_replace("'<font[^>]*?>.*?</font>'si", "", $live);*/
/*                $live = preg_replace("'<em[^>]*?>.*?</em>'si", "", $live);*/
/*                $live = preg_replace("'<label[^>]*?>.*?</label>'si", "", $live);*/
/*                $live = preg_replace("'<iframe[^>]*?>.*?</iframe>'si", "", $live);*/
/*                $live = preg_replace("'<b[^>]*?>.*?</b>'si","",$live);*/
//
//
//                if($key == $rand_p){
//                    $url = Image::get_img_url();
//                    $img = '<img src="../img/theme_imgs/'.$url.'" alt="'.$anchor.'" class="theme__image">';
//                    $imgPreview = '../img/theme_imgs/'.$url;
//                    $final_text = $final_text . $img;
//                }
//
//
//                if($rand_num == 2){
//                    if($key == $rand_p){
//                        $url = Uniq_Video::get_video_url();
//                        $final_text = $final_text . $url;
//                    }
//                }
//
//                $final_text = $final_text . $live;
//            }
//
//            $meta_tags = get_meta_tags($href);
//
//            if(array_key_exists('twitter:description', $meta_tags)){
//                $description = html_entity_decode($meta_tags['twitter:description']);
//            }
//            else{
//                $description = html_entity_decode(strip_tags(stristr($final_text, '.', true)));
//            }
//
//            ParseLink::save_link($href, $anchor, $description,'cointelegraph.com', 'news', $final_text, $imgPreview);
//
//        }
//    }

//    public static function parse_tradingview(){
//        $client = Client::getInstance();
//
//        $client->getEngine()->setPath('/home/hashmmbo/public_html/bin/phantomjs');
//
//        $request = $client->getMessageFactory()->createRequest('https://www.tradingview.com/', 'GET');
//
//        /**
//         * @see JonnyW\PhantomJs\Http\Response
//         **/
//        $response = $client->getMessageFactory()->createResponse();
//
//        // Send the request
//        $client->send($request, $response);
//
//        if($response->getStatus() === 200) {
//
//            // Dump the requested page content
//            $html_news = new \Htmldom($response->getContent());
//            $links = $html_news->find('.tv-widget-news--link');
//
//            foreach ($links as $element) {
//                $anchor = strip_tags($element->innertext);
//                $href = $element->href;
//                echo ($anchor).'<br>'.($href).'<br><br>';
//
//            }
//
//        }
//    }
//
//    public static function test_parse()
//    {
//        $html_news = new \Htmldom('https://www.coindesk.com/dutch-central-bank-blockchain-promising-but-inefficient-in-payments/');
//        $links = $html_news->find('.article-content-container');
//
//        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
//        foreach ($links as $element) {
//
//
//            echo ($element) . '<br>';
////            if (Link::where('href', $href)->exists()) {
////                return;
////            }
//
//
//        }
//    }
}
