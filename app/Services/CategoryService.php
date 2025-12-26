<?php

namespace App\Services;

use App\Interface\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory($request)
    {
        $data = $request->validated();
        try {
            if ($request->hasFile('image')) {
                $path = Storage::putFile('category', $request->file('image'));
                $data['image'] = $path;
            }
            return $this->categoryRepository->createCategory($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateCategory($request, Category $category)
    {

        $data = $request->validated();
        $path  = $category->image;
        try {
            if ($request->hasFile('image')) {
                if ($path && Storage::exists($path)) {
                    Storage::delete($path);
                }

                $path = Storage::putFile('category', $request->file('image'));
            }
            $data['image'] = $path;
            return $this->categoryRepository->updateCategory($data, $category);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteCategory(Category $category) {
        try {
            if ($category->image && Storage::exists($category->image)) {
                Storage::delete($category->image);
            }
            return $this->categoryRepository->deleteCategory($category);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
