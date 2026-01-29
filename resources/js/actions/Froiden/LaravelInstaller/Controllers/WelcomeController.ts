import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
export const welcome = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

welcome.definition = {
    methods: ["get","head"],
    url: '/install',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.url = (options?: RouteQueryOptions) => {
    return welcome.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: welcome.url(options),
    method: 'head',
})
const WelcomeController = { welcome }

export default WelcomeController