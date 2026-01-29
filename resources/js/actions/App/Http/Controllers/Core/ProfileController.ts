import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\ProfileController::edit
 * @see app/Http/Controllers/Core/ProfileController.php:24
 * @route '/admin/profile'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\ProfileController::edit
 * @see app/Http/Controllers/Core/ProfileController.php:24
 * @route '/admin/profile'
 */
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ProfileController::edit
 * @see app/Http/Controllers/Core/ProfileController.php:24
 * @route '/admin/profile'
 */
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\ProfileController::edit
 * @see app/Http/Controllers/Core/ProfileController.php:24
 * @route '/admin/profile'
 */
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\ProfileController::update
 * @see app/Http/Controllers/Core/ProfileController.php:36
 * @route '/admin/profile/update'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/admin/profile/update',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\ProfileController::update
 * @see app/Http/Controllers/Core/ProfileController.php:36
 * @route '/admin/profile/update'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ProfileController::update
 * @see app/Http/Controllers/Core/ProfileController.php:36
 * @route '/admin/profile/update'
 */
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\ProfileController::updatePassword
 * @see app/Http/Controllers/Core/ProfileController.php:48
 * @route '/admin/profile/password'
 */
export const updatePassword = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})

updatePassword.definition = {
    methods: ["put"],
    url: '/admin/profile/password',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\ProfileController::updatePassword
 * @see app/Http/Controllers/Core/ProfileController.php:48
 * @route '/admin/profile/password'
 */
updatePassword.url = (options?: RouteQueryOptions) => {
    return updatePassword.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ProfileController::updatePassword
 * @see app/Http/Controllers/Core/ProfileController.php:48
 * @route '/admin/profile/password'
 */
updatePassword.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})
const ProfileController = { edit, update, updatePassword }

export default ProfileController