<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\TagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('forum::admin.tags.index', ['tags' => Tag::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forum::admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->validated());

        return to_route('forum.admin.tags.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('forum::admin.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return to_route('forum.admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return to_route('forum.admin.tags.index');
    }
}
