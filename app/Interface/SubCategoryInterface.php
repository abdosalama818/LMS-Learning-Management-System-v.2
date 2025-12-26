<?php

namespace App\Interface;

use App\Models\SubCategory;

interface SubCategoryInterface
{
    public function createSubCategory($request);
    public function updateSubCategory($request,SubCategory $subCategory);
    public function deleteSubCategory(SubCategory $subCategory);
}
