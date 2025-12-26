<?php

namespace App\Services;

use App\Interface\SubCategoryInterface;
use App\Models\SubCategory;

class SubCategoryService
{
    public $subCategoryRepository;

    public function __construct(SubCategoryInterface $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function createSubCategory($request)
    {
        $data = $request->validated();
        try {
        return $this->subCategoryRepository->createSubCategory($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateSubCategory($request, SubCategory $subCategory)
    {

        $data = $request->validated();
        try {
            return $this->subCategoryRepository->updateSubCategory($data, $subCategory);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteSubCategory(SubCategory $subCategory) {
        try {
           
            return $this->subCategoryRepository->deleteSubCategory($subCategory);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
