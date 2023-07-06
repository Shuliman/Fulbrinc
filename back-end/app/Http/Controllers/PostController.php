<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFound;
use Illuminate\Http\Request;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts;

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        if (!$post = auth()->user()->posts()->find($id))
            throw new NotFound('Post not found');

        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;

        if (!auth()->user()->posts()->save($post))
            throw new BadRequestException('Post not added');

        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ],201);
    }

    public function update(Request $request, $id)
    {
        if (!$post = auth()->user()->posts()->find($id))
            throw new NotFound('Post not found');

        $updated = $post->fill($request->all())->save();

        if (!$updated)
            throw new BadRequestException('Post can not be updated');

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        if (!$post = auth()->user()->posts()->find($id))
            throw new NotFound('Post not found');

        if (!$post->delete())
            throw new BadRequestException('Post can not be deleted');

        return response()->json([
            'success' => true
        ]);
    }
}
