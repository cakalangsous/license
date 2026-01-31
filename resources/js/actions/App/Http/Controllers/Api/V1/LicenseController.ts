import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\V1\LicenseController::verify
 * @see app/Http/Controllers/Api/V1/LicenseController.php:22
 * @route '/api/v1/license/verify'
 */
export const verify = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: verify.url(options),
    method: 'post',
})

verify.definition = {
    methods: ["post"],
    url: '/api/v1/license/verify',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\V1\LicenseController::verify
 * @see app/Http/Controllers/Api/V1/LicenseController.php:22
 * @route '/api/v1/license/verify'
 */
verify.url = (options?: RouteQueryOptions) => {
    return verify.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\V1\LicenseController::verify
 * @see app/Http/Controllers/Api/V1/LicenseController.php:22
 * @route '/api/v1/license/verify'
 */
verify.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: verify.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\V1\LicenseController::status
 * @see app/Http/Controllers/Api/V1/LicenseController.php:48
 * @route '/api/v1/license/status'
 */
export const status = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: status.url(options),
    method: 'post',
})

status.definition = {
    methods: ["post"],
    url: '/api/v1/license/status',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\V1\LicenseController::status
 * @see app/Http/Controllers/Api/V1/LicenseController.php:48
 * @route '/api/v1/license/status'
 */
status.url = (options?: RouteQueryOptions) => {
    return status.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\V1\LicenseController::status
 * @see app/Http/Controllers/Api/V1/LicenseController.php:48
 * @route '/api/v1/license/status'
 */
status.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: status.url(options),
    method: 'post',
})
const LicenseController = { verify, status }

export default LicenseController