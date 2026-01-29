<?php

namespace App\Actions\Core\Post;

use App\Models\Post;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class CreatePost
{
    public function execute(array $data, ?string $filepondFolder = null): Post
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

        // Extract tags before creating post
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        // Prepare post data
        $postData = [
            'post_category_id' => $data['category'],
            'user' => auth()->user()->id,
            'slug' => $data['slug'],
            'title' => $data['title'],
            'body' => $data['body'],
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'publish_status' => $data['publish_status'],
            'published_at' => $data['publish_status'] == 1 ? now() : null,
            'allow_comments' => $data['allow_comments'] ?? false,
            'image' => $data['image'] ?? null,
        ];

        $post = Post::create($postData);

        // Attach tags
        if (! empty($tags)) {
            $post->tags()->attach($tags);
        }

        return $post;
    }
}
