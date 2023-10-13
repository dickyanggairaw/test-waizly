<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function index(Request $request)
    {
        //get all posts
        $posts = Post::latest()->paginate($request->query('limit'));

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request){
        $validator = Validator::make($request -> all(), [
            'image'     => 'required',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        $post = Post::create([
            'image' => $request->image,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return new PostResource(true, 'create data post', $post);
    }

    public function show (Request $request) {
        $data = Post::find($request->route('post'));
        return new PostResource(true, 'success get data', $data);
    }

    public function update (Request $request) {
        $id = $request->route('post');
        $validator = Validator::make($request -> all(), [
            'image'     => 'required',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        $post = Post::find($id);
        
        $post->update([
            'image' => $request->image,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return new PostResource(true, 'create data post', $post);
    }

    protected function destroy (Request $request) {
        $id = $request->route('post');

        $post = Post::find($id);

        $post->delete();

        return new PostResource(true, 'success delete data', null);
    }

}
