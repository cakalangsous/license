<?php

namespace App\Actions\Core\Tag;

use App\Models\Tag;

class DeleteTag
{
    public function execute(Tag $tag): bool
    {
        return $tag->delete();
    }
}
