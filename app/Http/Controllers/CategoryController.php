<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('user_id', Auth::id())
            ->withCount('transactions')
            ->orderBy('type')
            ->orderBy('name')
            ->filter($request->only('filter'))
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create', [
            'types' => ['income', 'expense'],
            'defaultColors' => config('app.category_colors'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,'.Auth::id(),
            'type' => 'required|in:income,expense',
            'color' => 'nullable|string|size:7',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            ...$request->only(['name', 'type', 'color', 'icon'])
        ]);

        return redirect()
            ->route('categories.index')
            ->with('message', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return Inertia::render('Categories/Edit', [
            'category' => $category,
            'types' => ['income', 'expense'],
            'defaultColors' => config('app.category_colors'),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id.',id,user_id,'.Auth::id(),
            'type' => 'required|in:income,expense',
            'color' => 'nullable|string|size:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($request->only(['name', 'type', 'color', 'icon']));

        return redirect()
            ->route('categories.index')
            ->with('message', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->transactions()->exists()) {
            return back()->with('error', 'Cannot delete category with existing transactions');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('message', 'Category moved to trash');
    }
}
