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
        // $posts = Post::simplePaginate(10);

            return view('blog.index', ['posts' => $posts], ['title' => $title]);





    }

    public function show($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        $tags = $post->tags;
        $title = $post->seo_title;

        return view('blog.show')->withPost($post)->withTags($tags)->withTitle($title);
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
        return view('blog.index', ['posts' => $posts], ['name' => $name]);

    }
}
