import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import application73b395 from './application'
import themeD71bd4 from './theme'
import email from './email'
/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:32
 * @route '/admin/settings'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:32
 * @route '/admin/settings'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:32
 * @route '/admin/settings'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:32
 * @route '/admin/settings'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:49
 * @route '/admin/settings/application'
 */
export const application = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: application.url(options),
    method: 'get',
})

application.definition = {
    methods: ["get","head"],
    url: '/admin/settings/application',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:49
 * @route '/admin/settings/application'
 */
application.url = (options?: RouteQueryOptions) => {
    return application.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:49
 * @route '/admin/settings/application'
 */
application.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: application.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:49
 * @route '/admin/settings/application'
 */
application.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: application.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:69
 * @route '/admin/settings/theme'
 */
export const theme = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: theme.url(options),
    method: 'get',
})

theme.definition = {
    methods: ["get","head"],
    url: '/admin/settings/theme',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:69
 * @route '/admin/settings/theme'
 */
theme.url = (options?: RouteQueryOptions) => {
    return theme.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:69
 * @route '/admin/settings/theme'
 */
theme.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: theme.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:69
 * @route '/admin/settings/theme'
 */
theme.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: theme.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:110
 * @route '/admin/settings/upload-logo'
 */
export const uploadLogo = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadLogo.url(options),
    method: 'post',
})

uploadLogo.definition = {
    methods: ["post"],
    url: '/admin/settings/upload-logo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:110
 * @route '/admin/settings/upload-logo'
 */
uploadLogo.url = (options?: RouteQueryOptions) => {
    return uploadLogo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:110
 * @route '/admin/settings/upload-logo'
 */
uploadLogo.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadLogo.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:127
 * @route '/admin/settings/remove-logo'
 */
export const removeLogo = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: removeLogo.url(options),
    method: 'delete',
})

removeLogo.definition = {
    methods: ["delete"],
    url: '/admin/settings/remove-logo',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:127
 * @route '/admin/settings/remove-logo'
 */
removeLogo.url = (options?: RouteQueryOptions) => {
    return removeLogo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:127
 * @route '/admin/settings/remove-logo'
 */
removeLogo.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: removeLogo.url(options),
    method: 'delete',
})
const settings = {
    index: Object.assign(index, index),
application: Object.assign(application, application73b395),
theme: Object.assign(theme, themeD71bd4),
email: Object.assign(email, email),
uploadLogo: Object.assign(uploadLogo, uploadLogo),
removeLogo: Object.assign(removeLogo, removeLogo),
}

export default settings