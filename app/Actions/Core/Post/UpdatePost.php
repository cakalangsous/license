<?php

namespace App\Actions\Core\Post;

use App\Models\Post;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class UpdatePost
{
    public function execute(Post $post, array $data, ?string $filepondFolder = null): Post
    {
        // Handle image upload
        if ($filepondFolder) {
            $temp = TemporaryFile::where('folder', $filepondFolder)->first();

            if ($temp) {
                $realpath = 'posts/'.$data['slug'].'/'.$temp->filename;
                Storage::disk('public')->put($realpath, Storage::get('temp/'.$temp->folder.'/'.$temp->filename));
                $data['image'] = $realpath;

                // Clean up temp file
                Storage::deleteDirectory('temp/'.$temp->folder);
                $temp->delete();
            }
        }

        // Extract and sync tags
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        // Prepare update data
        $data['post_category_id'] = $data['category'];
        unset($data['category']);

        // Handle publish status change
        $currentPublishStatus = $post->publish_status == 'Published' ? 1 : 0;
        if ($data['publish_status'] == 1 && ($data['publish_status'] != $currentPublishStatus)) {
            $data['published_at'] = now();
        }

        // Update post
        $post->update($data);

        // Sync tags
        $post->tags()->sync($tags);

        return $post;
    }
}
