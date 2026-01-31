import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\MarketplaceController::index
 * @see app/Http/Controllers/Core/MarketplaceController.php:24
 * @route '/admin/marketplaces'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/marketplaces',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\MarketplaceController::index
 * @see app/Http/Controllers/Core/MarketplaceController.php:24
 * @route '/admin/marketplaces'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MarketplaceController::index
 * @see app/Http/Controllers/Core/MarketplaceController.php:24
 * @route '/admin/marketplaces'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\MarketplaceController::index
 * @see app/Http/Controllers/Core/MarketplaceController.php:24
 * @route '/admin/marketplaces'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\MarketplaceController::store
 * @see app/Http/Controllers/Core/MarketplaceController.php:33
 * @route '/admin/marketplaces'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/marketplaces',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\MarketplaceController::store
 * @see app/Http/Controllers/Core/MarketplaceController.php:33
 * @route '/admin/marketplaces'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MarketplaceController::store
 * @see app/Http/Controllers/Core/MarketplaceController.php:33
 * @route '/admin/marketplaces'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\MarketplaceController::update
 * @see app/Http/Controllers/Core/MarketplaceController.php:50
 * @route '/admin/marketplaces/{marketplace}'
 */
export const update = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/marketplaces/{marketplace}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\MarketplaceController::update
 * @see app/Http/Controllers/Core/MarketplaceController.php:50
 * @route '/admin/marketplaces/{marketplace}'
 */
update.url = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { marketplace: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { marketplace: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    marketplace: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        marketplace: typeof args.marketplace === 'object'
                ? args.marketplace.id
                : args.marketplace,
                }

    return update.definition.url
            .replace('{marketplace}', parsedArgs.marketplace.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MarketplaceController::update
 * @see app/Http/Controllers/Core/MarketplaceController.php:50
 * @route '/admin/marketplaces/{marketplace}'
 */
update.put = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\MarketplaceController::destroy
 * @see app/Http/Controllers/Core/MarketplaceController.php:67
 * @route '/admin/marketplaces/{marketplace}'
 */
export const destroy = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/marketplaces/{marketplace}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\MarketplaceController::destroy
 * @see app/Http/Controllers/Core/MarketplaceController.php:67
 * @route '/admin/marketplaces/{marketplace}'
 */
destroy.url = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { marketplace: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { marketplace: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    marketplace: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        marketplace: typeof args.marketplace === 'object'
                ? args.marketplace.id
                : args.marketplace,
                }

    return destroy.definition.url
            .replace('{marketplace}', parsedArgs.marketplace.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MarketplaceController::destroy
 * @see app/Http/Controllers/Core/MarketplaceController.php:67
 * @route '/admin/marketplaces/{marketplace}'
 */
destroy.delete = (args: { marketplace: number | { id: number } } | [marketplace: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const MarketplaceController = { index, store, update, destroy }

export default MarketplaceController