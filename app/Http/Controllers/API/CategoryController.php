<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'categories' => auth()->user()->categories
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = auth()->user()->categories()->create($request->validated());
        return response()->json($category, 201);
    }
}