import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\PostController::posts_data
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/data'
 */
export const posts_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: posts_data.url(options),
    method: 'get',
})

posts_data.definition = {
    methods: ["get","head"],
    url: '/admin/posts/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostController::posts_data
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/data'
 */
posts_data.url = (options?: RouteQueryOptions) => {
    return posts_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::posts_data
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/data'
 */
posts_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: posts_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostController::posts_data
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/data'
 */
posts_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: posts_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostController::index
 * @see app/Http/Controllers/Core/PostController.php:28
 * @route '/admin/posts'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/posts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostController::index
 * @see app/Http/Controllers/Core/PostController.php:28
 * @route '/admin/posts'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::index
 * @see app/Http/Controllers/Core/PostController.php:28
 * @route '/admin/posts'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostController::index
 * @see app/Http/Controllers/Core/PostController.php:28
 * @route '/admin/posts'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostController::create
 * @see app/Http/Controllers/Core/PostController.php:40
 * @route '/admin/posts/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/posts/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostController::create
 * @see app/Http/Controllers/Core/PostController.php:40
 * @route '/admin/posts/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::create
 * @see app/Http/Controllers/Core/PostController.php:40
 * @route '/admin/posts/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostController::create
 * @see app/Http/Controllers/Core/PostController.php:40
 * @route '/admin/posts/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostController::store
 * @see app/Http/Controllers/Core/PostController.php:55
 * @route '/admin/posts'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/posts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PostController::store
 * @see app/Http/Controllers/Core/PostController.php:55
 * @route '/admin/posts'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::store
 * @see app/Http/Controllers/Core/PostController.php:55
 * @route '/admin/posts'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\PostController::show
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/{post}'
 */
export const show = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/posts/{post}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostController::show
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/{post}'
 */
show.url = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    post: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post: args.post,
                }

    return show.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::show
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/{post}'
 */
show.get = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostController::show
 * @see app/Http/Controllers/Core/PostController.php:0
 * @route '/admin/posts/{post}'
 */
show.head = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostController::edit
 * @see app/Http/Controllers/Core/PostController.php:68
 * @route '/admin/posts/{post}/edit'
 */
export const edit = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/posts/{post}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostController::edit
 * @see app/Http/Controllers/Core/PostController.php:68
 * @route '/admin/posts/{post}/edit'
 */
edit.url = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { post: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    post: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post: typeof args.post === 'object'
                ? args.post.id
                : args.post,
                }

    return edit.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::edit
 * @see app/Http/Controllers/Core/PostController.php:68
 * @route '/admin/posts/{post}/edit'
 */
edit.get = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostController::edit
 * @see app/Http/Controllers/Core/PostController.php:68
 * @route '/admin/posts/{post}/edit'
 */
edit.head = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostController::update
 * @see app/Http/Controllers/Core/PostController.php:88
 * @route '/admin/posts/{post}'
 */
export const update = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/posts/{post}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PostController::update
 * @see app/Http/Controllers/Core/PostController.php:88
 * @route '/admin/posts/{post}'
 */
update.url = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { post: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    post: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post: typeof args.post === 'object'
                ? args.post.id
                : args.post,
                }

    return update.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::update
 * @see app/Http/Controllers/Core/PostController.php:88
 * @route '/admin/posts/{post}'
 */
update.put = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PostController::update
 * @see app/Http/Controllers/Core/PostController.php:88
 * @route '/admin/posts/{post}'
 */
update.patch = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\PostController::destroy
 * @see app/Http/Controllers/Core/PostController.php:99
 * @route '/admin/posts/{post}'
 */
export const destroy = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/posts/{post}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PostController::destroy
 * @see app/Http/Controllers/Core/PostController.php:99
 * @route '/admin/posts/{post}'
 */
destroy.url = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { post: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    post: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post: typeof args.post === 'object'
                ? args.post.id
                : args.post,
                }

    return destroy.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostController::destroy
 * @see app/Http/Controllers/Core/PostController.php:99
 * @route '/admin/posts/{post}'
 */
destroy.delete = (args: { post: string | number | { id: string | number } } | [post: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const PostController = { posts_data, index, create, store, show, edit, update, destroy }

export default PostController