<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryJsonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        return CategoryResource::collection(
            Category::query()->paginate($request->query('per_page', 10))
        );
    }

    public function store(CategoryRequest $request)
    {
        return CategoryResource::make(
            Category::create($request->validated())
        );
    }

    public function show(Category $category)
    {        
        return CategoryResource::make($category);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $category->update($request->validated());

        return CategoryResource::make($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => __('Successfully delete category'),
        ]);
    }
}
