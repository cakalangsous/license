import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\TagController::tags_data
 * @see app/Http/Controllers/Core/TagController.php:0
 * @route '/admin/tags/data'
 */
export const tags_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tags_data.url(options),
    method: 'get',
})

tags_data.definition = {
    methods: ["get","head"],
    url: '/admin/tags/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\TagController::tags_data
 * @see app/Http/Controllers/Core/TagController.php:0
 * @route '/admin/tags/data'
 */
tags_data.url = (options?: RouteQueryOptions) => {
    return tags_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TagController::tags_data
 * @see app/Http/Controllers/Core/TagController.php:0
 * @route '/admin/tags/data'
 */
tags_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tags_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\TagController::tags_data
 * @see app/Http/Controllers/Core/TagController.php:0
 * @route '/admin/tags/data'
 */
tags_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: tags_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\TagController::index
 * @see app/Http/Controllers/Core/TagController.php:28
 * @route '/admin/tags'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/tags',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\TagController::index
 * @see app/Http/Controllers/Core/TagController.php:28
 * @route '/admin/tags'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TagController::index
 * @see app/Http/Controllers/Core/TagController.php:28
 * @route '/admin/tags'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\TagController::index
 * @see app/Http/Controllers/Core/TagController.php:28
 * @route '/admin/tags'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\TagController::store
 * @see app/Http/Controllers/Core/TagController.php:40
 * @route '/admin/tags'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/tags',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\TagController::store
 * @see app/Http/Controllers/Core/TagController.php:40
 * @route '/admin/tags'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TagController::store
 * @see app/Http/Controllers/Core/TagController.php:40
 * @route '/admin/tags'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\TagController::update
 * @see app/Http/Controllers/Core/TagController.php:51
 * @route '/admin/tags/{tag}'
 */
export const update = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/tags/{tag}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\TagController::update
 * @see app/Http/Controllers/Core/TagController.php:51
 * @route '/admin/tags/{tag}'
 */
update.url = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { tag: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { tag: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    tag: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        tag: typeof args.tag === 'object'
                ? args.tag.id
                : args.tag,
                }

    return update.definition.url
            .replace('{tag}', parsedArgs.tag.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TagController::update
 * @see app/Http/Controllers/Core/TagController.php:51
 * @route '/admin/tags/{tag}'
 */
update.put = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\TagController::update
 * @see app/Http/Controllers/Core/TagController.php:51
 * @route '/admin/tags/{tag}'
 */
update.patch = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\TagController::destroy
 * @see app/Http/Controllers/Core/TagController.php:62
 * @route '/admin/tags/{tag}'
 */
export const destroy = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/tags/{tag}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\TagController::destroy
 * @see app/Http/Controllers/Core/TagController.php:62
 * @route '/admin/tags/{tag}'
 */
destroy.url = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { tag: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { tag: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    tag: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        tag: typeof args.tag === 'object'
                ? args.tag.id
                : args.tag,
                }

    return destroy.definition.url
            .replace('{tag}', parsedArgs.tag.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TagController::destroy
 * @see app/Http/Controllers/Core/TagController.php:62
 * @route '/admin/tags/{tag}'
 */
destroy.delete = (args: { tag: number | { id: number } } | [tag: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const TagController = { tags_data, index, store, update, destroy }

export default TagController