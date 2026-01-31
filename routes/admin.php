<?php

use App\Http\Controllers\Core\AccessController;
use App\Http\Controllers\Core\ActivationController;
use App\Http\Controllers\Core\BlacklistedDomainController;
use App\Http\Controllers\Core\Crud\CrudController;
use App\Http\Controllers\Core\DashboardController;
use App\Http\Controllers\Core\LicenseController;
use App\Http\Controllers\Core\MarketplaceController;
use App\Http\Controllers\Core\PermissionController;
use App\Http\Controllers\Core\PostCategoryController;
use App\Http\Controllers\Core\PostController;
use App\Http\Controllers\Core\ProductController;
use App\Http\Controllers\Core\RoleController;
use App\Http\Controllers\Core\SaleController;
use App\Http\Controllers\Core\SettingsController;
use App\Http\Controllers\Core\SidebarMenuController;
use App\Http\Controllers\Core\TagController;
use App\Http\Controllers\Core\UploadController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\VerificationLogController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/crud_generated.php';

// License Management Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::prefix('licenses')->name('licenses.')->group(function () {
    Route::get('/', [LicenseController::class, 'index'])->name('index');
    Route::get('/{license}', [LicenseController::class, 'show'])->name('show');
    Route::post('/', [LicenseController::class, 'store'])->name('store');
    Route::put('/{license}', [LicenseController::class, 'update'])->name('update');
    Route::delete('/{license}', [LicenseController::class, 'destroy'])->name('destroy');
    Route::post('/{license}/revoke', [LicenseController::class, 'revoke'])->name('revoke');
    Route::post('/{license}/suspend', [LicenseController::class, 'suspend'])->name('suspend');
    Route::post('/{license}/reactivate', [LicenseController::class, 'reactivate'])->name('reactivate');
});

Route::prefix('activations')->name('activations.')->group(function () {
    Route::get('/', [ActivationController::class, 'index'])->name('index');
    Route::post('/{activation}/deactivate', [ActivationController::class, 'deactivate'])->name('deactivate');
    Route::post('/{activation}/block', [ActivationController::class, 'block'])->name('block');
    Route::post('/{activation}/reactivate', [ActivationController::class, 'reactivate'])->name('reactivate');
    Route::delete('/{activation}', [ActivationController::class, 'destroy'])->name('destroy');
});

Route::prefix('marketplaces')->name('marketplaces.')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');
    Route::post('/', [MarketplaceController::class, 'store'])->name('store');
    Route::put('/{marketplace}', [MarketplaceController::class, 'update'])->name('update');
    Route::delete('/{marketplace}', [MarketplaceController::class, 'destroy'])->name('destroy');
});

Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('index');
});

Route::prefix('verification-logs')->name('verification-logs.')->group(function () {
    Route::get('/', [VerificationLogController::class, 'index'])->name('index');
    Route::get('/{verificationLog}', [VerificationLogController::class, 'show'])->name('show');
});

Route::prefix('blacklisted-domains')->name('blacklisted-domains.')->group(function () {
    Route::get('/', [BlacklistedDomainController::class, 'index'])->name('index');
    Route::post('/', [BlacklistedDomainController::class, 'store'])->name('store');
    Route::put('/{blacklistedDomain}', [BlacklistedDomainController::class, 'update'])->name('update');
    Route::delete('/{blacklistedDomain}', [BlacklistedDomainController::class, 'destroy'])->name('destroy');
    Route::post('/check', [BlacklistedDomainController::class, 'check'])->name('check');
});

