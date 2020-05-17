<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Requests\ForumRequest;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum::admin.forums.index', [
            'categories' => Category::with('forums')->orderBy('position')->get(),
        ]);
    }

    /**
     * Update the order of the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'categories' => ['required', 'array'],
        ]);

        $categories = $request->input('categories');

        $categoryPosition = 1;

        foreach ($categories as $category) {
            $id = $category['id'];
            $forums = $category['forums'] ?? [];

            Category::whereKey($id)->update([
                'position' => $categoryPosition++,
            ]);

            $forumPosition = 1;

            foreach ($forums as $forum) {
                Forum::whereKey($forum)->update([
                    'position' => $forumPosition++,
                    'category_id' => $id,
                ]);
            }
        }

        return response()->json([
            'message' => trans('forum::admin.forums.status.order-updated'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum::admin.forums.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\ForumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForumRequest $request)
    {
        Forum::create($request->validated());

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('forum::admin.forums.status.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forum)
    {
        return view('forum::admin.forums.edit', [
            'categories' => Category::all(),
            'forum' => $forum,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\ForumRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(ForumRequest $request, Forum $forum)
    {
        $forum->update($request->validated());

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('forum::admin.forums.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Forum $forum)
    {
        if ($forum->discussions()->exists()) {
            return redirect()->back()->with('error', trans('forum.forums.status.delete-not-empty'));
        }

        $forum->delete();

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('forum::admin.forums.status.deleted'));
    }
}
