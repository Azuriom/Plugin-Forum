<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Http\Requests\AttachmentRequest;
use Azuriom\Plugin\Forum\Models\Post;

class PostAttachmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Http\Requests\AttachmentRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentRequest $request, Post $post)
    {
        $this->validate($request, ['file' => 'mimes:jpg,jpeg,png,gif']);

        $imageUrl = $post->storeAttachment($request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Http\Requests\AttachmentRequest  $request
     * @param  string  $pendingId
     * @return \Illuminate\Http\Response
     */
    public function pending(AttachmentRequest $request, string $pendingId)
    {
        $this->validate($request, ['file' => 'mimes:jpg,jpeg,png,gif']);

        $imageUrl = Post::storePendingAttachment($pendingId, $request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }
}
