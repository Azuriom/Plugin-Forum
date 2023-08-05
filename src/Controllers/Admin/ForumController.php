<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Role;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\ForumRequest;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with([
            'forums' => function ($query) {
                $query->scopes('parents')->with('forums');
            },
        ])
            ->orderBy('position')
            ->get();

        return view('forum::admin.forums.index', ['categories' => $categories]);
    }

    /**
     * Update the order of the resources.
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

            $this->updateForums($id, $forums, null, $forumPosition);
        }

        return response()->json([
            'message' => trans('forum::admin.forums.updated'),
        ]);
    }

    protected function updateForums(int $categoryId, array $forums, ?int $parentId, int &$position)
    {
        foreach ($forums as $forum) {
            $id = $forum['id'];

            Forum::whereKey($id)->update([
                'position' => $position++,
                'category_id' => $categoryId,
                'parent_id' => $parentId,
            ]);

            $this->updateForums($categoryId, $forum['forums'] ?? [], $id, $position);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forum::admin.forums.create', [
            'categories' => Category::with('forums')->get(),
            'roles' => Role::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ForumRequest $request)
    {
        Forum::create($request->validated());

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
    {
        return view('forum::admin.forums.edit', [
            'categories' => Category::with('forums')->get(),
            'roles' => Role::all(),
            'tags' => Tag::all(),
            'forum' => $forum,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ForumRequest $request, Forum $forum)
    {
        $forum->update($request->validated());

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Forum $forum)
    {
        if ($forum->forums()->exists() || $forum->discussions()->exists()) {
            return redirect()->back()
                ->with('error', trans('forum::admin.forums.delete_error'));
        }

        $forum->delete();

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }
}
