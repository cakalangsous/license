import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\V1\ActivationController::activate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:22
 * @route '/api/v1/license/activate'
 */
export const activate = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: activate.url(options),
    method: 'post',
})

activate.definition = {
    methods: ["post"],
    url: '/api/v1/license/activate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\V1\ActivationController::activate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:22
 * @route '/api/v1/license/activate'
 */
activate.url = (options?: RouteQueryOptions) => {
    return activate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\V1\ActivationController::activate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:22
 * @route '/api/v1/license/activate'
 */
activate.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: activate.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\V1\ActivationController::deactivate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:66
 * @route '/api/v1/license/deactivate'
 */
export const deactivate = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(options),
    method: 'post',
})

deactivate.definition = {
    methods: ["post"],
    url: '/api/v1/license/deactivate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\V1\ActivationController::deactivate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:66
 * @route '/api/v1/license/deactivate'
 */
deactivate.url = (options?: RouteQueryOptions) => {
    return deactivate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\V1\ActivationController::deactivate
 * @see app/Http/Controllers/Api/V1/ActivationController.php:66
 * @route '/api/v1/license/deactivate'
 */
deactivate.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(options),
    method: 'post',
})
const ActivationController = { activate, deactivate }

export default ActivationController