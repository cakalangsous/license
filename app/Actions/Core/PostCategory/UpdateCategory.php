<?php

namespace App\Actions\Core\PostCategory;

use App\Models\PostCategory;

class UpdateCategory
{
    public function execute(PostCategory $category, array $data): PostCategory
    {
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'] ?? null;
        $category->save();

        return $category;
    }
}
