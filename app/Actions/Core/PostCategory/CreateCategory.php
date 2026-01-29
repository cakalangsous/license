<?php

namespace App\Actions\Core\PostCategory;

use App\Models\PostCategory;

class CreateCategory
{
    public function execute(array $data): PostCategory
    {
        return PostCategory::create($data);
    }
}
