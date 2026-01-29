import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\DashboardController::index
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\DashboardController::index
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\DashboardController::index
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\DashboardController::index
 * @see app/Http/Controllers/Core/DashboardController.php:17
 * @route '/admin/dashboard'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})
const DashboardController = { index }

export default DashboardController