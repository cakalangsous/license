import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\ApiTokenController::index
 * @see app/Http/Controllers/Core/ApiTokenController.php:22
 * @route '/admin/api-tokens'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/api-tokens',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\ApiTokenController::index
 * @see app/Http/Controllers/Core/ApiTokenController.php:22
 * @route '/admin/api-tokens'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ApiTokenController::index
 * @see app/Http/Controllers/Core/ApiTokenController.php:22
 * @route '/admin/api-tokens'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\ApiTokenController::index
 * @see app/Http/Controllers/Core/ApiTokenController.php:22
 * @route '/admin/api-tokens'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\ApiTokenController::store
 * @see app/Http/Controllers/Core/ApiTokenController.php:29
 * @route '/admin/api-tokens'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/api-tokens',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\ApiTokenController::store
 * @see app/Http/Controllers/Core/ApiTokenController.php:29
 * @route '/admin/api-tokens'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ApiTokenController::store
 * @see app/Http/Controllers/Core/ApiTokenController.php:29
 * @route '/admin/api-tokens'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\ApiTokenController::destroy
 * @see app/Http/Controllers/Core/ApiTokenController.php:41
 * @route '/admin/api-tokens/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/api-tokens/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\ApiTokenController::destroy
 * @see app/Http/Controllers/Core/ApiTokenController.php:41
 * @route '/admin/api-tokens/{id}'
 */
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ApiTokenController::destroy
 * @see app/Http/Controllers/Core/ApiTokenController.php:41
 * @route '/admin/api-tokens/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const apiTokens = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default apiTokens