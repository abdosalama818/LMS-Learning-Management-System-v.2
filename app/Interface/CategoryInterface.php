<?php

namespace App\Interface;

use App\Models\Category;

interface CategoryInterface
{
    public function createCategory($request);
    public function updateCategory($request,Category $category);
    public function deleteCategory(Category $category);
}
