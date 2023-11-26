<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
class PostController extends Controller
{
    public function index()
    {
        $posts=Post::getAllPost();
        return view ('backend.post.index')->with('posts', $posts);
    }
    public function create(){
        $categories=PostCategory::get();{
        $tags=PostTag::get();
        $users=User::get();
        return view ('backend.post.create')->with('users', $users) ->with('categories', $categories) ->with('tags', $tags);
        }
    }
    public function store (Request $request){
        $this->validate($request, [
            'title' => 'string|required',
            'quote'=>'string|nullable',
            'summary' => 'string|required',
            'description' => 'string | nullable',
            'photo'=>'string|nullable',
            'tags'>'nullable',
            'added_by'=>'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active, inactive'
        ]);
        $data=$request->all();
        $slug=Str::slug ($request->title);
        $count=Post::where ('slug', $slug)->count();
        if ($count>0) {
            $slug=$slug.'-'.date('ymdis').'-'.rand (0,999);
        }
        $data['slug']=$slug;
        $tags=$request->input ('tags');
        if ($tags) {
            $data['tags']=implode(',', $tags);
        }
        else{
            $data['tags']='';
        }
        $status=Post::create($data);
        if ($status) {
            request ()->session ()->flash ('success', 'Post Successfully added');
        }
        else{
            request ()->session ()->flash ('error', 'Please try again!!');
        }
        return redirect ()->route ('post.index');
    }
    public function show ($id){

    }
    public function edit ($id){
        $post=Post::findOrFail ($id);
        $categories=PostCategory::get();
        $tags=PostTag::get();
        $users=User::get();
        return view ('backend.post.edit')->with('categories', $categories) ->with('users', $users)->with('tags', $tags)->with('post', $post);
    }
    public function update (Request $request, $id){
        $post=Post::findOrFail ($id);
        $this->validate ($request, [
            'title' => 'string|required',
            'quote'=>'string | nullable',
            'summary' => 'string|required',
            'description' => 'string | nullable',
            'photo'=>'string | nullable',
            'tags'=>'nullable',
            'added_by'=>'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active, inactive'
        ]);
        $data=$request->all();
        $tags=$request->input ('tags');
        if ($tags) {
            $data['tags']=implode(',', $tags);
        }
        else{
            $data['tags']='';
        }
        $status=$post->fill ($data)->save();
        if ($status) {
            request ()->session ()->flash ('success', 'Post Successfully updated');
        }
        else{
            request()->session ()->flash ('error', 'Please try again!!');
        }
        return redirect ()->route ('post.index');
    }
    public function destroy($id){
        $post=Post::findOrFail ($id);
        $status=$post->delete();
        if ($status) {
            request ()->session ()->flash ('success', 'Post successfully deleted');
        }
        else{
            request ()->session ()->flash ('error', 'Error while deleting post ');
        }
        return redirect ()->route ('post.index');
    }
}