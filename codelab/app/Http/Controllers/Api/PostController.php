<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return new PostResource(true, 'List Data Posts', $posts);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('/public/posts', $image->hashName());

        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return new PostResource(true, 'Data Post Berhasil ditambahkan', $post);
    }

    public function show($id)
    {   
        $post = Post::find($id);
        return new PostResource(true, 'Detail Data Post!', $post);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image ');
        } else {
            $image = $post->image;
        }

        $image = $request->file('image');
        $image->storeAs('/public/posts', $image->hashName());

        Storage::delete('public/posts/', basename($post->image));

        $post->update([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return new PostResource(true, 'Data Post Berhasil diupdate', $post);
    }

    public function destroy($id) {
        $post = Post::find($id);
        Storage::delete('public/posts/' . basename($post->image));

        $post->delete();

        return new PostResource(true, 'Data Post Berhasil dihapus', null);
    }

}
