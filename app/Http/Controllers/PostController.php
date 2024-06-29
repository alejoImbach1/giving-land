<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePostRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\Post;
use App\MyOwn\classes\Utility;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function show($id)
    {
        if(auth()->check() && auth()->user()->posts->find($id)){
            return to_route('home');
        }
        $post = Post::find($id);
        return view('sections.posts.show',compact('post'));
    }
    public function create()
    {
        $post = null;
        return view('sections.posts.create-edit', compact('post'));
    }

    public function edit($index)
    {
        $post = auth()->user()->posts->where('user_post_index', $index)->first();
        return ($post) ? view('sections.posts.create-edit', compact('post')) : to_route('posts.create');
    }

    public function destroy($index)
    {
        $user = auth()->user();
        $post = $user->posts->where('user_post_index',$index)->first();
        if (!$post) {
            return to_route('home');
        }
        foreach ($post->images as $image) {
            Storage::delete('public/posts_images/' . $user->username . '/' . $image->url);
        }
        Post::destroy($post->id);
        // $user->posts->where('user_post_index',$index)->first()->delete();
        $posts = Post::where('user_id',$user->id)->get();
        $index = 0;
        foreach ($posts as $post) {
            $post->user_post_index = $index;
            $post->save();
            $index++;
        }
        // dd($user->posts);
        Utility::sendAlert('warning', 'Se eliminó la publicación');
        return to_route('profile.show', $user->username);
    }
}
