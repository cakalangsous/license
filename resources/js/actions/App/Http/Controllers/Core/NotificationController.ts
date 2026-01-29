import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\NotificationController::index
 * @see app/Http/Controllers/Core/NotificationController.php:11
 * @route '/admin/notifications'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/notifications',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::index
 * @see app/Http/Controllers/Core/NotificationController.php:11
 * @route '/admin/notifications'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::index
 * @see app/Http/Controllers/Core/NotificationController.php:11
 * @route '/admin/notifications'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\NotificationController::index
 * @see app/Http/Controllers/Core/NotificationController.php:11
 * @route '/admin/notifications'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\NotificationController::loadMore
 * @see app/Http/Controllers/Core/NotificationController.php:20
 * @route '/admin/notifications/load-more'
 */
export const loadMore = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: loadMore.url(options),
    method: 'post',
})

loadMore.definition = {
    methods: ["post"],
    url: '/admin/notifications/load-more',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::loadMore
 * @see app/Http/Controllers/Core/NotificationController.php:20
 * @route '/admin/notifications/load-more'
 */
loadMore.url = (options?: RouteQueryOptions) => {
    return loadMore.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::loadMore
 * @see app/Http/Controllers/Core/NotificationController.php:20
 * @route '/admin/notifications/load-more'
 */
loadMore.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: loadMore.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\NotificationController::markAllAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
export const markAllAsRead = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markAllAsRead.url(options),
    method: 'post',
})

markAllAsRead.definition = {
    methods: ["post"],
    url: '/admin/notifications/mark-all-read',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::markAllAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
markAllAsRead.url = (options?: RouteQueryOptions) => {
    return markAllAsRead.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::markAllAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
markAllAsRead.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markAllAsRead.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\NotificationController::markAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
export const markAsRead = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: markAsRead.url(args, options),
    method: 'patch',
})

markAsRead.definition = {
    methods: ["patch"],
    url: '/admin/notifications/{id}/read',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::markAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
markAsRead.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return markAsRead.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::markAsRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
markAsRead.patch = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: markAsRead.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\NotificationController::destroy
 * @see app/Http/Controllers/Core/NotificationController.php:49
 * @route '/admin/notifications/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/notifications/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::destroy
 * @see app/Http/Controllers/Core/NotificationController.php:49
 * @route '/admin/notifications/{id}'
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
* @see \App\Http\Controllers\Core\NotificationController::destroy
 * @see app/Http/Controllers/Core/NotificationController.php:49
 * @route '/admin/notifications/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const NotificationController = { index, loadMore, markAllAsRead, markAsRead, destroy }

export default NotificationController