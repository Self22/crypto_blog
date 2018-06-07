<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;
use App\Tag;
use Image;

use Illuminate\Support\Facades\Gate;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//         $posts = Post::all();
        $posts = Post::paginate(10);

        return view('admin.posts.index')
            ->with('posts', $posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create')->withCategories($categories)->withTags($tags);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Валидация успешно пройдена

         $post = new Post;
         $post->title = $request->title;
         $post->content = $request->content;
         $post->category_id = $request->category_id;
        $post->seo_title = $request->seo_title.'| HG.IO';
         $post->is_active = $request->is_active;
        $post->description = stristr($request->content, '.', true);

        $this->validate($request, [
            'title' => 'string|required',
            'content' => 'string|required',
        ]);

        if(!($request->hasFile('image'))){
            $post->picture_name = '';
        }

        if ($request->hasFile('image') ) {

            $this->validate($request, [
                'image' => 'image',

            ]);

            $filename = str_replace(' ', '', $_FILES['image']['name']);
            if(Post::where('picture_name', $filename)->exists()){
                $filename = time().$filename;
            }
            $post->picture_name = 'img/'.$filename;

            Image::make($request->file('image'))->save( public_path('img/'. $filename));


        }

        $post->save();
        $post->tags()->sync($request->tags, false);

        return redirect(route('posts.index'))->with('message', 'The blog post was successfully save!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $tags = $post->tags;
        $category = Category::find($post->category_id);

        $category = $category->name;
        return view('admin.posts.show')->withPost($post)->withTags($tags)->withCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('tag', 'id');
        return view('admin.posts.edit')->withPost($post)->withCategories($categories)->withTags($tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->seo_title = $request->seo_title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->is_active = $request->is_active;

        if ($request->hasFile('image') ) {

            $this->validate($request, [
                'image' => 'image',

            ]);

            $filename = str_replace(' ', '', $_FILES['image']['name']);
            if(Post::where('picture_name', $filename)->exists()){
                $filename = time().$filename;
            }
            $post->picture_name = 'img/'.$filename;

            Image::make($request->file('image'))->resize(300, 300)->save( public_path('img/'. $filename));


        }

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync(array());
        }
        return redirect(route('posts.index'))->with('message', 'An article has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        $post->delete();

        return redirect(route('posts.index'))->with('message', 'An article has been deleted');
    }

}
