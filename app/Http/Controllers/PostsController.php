<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
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
        // $posts = Post::simplePaginate(10);

            return view('blog.index', ['posts' => $posts]);





    }

    public function show($id)
    {
        $post = Post::find($id);
        $tags = $post->tags;
        return view('blog.show')->withPost($post)->withTags($tags);
    }

    public function filter_cat($id){
        $posts = Category::find($id)->posts()->paginate(15);
        $category = Category::find($id)->name;
        return view('blog.index', ['posts' => $posts], ['category' => $category]);
    }

    public function filter_tag($id){
        $posts = Tag::find($id)->posts()->paginate(15);
        $name = Tag::find($id)->tag;
        return view('blog.index', ['posts' => $posts], ['name' => $name]);

    }
}
