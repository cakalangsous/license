<?php

namespace App\Actions\Core\Tag;

use App\Models\Tag;

class UpdateTag
{
    public function execute(Tag $tag, array $data): Tag
    {
        $tag->name = $data['name'];
        $tag->slug = $data['slug'];
        $tag->description = $data['description'] ?? null;
        $tag->save();

        return $tag;
    }
}
