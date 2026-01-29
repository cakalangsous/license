import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/comments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/comments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
export const update = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/comments/{comment}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update.url = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { comment: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    comment: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        comment: args.comment,
                }

    return update.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update.put = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update.patch = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
export const destroy = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/comments/{comment}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
destroy.url = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { comment: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    comment: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        comment: args.comment,
                }

    return destroy.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
destroy.delete = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const comments = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default comments