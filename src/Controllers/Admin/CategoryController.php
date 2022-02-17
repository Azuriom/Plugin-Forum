<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('forum::admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\CategoryRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Category  $category
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category->forums()->exists()) {
            return redirect()->back()->with('error', trans('forum.categories.delete_error'));
        }

        $category->delete();

        return redirect()->route('forum.admin.forums.index')
            ->with('success', trans('messages.status.success'));
    }
}
