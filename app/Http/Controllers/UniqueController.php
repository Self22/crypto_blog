<?php

namespace App\Http\Controllers;

use App\Image;
use App\Uniq_Video;
use App\UniqText;
use App\Settings;
use App\Category;
use Illuminate\Http\Request;
use App\Providers\SeoPaginationElementHelper;
use DanBovey\LinkHeaderPaginator\LengthAwarePaginator;

class UniqueController extends Controller
{
    public function index(){
        $posts = UniqText::orderBy('id', 'desc')->paginate(15);
        $title = Settings::find(1)->uniq_texts_title;
        $main_h1 = Settings::find(1)->uniq_texts_h1;
        $description = Settings::find(1)->uniq_texts_descr;
        // $posts = Post::simplePaginate(10);

        return view('blog.index')->withPosts($posts)->withTitle($title)->withDescription($description)->withH1($main_h1);

    }

    public function show($slug){
        $article = UniqText::whereSlug($slug)->firstOrFail();
        $category = Category::where('id', $article->category_id)->firstOrFail();
        $title = strip_tags($article->anchor);
        $description = $article->description;
//        var_dump($category);
        return view('blog.show')->withArticle($article)->withTitle($title)->withDescription($description)->withCategory($category);
    }

    public function test4(){
        UniqText::create_uniq_news();
    }

    public function test6(){
        UniqText::test_wordai();
    }

    public function test5(){
        UniqText::addTagsAndCategoriesToArticles();

    }

    public function clean(){
        UniqText::clean_uniq_text();
    }

    public function repair(){
        UniqText::repair_uniq_text();
    }


    public function add_images_to_database(){
        Image::add_images_to_database();
    }

    public function add_video_to_database(){
        Uniq_Video::add_video_to_database();
    }

    public function sanitize(){
        UniqText::deleteBadParse();
    }


}
