import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\PostCategoryController::post_categories_data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
export const post_categories_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: post_categories_data.url(options),
    method: 'get',
})

post_categories_data.definition = {
    methods: ["get","head"],
    url: '/admin/post_categories/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::post_categories_data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
post_categories_data.url = (options?: RouteQueryOptions) => {
    return post_categories_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::post_categories_data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
post_categories_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: post_categories_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::post_categories_data
 * @see app/Http/Controllers/Core/PostCategoryController.php:0
 * @route '/admin/post_categories/data'
 */
post_categories_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: post_categories_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
const index3d6555e57eec08002dc6f02ea0e84beb = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index3d6555e57eec08002dc6f02ea0e84beb.url(options),
    method: 'get',
})

index3d6555e57eec08002dc6f02ea0e84beb.definition = {
    methods: ["get","head"],
    url: '/admin/post_categories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index3d6555e57eec08002dc6f02ea0e84beb.url = (options?: RouteQueryOptions) => {
    return index3d6555e57eec08002dc6f02ea0e84beb.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index3d6555e57eec08002dc6f02ea0e84beb.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index3d6555e57eec08002dc6f02ea0e84beb.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/post_categories'
 */
index3d6555e57eec08002dc6f02ea0e84beb.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index3d6555e57eec08002dc6f02ea0e84beb.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
const index9c19d333e2bf1dfbde700fbb7cda5206 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index9c19d333e2bf1dfbde700fbb7cda5206.url(options),
    method: 'get',
})

index9c19d333e2bf1dfbde700fbb7cda5206.definition = {
    methods: ["get","head"],
    url: '/admin/comments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index9c19d333e2bf1dfbde700fbb7cda5206.url = (options?: RouteQueryOptions) => {
    return index9c19d333e2bf1dfbde700fbb7cda5206.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index9c19d333e2bf1dfbde700fbb7cda5206.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index9c19d333e2bf1dfbde700fbb7cda5206.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::index
 * @see app/Http/Controllers/Core/PostCategoryController.php:28
 * @route '/admin/comments'
 */
index9c19d333e2bf1dfbde700fbb7cda5206.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index9c19d333e2bf1dfbde700fbb7cda5206.url(options),
    method: 'head',
})

export const index = {
    '/admin/post_categories': index3d6555e57eec08002dc6f02ea0e84beb,
    '/admin/comments': index9c19d333e2bf1dfbde700fbb7cda5206,
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
const store3d6555e57eec08002dc6f02ea0e84beb = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store3d6555e57eec08002dc6f02ea0e84beb.url(options),
    method: 'post',
})

store3d6555e57eec08002dc6f02ea0e84beb.definition = {
    methods: ["post"],
    url: '/admin/post_categories',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
store3d6555e57eec08002dc6f02ea0e84beb.url = (options?: RouteQueryOptions) => {
    return store3d6555e57eec08002dc6f02ea0e84beb.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/post_categories'
 */
store3d6555e57eec08002dc6f02ea0e84beb.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store3d6555e57eec08002dc6f02ea0e84beb.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
const store9c19d333e2bf1dfbde700fbb7cda5206 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store9c19d333e2bf1dfbde700fbb7cda5206.url(options),
    method: 'post',
})

store9c19d333e2bf1dfbde700fbb7cda5206.definition = {
    methods: ["post"],
    url: '/admin/comments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
store9c19d333e2bf1dfbde700fbb7cda5206.url = (options?: RouteQueryOptions) => {
    return store9c19d333e2bf1dfbde700fbb7cda5206.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::store
 * @see app/Http/Controllers/Core/PostCategoryController.php:40
 * @route '/admin/comments'
 */
store9c19d333e2bf1dfbde700fbb7cda5206.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store9c19d333e2bf1dfbde700fbb7cda5206.url(options),
    method: 'post',
})

