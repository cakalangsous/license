import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import products from './products'
import licenses from './licenses'
import activations from './activations'
import marketplaces from './marketplaces'
import sales from './sales'
import verificationLogs from './verification-logs'
import blacklistedDomains from './blacklisted-domains'
import sidebarMenus from './sidebar-menus'
import post_categories from './post_categories'
import tags from './tags'
import posts from './posts'
import comments from './comments'
import users from './users'
import roles from './roles'
import permissions from './permissions'
import access from './access'
import crud from './crud'
import activityLogs from './activity-logs'
import systemHealth from './system-health'
import backup from './backup'
import notifications from './notifications'
import settings from './settings'
import apiTokens from './api-tokens'
import profile from './profile'
import media from './media'
import twoFactor from './two-factor'
/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:17
 * @route '/admin/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/admin/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:17
 * @route '/admin/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:17
 * @route '/admin/login'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:17
 * @route '/admin/login'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:51
 * @route '/admin/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/admin/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:51
 * @route '/admin/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Core/Auth/AuthenticatedSessionController.php:51
 * @route '/admin/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\DashboardController::dashboard
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\DashboardController::dashboard
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\DashboardController::dashboard
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\DashboardController::dashboard
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UploadController::editor_upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
export const editor_upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: editor_upload.url(options),
    method: 'post',
})

editor_upload.definition = {
    methods: ["post"],
    url: '/admin/editor/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UploadController::editor_upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
editor_upload.url = (options?: RouteQueryOptions) => {
    return editor_upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::editor_upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
editor_upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: editor_upload.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UploadController::editor_delete
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
export const editor_delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: editor_delete.url(options),
    method: 'delete',
})

editor_delete.definition = {
    methods: ["delete"],
    url: '/admin/editor/delete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\UploadController::editor_delete
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
editor_delete.url = (options?: RouteQueryOptions) => {
    return editor_delete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::editor_delete
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
editor_delete.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: editor_delete.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\UploadController::editor_image_manager
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
export const editor_image_manager = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editor_image_manager.url(options),
    method: 'get',
})

editor_image_manager.definition = {
    methods: ["get","head"],
    url: '/admin/editor/list',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UploadController::editor_image_manager
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
editor_image_manager.url = (options?: RouteQueryOptions) => {
    return editor_image_manager.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::editor_image_manager
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
editor_image_manager.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editor_image_manager.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UploadController::editor_image_manager
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
editor_image_manager.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editor_image_manager.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
export const temp_upload_delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: temp_upload_delete.url(options),
    method: 'delete',
})

temp_upload_delete.definition = {
    methods: ["delete"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
temp_upload_delete.url = (options?: RouteQueryOptions) => {
    return temp_upload_delete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
temp_upload_delete.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: temp_upload_delete.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
export const temp_upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: temp_upload.url(options),
    method: 'post',
})

temp_upload.definition = {
    methods: ["post"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
temp_upload.url = (options?: RouteQueryOptions) => {
    return temp_upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
temp_upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: temp_upload.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UploadController::get_image_edit_post
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
export const get_image_edit_post = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get_image_edit_post.url(options),
    method: 'get',
})

get_image_edit_post.definition = {
    methods: ["get","head"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UploadController::get_image_edit_post
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
get_image_edit_post.url = (options?: RouteQueryOptions) => {
    return get_image_edit_post.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::get_image_edit_post
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
get_image_edit_post.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get_image_edit_post.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UploadController::get_image_edit_post
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
get_image_edit_post.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: get_image_edit_post.url(options),
    method: 'head',
})
const admin = {
    login: Object.assign(login, login),
logout: Object.assign(logout, logout),
products: Object.assign(products, products),
licenses: Object.assign(licenses, licenses),
activations: Object.assign(activations, activations),
marketplaces: Object.assign(marketplaces, marketplaces),
sales: Object.assign(sales, sales),
verificationLogs: Object.assign(verificationLogs, verificationLogs),
blacklistedDomains: Object.assign(blacklistedDomains, blacklistedDomains),
sidebarMenus: Object.assign(sidebarMenus, sidebarMenus),
dashboard: Object.assign(dashboard, dashboard),
post_categories: Object.assign(post_categories, post_categories),
tags: Object.assign(tags, tags),
posts: Object.assign(posts, posts),
comments: Object.assign(comments, comments),
users: Object.assign(users, users),
roles: Object.assign(roles, roles),
permissions: Object.assign(permissions, permissions),
access: Object.assign(access, access),
editor_upload: Object.assign(editor_upload, editor_upload),
editor_delete: Object.assign(editor_delete, editor_delete),
editor_image_manager: Object.assign(editor_image_manager, editor_image_manager),
temp_upload_delete: Object.assign(temp_upload_delete, temp_upload_delete),
temp_upload: Object.assign(temp_upload, temp_upload),
get_image_edit_post: Object.assign(get_image_edit_post, get_image_edit_post),
crud: Object.assign(crud, crud),
activityLogs: Object.assign(activityLogs, activityLogs),
systemHealth: Object.assign(systemHealth, systemHealth),
backup: Object.assign(backup, backup),
notifications: Object.assign(notifications, notifications),
settings: Object.assign(settings, settings),
apiTokens: Object.assign(apiTokens, apiTokens),
profile: Object.assign(profile, profile),
media: Object.assign(media, media),
twoFactor: Object.assign(twoFactor, twoFactor),
}

export default admin