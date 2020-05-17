<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function addLike(Request $request, Post $post)
    {
        if (! $post->likes()->where('author_id', $request->user()->id)->exists()) {
            $post->likes()->create();
        }

        return response()->json([
            'likes' => $post->likes()->count(),
            'liked' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function removeLike(Request $request, Post $post)
    {
        $post->likes()->where('author_id', $request->user()->id)->delete();

        return response()->json([
            'likes' => $post->likes()->count(),
            'liked' => false,
        ]);
    }
}
