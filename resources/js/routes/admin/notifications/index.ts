import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
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
* @see \App\Http\Controllers\Core\NotificationController::markAllRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
export const markAllRead = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markAllRead.url(options),
    method: 'post',
})

markAllRead.definition = {
    methods: ["post"],
    url: '/admin/notifications/mark-all-read',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::markAllRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
markAllRead.url = (options?: RouteQueryOptions) => {
    return markAllRead.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::markAllRead
 * @see app/Http/Controllers/Core/NotificationController.php:42
 * @route '/admin/notifications/mark-all-read'
 */
markAllRead.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markAllRead.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\NotificationController::markRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
export const markRead = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: markRead.url(args, options),
    method: 'patch',
})

markRead.definition = {
    methods: ["patch"],
    url: '/admin/notifications/{id}/read',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Core\NotificationController::markRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
markRead.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return markRead.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\NotificationController::markRead
 * @see app/Http/Controllers/Core/NotificationController.php:31
 * @route '/admin/notifications/{id}/read'
 */
markRead.patch = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: markRead.url(args, options),
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
const notifications = {
    index: Object.assign(index, index),
loadMore: Object.assign(loadMore, loadMore),
markAllRead: Object.assign(markAllRead, markAllRead),
markRead: Object.assign(markRead, markRead),
destroy: Object.assign(destroy, destroy),
}

export default notifications