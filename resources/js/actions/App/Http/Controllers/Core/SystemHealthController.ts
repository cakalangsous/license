import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SystemHealthController::index
 * @see app/Http/Controllers/Core/SystemHealthController.php:21
 * @route '/admin/system-health'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/system-health',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SystemHealthController::index
 * @see app/Http/Controllers/Core/SystemHealthController.php:21
 * @route '/admin/system-health'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SystemHealthController::index
 * @see app/Http/Controllers/Core/SystemHealthController.php:21
 * @route '/admin/system-health'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SystemHealthController::index
 * @see app/Http/Controllers/Core/SystemHealthController.php:21
 * @route '/admin/system-health'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})
const SystemHealthController = { index }

export default SystemHealthController