export const store = {
    '/admin/post_categories': store3d6555e57eec08002dc6f02ea0e84beb,
    '/admin/comments': store9c19d333e2bf1dfbde700fbb7cda5206,
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
const updatec110ea4fb1dbe5492dfc54e744af0aee = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatec110ea4fb1dbe5492dfc54e744af0aee.url(args, options),
    method: 'put',
})

updatec110ea4fb1dbe5492dfc54e744af0aee.definition = {
    methods: ["put","patch"],
    url: '/admin/post_categories/{post_category}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
updatec110ea4fb1dbe5492dfc54e744af0aee.url = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updatec110ea4fb1dbe5492dfc54e744af0aee.definition.url
            .replace('{post_category}', parsedArgs.post_category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
updatec110ea4fb1dbe5492dfc54e744af0aee.put = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatec110ea4fb1dbe5492dfc54e744af0aee.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/post_categories/{post_category}'
 */
updatec110ea4fb1dbe5492dfc54e744af0aee.patch = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updatec110ea4fb1dbe5492dfc54e744af0aee.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
const update06d58ecd024403ce380125115eb283bf = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update06d58ecd024403ce380125115eb283bf.url(args, options),
    method: 'put',
})

update06d58ecd024403ce380125115eb283bf.definition = {
    methods: ["put","patch"],
    url: '/admin/comments/{comment}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update06d58ecd024403ce380125115eb283bf.url = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return update06d58ecd024403ce380125115eb283bf.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update06d58ecd024403ce380125115eb283bf.put = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update06d58ecd024403ce380125115eb283bf.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PostCategoryController::update
 * @see app/Http/Controllers/Core/PostCategoryController.php:51
 * @route '/admin/comments/{comment}'
 */
update06d58ecd024403ce380125115eb283bf.patch = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update06d58ecd024403ce380125115eb283bf.url(args, options),
    method: 'patch',
})

export const update = {
    '/admin/post_categories/{post_category}': updatec110ea4fb1dbe5492dfc54e744af0aee,
    '/admin/comments/{comment}': update06d58ecd024403ce380125115eb283bf,
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
const destroyc110ea4fb1dbe5492dfc54e744af0aee = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyc110ea4fb1dbe5492dfc54e744af0aee.url(args, options),
    method: 'delete',
})

destroyc110ea4fb1dbe5492dfc54e744af0aee.definition = {
    methods: ["delete"],
    url: '/admin/post_categories/{post_category}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
destroyc110ea4fb1dbe5492dfc54e744af0aee.url = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return destroyc110ea4fb1dbe5492dfc54e744af0aee.definition.url
            .replace('{post_category}', parsedArgs.post_category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/post_categories/{post_category}'
 */
destroyc110ea4fb1dbe5492dfc54e744af0aee.delete = (args: { post_category: string | number } | [post_category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyc110ea4fb1dbe5492dfc54e744af0aee.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
const destroy06d58ecd024403ce380125115eb283bf = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy06d58ecd024403ce380125115eb283bf.url(args, options),
    method: 'delete',
})

destroy06d58ecd024403ce380125115eb283bf.definition = {
    methods: ["delete"],
    url: '/admin/comments/{comment}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
destroy06d58ecd024403ce380125115eb283bf.url = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return destroy06d58ecd024403ce380125115eb283bf.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PostCategoryController::destroy
 * @see app/Http/Controllers/Core/PostCategoryController.php:62
 * @route '/admin/comments/{comment}'
 */
destroy06d58ecd024403ce380125115eb283bf.delete = (args: { comment: string | number } | [comment: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy06d58ecd024403ce380125115eb283bf.url(args, options),
    method: 'delete',
})

export const destroy = {
    '/admin/post_categories/{post_category}': destroyc110ea4fb1dbe5492dfc54e744af0aee,
    '/admin/comments/{comment}': destroy06d58ecd024403ce380125115eb283bf,
}

const PostCategoryController = { post_categories_data, index, store, update, destroy }

export default PostCategoryController