import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\PostCategoryController::data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
export const data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: data.url(options),
    method: 'get',
})

data.definition = {
    methods: ["get","head"],
    url: '/admin/post_categories/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
data.url = (options?: RouteQueryOptions) => {
    return data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/post_categories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/post_categories',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
export const update = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/post_categories/{post_category}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
update.url = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post_category: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    post_category: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post_category: args.post_category,
                }

    return update.definition.url
            .replace('{post_category}', parsedArgs.post_category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
update.put = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
update.patch = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
export const destroy = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/post_categories/{post_category}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
destroy.url = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post_category: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    post_category: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post_category: args.post_category,
                }

    return destroy.definition.url
            .replace('{post_category}', parsedArgs.post_category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
destroy.delete = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const post_categories = {
    data: Object.assign(data, data),
index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default post_categories