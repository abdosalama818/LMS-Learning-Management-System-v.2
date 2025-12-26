<?php

namespace App\Repository;


use App\Interface\SubCategoryInterface;
use App\Models\SubCategory;


class SubCategoryRepository  implements SubCategoryInterface
{
   
    public function createSubCategory($data)
    {
        return SubCategory::create($data);
    }
    public function updateSubCategory($data,SubCategory $category)
    {
        return $category->update($data);
    }
    public function deleteSubCategory(SubCategory $category)
    {
        return $category->delete();
    }
}
