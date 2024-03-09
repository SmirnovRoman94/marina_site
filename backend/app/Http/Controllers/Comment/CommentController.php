<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $data = $request->validated();

        $comment = Comment::create($data);

        $newComment = new CommentResource($comment);

        return response()->json(['mess' => 1, 'data' => $newComment]);
    }

    public function index()
    {
        $all = Comment::all();

        $comments = CommentResource::collection($all);

        return response()->json(['mess' => 1, 'data' => $comments]);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json(['mess' => 1]);
    }
}
