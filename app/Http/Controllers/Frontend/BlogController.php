<?php

namespace App\Http\Controllers\Frontend;

use App\Actions\Frontend\Blog\GetPublishedPosts;
use App\Actions\Frontend\Blog\GetSinglePost;
use Inertia\Response as InertiaResponse;

class BlogController extends FrontendController
{
    public function index(): InertiaResponse
    {
        $this->data['posts'] = (new GetPublishedPosts)->execute();
        $this->data['title'] = 'Blog';

        return $this->inertia('Frontend/Blog/Index');
    }

    public function show(string $slug): InertiaResponse
    {
        $this->data['post'] = (new GetSinglePost)->execute($slug);
        $this->data['title'] = $this->data['post']['title'];

        return $this->inertia('Frontend/Blog/Show');
    }
}
