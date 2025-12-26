<?php

namespace App\Repository;

use App\Interface\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryRepository  implements CategoryInterface
{
   
    public function createCategory($data)
    {
        return Category::create($data);
    }
    public function updateCategory($data,Category $category)
    {
        return $category->update($data);
    }
    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}
