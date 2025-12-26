<?php

namespace App\Http\Controllers\Dashboard\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_categories = Category::with('subcategories')->paginate(10);
        return view('backend.admin.category.index', compact('all_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try{
            $this->categoryService->createCategory($request);
            return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('backend.admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try{
            $this->categoryService->updateCategory($request, $category);
            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try{
            $category = Category::findOrFail($id);
            $this->categoryService->deleteCategory($category);
            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
