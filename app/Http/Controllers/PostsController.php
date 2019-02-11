<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\UniqText;
use App\Tag;
use App\Settings;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use DB;

class PostsController extends Controller
{
    public function index()
    {
        // $posts = DB::table('posts')->get();

        // $posts = Post::all();

//        $posts = \App\Post::all();

         $posts = Post::paginate(10);
        $user = Auth::user();
        $title = Settings::find(1)->main_title;
        $main_h1 = Settings::find(1)->main_h1;
        $description = Settings::find(1)->main_description;
        // $posts = Post::simplePaginate(10);

            return view('blog.expert')
                ->withPosts($posts)
                ->withTitle($title)
                ->withDescription($description)
                ->withH1($main_h1);
    }

    public function show($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        $tags = $post->tags;
        $title = $post->seo_title;
        $description = $post->description;
        return view('blog.show')->withPost($post)->withTags($tags)->withTitle($title)->withDescription($description);
    }

    public function filter_cat($slug){
        $category = Category::where('slug', $slug)->get();
        foreach ($category as $cat){
            $category = $cat->name;
            $title = $cat->title_page;
            $description = $cat->description;
            $posts = Category::find($cat->id)->uniqtexts()->paginate(15);
            return view('blog.index')->withPosts($posts)->withCategory($category)->withTitle($title)->withDescription($description);
        }
//        $category = $category->name;
//        $title = $category['title_page'];
//        $description = $category['description'];
//         $posts = Category::where('slug', $slug)->uniqtexts()->paginate(15);
////
//        return view('blog.index')->withPosts($posts)->withCategory($category)->withTitle($title)->withDescription($description);
    }

    public function filter_tag($slug){
        $experts = Tag::where('slug', $slug)->first()->posts()->paginate(30);
        $uniques = Tag::where('slug', $slug)->first()->uniqTexts()->paginate(40);

        $merged = $uniques->merge($experts);
        $allPosts = $merged->all();
        $tag = Tag::where('slug', $slug)->first();
        $name = $tag->tag;
        $title =  $tag->title;
        $description = $tag->description;
        return view('blog.index')->withPosts($allPosts)->withName($name)->withTitle($title)->withDescription($description);

    }
}
