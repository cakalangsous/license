import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SaleController::index
 * @see app/Http/Controllers/Core/SaleController.php:19
 * @route '/admin/sales'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/sales',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SaleController::index
 * @see app/Http/Controllers/Core/SaleController.php:19
 * @route '/admin/sales'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SaleController::index
 * @see app/Http/Controllers/Core/SaleController.php:19
 * @route '/admin/sales'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SaleController::index
 * @see app/Http/Controllers/Core/SaleController.php:19
 * @route '/admin/sales'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})
const SaleController = { index }

export default SaleController