// Sidebar Menu Builder Routes
Route::prefix('sidebar-menus')->name('sidebar-menus.')->group(function () {
    Route::get('/', [SidebarMenuController::class, 'index'])->name('index');
    Route::post('/', [SidebarMenuController::class, 'store'])->name('store');
    Route::put('/{sidebarMenu}', [SidebarMenuController::class, 'update'])->name('update');
    Route::delete('/{sidebarMenu}', [SidebarMenuController::class, 'destroy'])->name('destroy');
    Route::post('/reorder', [SidebarMenuController::class, 'reorder'])->name('reorder');
    Route::post('/{sidebarMenu}/toggle', [SidebarMenuController::class, 'toggleActive'])->name('toggle');
    Route::post('/{sidebarMenu}/add-child', [SidebarMenuController::class, 'addChild'])->name('add-child');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('post_categories/data', [PostCategoryController::class, 'post_categories_data'])->name('post_categories.data');
Route::resource('post_categories', PostCategoryController::class)->except('show', 'edit', 'create');
Route::get('tags/data', [TagController::class, 'tags_data'])->name('tags.data');
Route::resource('tags', TagController::class)->except('show', 'edit', 'create');
Route::get('posts/data', [PostController::class, 'posts_data'])->name('posts.data');
Route::resource('posts', PostController::class);
Route::resource('comments', PostCategoryController::class)->except('show', 'edit', 'create');

Route::get('users/data', [UserController::class, 'user_data'])->name('users.data');
Route::resource('users', UserController::class)->except('show');

Route::get('roles/data', [RoleController::class, 'roles_data'])->name('roles.data');
Route::resource('roles', RoleController::class)->except('show', 'edit', 'create');

Route::get('permissions/data', [PermissionController::class, 'permissions_data'])->name('permissions.data');
Route::resource('permissions', PermissionController::class)->except('show', 'edit', 'create');

Route::put('access/update/{role}', [AccessController::class, 'update'])->name('access.update');
Route::get('access', [AccessController::class, 'index'])->name('access.index');
Route::post('access/role/{role}', [AccessController::class, 'getAccessByRole'])->name('access.role');

Route::post('editor/upload', [UploadController::class, 'upload'])->name('editor_upload');
Route::delete('editor/delete', [UploadController::class, 'delete'])->name('editor_delete');
Route::get('editor/list', [UploadController::class, 'list'])->name('editor_image_manager');

Route::delete('temp-upload', [UploadController::class, 'temp_delete'])->name('temp_upload_delete');
Route::post('temp-upload', [UploadController::class, 'temp_upload'])->name('temp_upload');
Route::get('temp-upload', [UploadController::class, 'getUploaded'])->name('get_image_edit_post');

Route::get('/crud/data', [CrudController::class, 'crud_data'])->name('crud.data');
Route::post('/crud/get_validations_data', [CrudController::class, 'get_validations_data'])->name('crud.get_validations_data');
Route::get('/crud/table-columns/{table}', [CrudController::class, 'getTableColumns'])->name('crud.table-columns');
Route::resource('/crud', CrudController::class);

Route::get('activity-logs', [App\Http\Controllers\Core\ActivityLogController::class, 'index'])->name('activity-logs.index');

// System Health
Route::get('system-health', [App\Http\Controllers\Core\SystemHealthController::class, 'index'])->name('system-health.index');

// Backup
Route::prefix('backup')->name('backup.')->group(function () {
    Route::get('/', [App\Http\Controllers\Core\BackupController::class, 'index'])->name('index');
    Route::post('/database', [App\Http\Controllers\Core\BackupController::class, 'createDatabase'])->name('database');
    Route::post('/files', [App\Http\Controllers\Core\BackupController::class, 'createFiles'])->name('files');
    Route::get('/download/{filename}', [App\Http\Controllers\Core\BackupController::class, 'download'])->name('download');
    Route::delete('/{filename}', [App\Http\Controllers\Core\BackupController::class, 'destroy'])->name('destroy');
});

// Notifications
Route::get('notifications', [App\Http\Controllers\Core\NotificationController::class, 'index'])->name('notifications.index');
Route::post('notifications/load-more', [App\Http\Controllers\Core\NotificationController::class, 'loadMore'])->name('notifications.load-more');
Route::post('notifications/mark-all-read', [App\Http\Controllers\Core\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
Route::patch('notifications/{id}/read', [App\Http\Controllers\Core\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
Route::delete('notifications/{id}', [App\Http\Controllers\Core\NotificationController::class, 'destroy'])->name('notifications.destroy');

// Settings Routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    Route::get('application', [SettingsController::class, 'application'])->name('application');
    Route::put('application', [SettingsController::class, 'updateApplication'])->name('application.update');
    Route::get('theme', [SettingsController::class, 'theme'])->name('theme');
    Route::put('theme', [SettingsController::class, 'updateTheme'])->name('theme.update');
    Route::put('email', [SettingsController::class, 'updateEmail'])->name('email.update');
    Route::post('email/test', [SettingsController::class, 'testEmail'])->name('email.test');
    Route::post('upload-logo', [SettingsController::class, 'uploadLogo'])->name('upload-logo');
    Route::delete('remove-logo', [SettingsController::class, 'removeLogo'])->name('remove-logo');
    Route::post('theme/reset', [SettingsController::class, 'resetTheme'])->name('theme.reset');
    Route::put('license', [SettingsController::class, 'updateLicense'])->name('license.update');
});

// API Token Routes
Route::prefix('api-tokens')->name('api-tokens.')->group(function () {
    Route::get('/', [App\Http\Controllers\Core\ApiTokenController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\Core\ApiTokenController::class, 'store'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\Core\ApiTokenController::class, 'destroy'])->name('destroy');
});

// Profile
Route::get('users/export', [App\Http\Controllers\Core\UserController::class, 'export'])->name('users.export');
Route::post('users/bulk-destroy', [App\Http\Controllers\Core\UserController::class, 'bulkDestroy'])->name('users.bulk_destroy');
Route::post('users/{user}/ban', [App\Http\Controllers\Core\UserController::class, 'toggleBan'])->name('users.ban');
Route::get('profile', [App\Http\Controllers\Core\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/update', [App\Http\Controllers\Core\ProfileController::class, 'update'])->name('profile.update');
Route::put('profile/password', [App\Http\Controllers\Core\ProfileController::class, 'updatePassword'])->name('profile.password');

// Media
Route::resource('media', App\Http\Controllers\Core\MediaController::class)->only(['index', 'store', 'destroy']);

// Two Factor Authentication
Route::post('two-factor-authentication', [App\Http\Controllers\Core\TwoFactorController::class, 'enable'])->name('two-factor.enable');
Route::post('two-factor-authentication/confirm', [App\Http\Controllers\Core\TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
Route::delete('two-factor-authentication', [App\Http\Controllers\Core\TwoFactorController::class, 'disable'])->name('two-factor.disable');
Route::post('two-factor-authentication/recovery-codes', [App\Http\Controllers\Core\TwoFactorController::class, 'recoveryCodes'])->name('two-factor.recovery-codes');
Route::post('two-factor-authentication/regenerate-recovery-codes', [App\Http\Controllers\Core\TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.regenerate-recovery-codes');
