<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UniqText;
use DB;

class UniqTextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('uniq_texts')->orderBy('id', 'desc')->paginate(15);

        return view('admin.uniq_texts.index')
            ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = UniqText::find($id);
        return view('admin.posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = UniqText::find($id);
        return view('admin.uniq_texts.edit')->withPost($post);
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
        $post = UniqText::find($id);
        $post->anchor = $request->anchor;
        $post->description = $request->description;
        $post->news_text = $request->news_text;
        $post->save();

        return redirect(route('uniq_texts.index'))->with('message', 'An uniq text has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = UniqText::find($id);
        if($post->tags()){
            $post->tags()->detach();
        }
        $post->delete();

        return redirect(route('uniq_texts.index'))->with('message', 'An article has been deleted');
    }
}
