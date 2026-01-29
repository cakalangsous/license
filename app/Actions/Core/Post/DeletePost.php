<?php

namespace App\Actions\Core\Post;

use App\Models\Post;

class DeletePost
{
    public function execute(Post $post): bool
    {
        return $post->delete();
    }
}
