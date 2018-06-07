<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use App\Settings;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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

            return view('blog.index')->withPosts($posts)->withTitle($title)->withDescription($description)->withH1($main_h1);





    }

    public function show($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        $tags = $post->tags;
        $title = $post->seo_title;
        $description = $post->description;
        return view('blog.show')->withPost($post)->withTags($tags)->withTitle($title)->withDescription($description);
    }

    public function filter_cat($id){
        $posts = Category::find($id)->posts()->paginate(15);
        $category = Category::find($id)->name;
        $title = Category::find($id)->title_page;

        return view('blog.index')->withPosts($posts)->withCategory($category)->withTitle($title);
    }

    public function filter_tag($id){
        $posts = Tag::find($id)->posts()->paginate(15);
        $name = Tag::find($id)->tag;
        $title = Settings::find(1)->main_title;
        return view('blog.index')->withPosts($posts)->withName($name)->withTitle($title);

    }
}
