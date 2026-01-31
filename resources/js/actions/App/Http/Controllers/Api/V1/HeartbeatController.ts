import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\V1\HeartbeatController::__invoke
 * @see app/Http/Controllers/Api/V1/HeartbeatController.php:22
 * @route '/api/v1/license/heartbeat'
 */
const HeartbeatController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: HeartbeatController.url(options),
    method: 'post',
})

HeartbeatController.definition = {
    methods: ["post"],
    url: '/api/v1/license/heartbeat',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\V1\HeartbeatController::__invoke
 * @see app/Http/Controllers/Api/V1/HeartbeatController.php:22
 * @route '/api/v1/license/heartbeat'
 */
HeartbeatController.url = (options?: RouteQueryOptions) => {
    return HeartbeatController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\V1\HeartbeatController::__invoke
 * @see app/Http/Controllers/Api/V1/HeartbeatController.php:22
 * @route '/api/v1/license/heartbeat'
 */
HeartbeatController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: HeartbeatController.url(options),
    method: 'post',
})
export default HeartbeatController