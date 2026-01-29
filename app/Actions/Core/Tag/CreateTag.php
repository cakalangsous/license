<?php

namespace App\Actions\Core\Tag;

use App\Models\Tag;

class CreateTag
{
    public function execute(array $data): Tag
    {
        return Tag::create($data);
    }
}
