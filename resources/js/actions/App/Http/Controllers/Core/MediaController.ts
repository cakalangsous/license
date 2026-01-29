import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\MediaController::index
 * @see app/Http/Controllers/Core/MediaController.php:19
 * @route '/admin/media'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/media',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\MediaController::index
 * @see app/Http/Controllers/Core/MediaController.php:19
 * @route '/admin/media'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MediaController::index
 * @see app/Http/Controllers/Core/MediaController.php:19
 * @route '/admin/media'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\MediaController::index
 * @see app/Http/Controllers/Core/MediaController.php:19
 * @route '/admin/media'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\MediaController::store
 * @see app/Http/Controllers/Core/MediaController.php:36
 * @route '/admin/media'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/media',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\MediaController::store
 * @see app/Http/Controllers/Core/MediaController.php:36
 * @route '/admin/media'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MediaController::store
 * @see app/Http/Controllers/Core/MediaController.php:36
 * @route '/admin/media'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\MediaController::destroy
 * @see app/Http/Controllers/Core/MediaController.php:67
 * @route '/admin/media/{medium}'
 */
export const destroy = (args: { medium: string | number } | [medium: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/media/{medium}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\MediaController::destroy
 * @see app/Http/Controllers/Core/MediaController.php:67
 * @route '/admin/media/{medium}'
 */
destroy.url = (args: { medium: string | number } | [medium: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { medium: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    medium: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        medium: args.medium,
                }

    return destroy.definition.url
            .replace('{medium}', parsedArgs.medium.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\MediaController::destroy
 * @see app/Http/Controllers/Core/MediaController.php:67
 * @route '/admin/media/{medium}'
 */
destroy.delete = (args: { medium: string | number } | [medium: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const MediaController = { index, store, destroy }

export default MediaController