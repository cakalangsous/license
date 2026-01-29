import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
export const environment = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environment.url(options),
    method: 'get',
})

environment.definition = {
    methods: ["get","head"],
    url: '/install/environment',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.url = (options?: RouteQueryOptions) => {
    return environment.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environment.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: environment.url(options),
    method: 'head',
})
const EnvironmentController = { environment }

export default EnvironmentController