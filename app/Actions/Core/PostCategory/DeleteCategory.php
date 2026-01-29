<?php

namespace App\Actions\Core\PostCategory;

use App\Models\PostCategory;

class DeleteCategory
{
    public function execute(PostCategory $category): bool
    {
        return $category->delete();
    }
}
