<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all())->resolve();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $post = Post::firstOrCreate([
            'text' => $data['text'],
            'title' => $data['title'],
            'preview' => $data['preview']
        ]);
        // Прикрепляем изображение
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->path();
            $post->addMedia($imagePath)->toMediaCollection('images');
        }

        return response()->json(['mess' => 1, 'data' => $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $post = Post::findOrFail($id);
        // Прикрепляем новое изображение
        if ($request->hasFile('img')) {
            $post->getFirstMedia('images')->delete();
            $imagePath = $request->file('img')->path();
            $post->addMedia($imagePath)->toMediaCollection('images');
        }

        $post->update([
            'text' => $data['text'],
            'title' => $data['title'],
            'preview' => $data['preview']
        ]);

        return response()->json(['mess' => 1, 'data' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(['mess' => 1, 'data' => '']);
    }
}
