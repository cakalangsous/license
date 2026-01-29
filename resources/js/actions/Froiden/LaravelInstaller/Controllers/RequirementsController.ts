import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
export const requirements = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: requirements.url(options),
    method: 'get',
})

requirements.definition = {
    methods: ["get","head"],
    url: '/install/requirements',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.url = (options?: RouteQueryOptions) => {
    return requirements.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: requirements.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: requirements.url(options),
    method: 'head',
})
const RequirementsController = { requirements }

export default RequirementsController