import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
export const permissions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})

permissions.definition = {
    methods: ["get","head"],
    url: '/install/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.url = (options?: RouteQueryOptions) => {
    return permissions.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: permissions.url(options),
    method: 'head',
})
const PermissionsController = { permissions }

export default PermissionsController