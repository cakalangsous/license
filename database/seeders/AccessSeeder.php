<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role perms
        Permission::create(['name' => 'roles_view', 'table_name' => 'roles']);
        Permission::create(['name' => 'roles_create', 'table_name' => 'roles']);
        Permission::create(['name' => 'roles_update', 'table_name' => 'roles']);
        Permission::create(['name' => 'roles_delete', 'table_name' => 'roles']);

        // permission perms
        Permission::create(['name' => 'permissions_view', 'table_name' => 'permissions']);
        Permission::create(['name' => 'permissions_create', 'table_name' => 'permissions']);
        Permission::create(['name' => 'permissions_update', 'table_name' => 'permissions']);
        Permission::create(['name' => 'permissions_delete', 'table_name' => 'permissions']);

        // user perms
        Permission::create(['name' => 'users_view', 'table_name' => 'users']);
        Permission::create(['name' => 'users_create', 'table_name' => 'users']);
        Permission::create(['name' => 'users_update', 'table_name' => 'users']);
        Permission::create(['name' => 'users_delete', 'table_name' => 'users']);

        // access perms
        Permission::create(['name' => 'access_view', 'table_name' => 'access']);
        Permission::create(['name' => 'access_update', 'table_name' => 'access']);

        // post_categories perms
        Permission::create(['name' => 'post_categories_view', 'table_name' => 'post_categories']);
        Permission::create(['name' => 'post_categories_create', 'table_name' => 'post_categories']);
        Permission::create(['name' => 'post_categories_update', 'table_name' => 'post_categories']);
        Permission::create(['name' => 'post_categories_delete', 'table_name' => 'post_categories']);

        // tags perms
        Permission::create(['name' => 'tags_view', 'table_name' => 'tags']);
        Permission::create(['name' => 'tags_create', 'table_name' => 'tags']);
        Permission::create(['name' => 'tags_update', 'table_name' => 'tags']);
        Permission::create(['name' => 'tags_delete', 'table_name' => 'tags']);

        // posts perms
        Permission::create(['name' => 'posts_view', 'table_name' => 'posts']);
        Permission::create(['name' => 'posts_create', 'table_name' => 'posts']);
        Permission::create(['name' => 'posts_update', 'table_name' => 'posts']);
        Permission::create(['name' => 'posts_delete', 'table_name' => 'posts']);

        // settings perms
        Permission::create(['name' => 'settings_view', 'table_name' => 'settings']);
        Permission::create(['name' => 'settings_edit', 'table_name' => 'settings']);

        // sidebar menu perms
        Permission::create(['name' => 'sidebar_menu_view', 'table_name' => 'sidebar_menus']);
        Permission::create(['name' => 'sidebar_menu_create', 'table_name' => 'sidebar_menus']);
        Permission::create(['name' => 'sidebar_menu_update', 'table_name' => 'sidebar_menus']);
        Permission::create(['name' => 'sidebar_menu_delete', 'table_name' => 'sidebar_menus']);

        // crud builder perms
        Permission::create(['name' => 'crud_builder_view', 'table_name' => 'crud_builder']);
        Permission::create(['name' => 'crud_builder_create', 'table_name' => 'crud_builder']);
        Permission::create(['name' => 'crud_builder_delete', 'table_name' => 'crud_builder']);

        // api tokens perms
        Permission::create(['name' => 'api_tokens_view', 'table_name' => 'api_tokens']);
        Permission::create(['name' => 'api_tokens_create', 'table_name' => 'api_tokens']);
        Permission::create(['name' => 'api_tokens_delete', 'table_name' => 'api_tokens']);

        // media perms
        Permission::create(['name' => 'media_view', 'table_name' => 'media']);
        Permission::create(['name' => 'media_upload', 'table_name' => 'media']);
        Permission::create(['name' => 'media_delete', 'table_name' => 'media']);

        // activity log perms
        Permission::create(['name' => 'activity_log_view', 'table_name' => 'activity_log']);
        Permission::create(['name' => 'activity_log_delete', 'table_name' => 'activity_log']);

        // notifications perms
        Permission::create(['name' => 'notifications_view', 'table_name' => 'notifications']);
        Permission::create(['name' => 'notifications_delete', 'table_name' => 'notifications']);

        // system health perms (uses settings_view)

        // backup perms (uses settings_edit)
    }
}
