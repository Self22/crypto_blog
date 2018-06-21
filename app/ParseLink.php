<?php

namespace App;

use DB;
use Htmldom;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;

class ParseLink extends Model
{
    use Sluggable;

    protected $fillable = ['href', 'anchor', 'site', 'category', 'tag', 'time', 'date', 'news_text', 'slug', 'description'];

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

    protected static function save_link($href, $anchor, $site, $category, $news_text, $tag = 'null')
    {

        if (ParseLink::where('href', $href)->exists()) {
            return;
        }

        if (ParseLink::where('anchor', $anchor)->exists()) {
            return;
        }

        $link = new ParseLink;
        $link->href = $href;
        $link->anchor = trim(html_entity_decode($anchor));
        $link->site = $site;
        $link->category = $category;
        $link->tag = $tag;
        $link->news_text = $news_text;
        $link->description = htmlspecialchars_decode(strip_tags(stristr($news_text, '.', true)));
        $link->date = ParseLink::getDateAttribute();
        $link->time = ParseLink::getTimeAttribute();
        $link->save();

    }

    public static function parse_coindesk(){

        $html_news = new \Htmldom('https://www.coindesk.com/');
        $links = $html_news->find('a.fade');

        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
        foreach ($links as $element) {
            $anchor = strip_tags($element->innertext);
            $href = $element->href;
            if(!$href){
                continue;
            }
//            echo($anchor).'<br>'.($href);
            if (ParseLink::where('href', $href)->exists()) {
                return;
            }

            $raw_text = new \Htmldom($href);

            $e = $raw_text->find('p');;
            $final_text = '';

            foreach ($e as $live) {
                $live->style = null;
                $live->class = null;
                $live = preg_replace("!<a[^>]*>(.*?)</a>!si", "\\1", $live);
                $live = str_replace('align="justify"', '', $live);
                $live = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace("'<font[^>]*?>.*?</font>'si", "", $live);
                $live = preg_replace("'<em[^>]*?>.*?</em>'si", "", $live);
                $live = preg_replace("'<label[^>]*?>.*?</label>'si", "", $live);
                $live = preg_replace("'<iframe[^>]*?>.*?</iframe>'si", "", $live);
                /*   $live = preg_replace("'<b[^>]*?>.*?</b>'si","",$live);*/


                $final_text = $final_text . $live;
            }

//            echo ($final_text).'<br>'.'<br>';
            ParseLink::save_link($href, $anchor, 'coindesk.com', 'news', $final_text);
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

            foreach ($e as $live) {
                $live->style = null;
                $live->class = null;
                $live = preg_replace("!<a[^>]*>(.*?)</a>!si", "\\1", $live);
                $live = str_replace('align="justify"', '', $live);
                $live = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $live);
                $live = preg_replace("'<font[^>]*?>.*?</font>'si", "", $live);
                $live = preg_replace("'<em[^>]*?>.*?</em>'si", "", $live);
                $live = preg_replace("'<label[^>]*?>.*?</label>'si", "", $live);
                $live = preg_replace("'<iframe[^>]*?>.*?</iframe>'si", "", $live);
                $live = preg_replace("'<b[^>]*?>.*?</b>'si","",$live);


                $final_text = $final_text . $live;
            }

//            echo ($final_text).'<br>'.'<br>';
            ParseLink::save_link($href, $anchor, 'cryptonews.com', 'news', $final_text);
        }
    }

    public static function test_parse()
    {
        $html_news = new \Htmldom('https://www.coindesk.com/dutch-central-bank-blockchain-promising-but-inefficient-in-payments/');
        $links = $html_news->find('.article-content-container');

        // Зайти в цикле в кадый линк, вытащить, очистить и сохранить текст новости
        foreach ($links as $element) {


            echo ($element) . '<br>';
//            if (Link::where('href', $href)->exists()) {
//                return;
//            }


        }
    }
}
