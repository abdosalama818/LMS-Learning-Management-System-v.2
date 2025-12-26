<?php

namespace App\Http\Controllers\Dashboard\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public $subCategoryService; 
    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_subcategories = SubCategory::with('category')->paginate(10);
        return view('backend.admin.subcategory.index', compact('all_subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_categories = Category::all();
        return view('backend.admin.subcategory.create', compact('all_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        try {
             $this->subCategoryService->createSubCategory($request);
             return redirect()->route('admin.subcategory.index')->with('success', 'SubCategory created successfully');
        } catch (\Exception $e) {
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
    public function edit(SubCategory $subcategory)
    {
        $all_categories = Category::all();
        $sub_category = $subcategory;
        return view('backend.admin.subcategory.edit', compact('sub_category', 'all_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, SubCategory $subcategory)
    {
        try {
            $this->subCategoryService->updateSubCategory($request, $subcategory);
            return redirect()->route('admin.subcategory.index')->with('success', 'SubCategory updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $subcategory = SubCategory::findOrfail($id);
            $this->subCategoryService->deleteSubCategory($subcategory);
            return redirect()->route('admin.subcategory.index')->with('success', 'SubCategory deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
