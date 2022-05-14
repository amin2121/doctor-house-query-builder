<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $posts = Post::latest()->paginate(5);
        $categories = Category::get();
        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function store(PostRequest $request)
    {
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg, jpg, png, svg|max:5120'
        ]);

        // validate
        $post = $request->all();

        /* mas assigment all */
        $slug = \Str::slug(request()->title);
        $post['slug'] = $slug;

        $thumbnail = $request->file('thumbnail');
        if($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('images/posts', $slug. "." .$thumbnail->extension());
        } else {
            $thumbnail = null;
        }

        $post['thumbnail'] = $thumbnail;
        $post['category_id'] = $request->category;

        $postInsert = auth()->user()->posts()->create($post);

        $postInsert->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');

        return redirect()->to('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg, jpg, png, svg|max:5120'
        ]);

        $validate = $request->all();

        $thumbnail = $request->file('thumbnail');
        if($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('images/posts');
            \Storage::delete($post->thumbnail);
        } else {
            $thumbnail = $post->thumbnail;
        }

        $validate['category_id'] = $request->category;
        $validate['thumbnail'] = $thumbnail;

        $post->update($validate);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');

        return redirect()->to('posts');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete');
        \Storage::delete($post->thumbnail);

        $post->tags()->detach();
        $post->delete();

        session()->flash('success', 'The post was deleted');

        return redirect()->to('posts');
    }
}
