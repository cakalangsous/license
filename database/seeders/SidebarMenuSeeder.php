<?php

namespace Database\Seeders;

use App\Models\SidebarMenu;
use Illuminate\Database\Seeder;

class SidebarMenuSeeder extends Seeder
{
    public function run(): void
    {
        $dashboard = SidebarMenu::firstOrCreate(
            ['title' => 'Dashboard', 'section' => 'Menu'],
            [
                'route_name' => 'admin.dashboard',
                'icon' => 'squares-2x2',
                'section' => 'Menu',
                'permission' => null,
                'parent_id' => null,
                'order' => 0,
                'is_active' => true,
            ]
        );

        $posts = SidebarMenu::firstOrCreate(
            ['title' => 'Posts', 'section' => 'Menu'],
            [
                'route_name' => '#',
                'icon' => 'document-text',
                'section' => 'Menu',
                'permission' => null,
                'parent_id' => null,
                'order' => 1,
                'is_active' => true,
            ]
        );

        $postsChildren = [
            [
                'title' => 'Categories',
                'route_name' => 'admin.post_categories.index',
                'permission' => 'post_categories_view',
                'order' => 0,
            ],
            [
                'title' => 'Tags',
                'route_name' => 'admin.tags.index',
                'permission' => 'tags_view',
                'order' => 1,
            ],
            [
                'title' => 'All Posts',
                'route_name' => 'admin.posts.index',
                'permission' => 'posts_view',
                'order' => 2,
            ],
            [
                'title' => 'New Post',
                'route_name' => 'admin.posts.create',
                'permission' => 'posts_create',
                'order' => 3,
            ],
        ];

        foreach ($postsChildren as $child) {
            SidebarMenu::firstOrCreate(
                ['title' => $child['title'], 'parent_id' => $posts->id],
                [
                    'route_name' => $child['route_name'],
                    'icon' => null,
                    'section' => 'Menu',
                    'permission' => $child['permission'],
                    'parent_id' => $posts->id,
                    'order' => $child['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
