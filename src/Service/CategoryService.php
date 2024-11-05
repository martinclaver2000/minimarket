<?php

namespace App\Service;

use App\Entity\Category;

class CategoryService
{
    /**
     * This function allows us to make the family tree of a category
     * thanks to this category and classifies the parent categories
     * from the oldest to the category itself in an array.
     *
     * @return Category []
     */
    public function getCategoryHierarchy(Category $category): array
    {
        $hierarchy = [];
        while ($category) {
            $hierarchy[] = $category;
            $category = $category->getParent();
        }

        return array_reverse($hierarchy);
    }
}
