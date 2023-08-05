<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forum::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('forum::admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Category $category)
    {
        if ($category->forums()->exists()) {
            return redirect()->back()->with('error', trans('forum.categories.delete_error'));
        }

        $category->delete();

        return to_route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }
}
