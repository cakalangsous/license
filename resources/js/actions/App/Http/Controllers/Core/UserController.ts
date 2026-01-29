import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\UserController::user_data
 * @see app/Http/Controllers/Core/UserController.php:0
 * @route '/admin/users/data'
 */
export const user_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user_data.url(options),
    method: 'get',
})

user_data.definition = {
    methods: ["get","head"],
    url: '/admin/users/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UserController::user_data
 * @see app/Http/Controllers/Core/UserController.php:0
 * @route '/admin/users/data'
 */
user_data.url = (options?: RouteQueryOptions) => {
    return user_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::user_data
 * @see app/Http/Controllers/Core/UserController.php:0
 * @route '/admin/users/data'
 */
user_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UserController::user_data
 * @see app/Http/Controllers/Core/UserController.php:0
 * @route '/admin/users/data'
 */
user_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: user_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UserController::index
 * @see app/Http/Controllers/Core/UserController.php:31
 * @route '/admin/users'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UserController::index
 * @see app/Http/Controllers/Core/UserController.php:31
 * @route '/admin/users'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::index
 * @see app/Http/Controllers/Core/UserController.php:31
 * @route '/admin/users'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UserController::index
 * @see app/Http/Controllers/Core/UserController.php:31
 * @route '/admin/users'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UserController::create
 * @see app/Http/Controllers/Core/UserController.php:51
 * @route '/admin/users/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/users/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UserController::create
 * @see app/Http/Controllers/Core/UserController.php:51
 * @route '/admin/users/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::create
 * @see app/Http/Controllers/Core/UserController.php:51
 * @route '/admin/users/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UserController::create
 * @see app/Http/Controllers/Core/UserController.php:51
 * @route '/admin/users/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UserController::store
 * @see app/Http/Controllers/Core/UserController.php:63
 * @route '/admin/users'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/users',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UserController::store
 * @see app/Http/Controllers/Core/UserController.php:63
 * @route '/admin/users'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::store
 * @see app/Http/Controllers/Core/UserController.php:63
 * @route '/admin/users'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UserController::edit
 * @see app/Http/Controllers/Core/UserController.php:74
 * @route '/admin/users/{user}/edit'
 */
export const edit = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/users/{user}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UserController::edit
 * @see app/Http/Controllers/Core/UserController.php:74
 * @route '/admin/users/{user}/edit'
 */
edit.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return edit.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::edit
 * @see app/Http/Controllers/Core/UserController.php:74
 * @route '/admin/users/{user}/edit'
 */
edit.get = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UserController::edit
 * @see app/Http/Controllers/Core/UserController.php:74
 * @route '/admin/users/{user}/edit'
 */
edit.head = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UserController::update
 * @see app/Http/Controllers/Core/UserController.php:98
 * @route '/admin/users/{user}'
 */
export const update = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/users/{user}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\UserController::update
 * @see app/Http/Controllers/Core/UserController.php:98
 * @route '/admin/users/{user}'
 */
update.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return update.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::update
 * @see app/Http/Controllers/Core/UserController.php:98
 * @route '/admin/users/{user}'
 */
update.put = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\UserController::update
 * @see app/Http/Controllers/Core/UserController.php:98
 * @route '/admin/users/{user}'
 */
update.patch = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\UserController::destroy
 * @see app/Http/Controllers/Core/UserController.php:109
 * @route '/admin/users/{user}'
 */
export const destroy = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/users/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\UserController::destroy
 * @see app/Http/Controllers/Core/UserController.php:109
 * @route '/admin/users/{user}'
 */
destroy.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return destroy.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::destroy
 * @see app/Http/Controllers/Core/UserController.php:109
 * @route '/admin/users/{user}'
 */
destroy.delete = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\UserController::exportMethod
 * @see app/Http/Controllers/Core/UserController.php:127
 * @route '/admin/users/export'
 */
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})

exportMethod.definition = {
    methods: ["get","head"],
    url: '/admin/users/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UserController::exportMethod
 * @see app/Http/Controllers/Core/UserController.php:127
 * @route '/admin/users/export'
 */
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::exportMethod
 * @see app/Http/Controllers/Core/UserController.php:127
 * @route '/admin/users/export'
 */
exportMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UserController::exportMethod
 * @see app/Http/Controllers/Core/UserController.php:127
 * @route '/admin/users/export'
 */
exportMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportMethod.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UserController::bulkDestroy
 * @see app/Http/Controllers/Core/UserController.php:134
 * @route '/admin/users/bulk-destroy'
 */
export const bulkDestroy = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDestroy.url(options),
    method: 'post',
})

bulkDestroy.definition = {
    methods: ["post"],
    url: '/admin/users/bulk-destroy',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UserController::bulkDestroy
 * @see app/Http/Controllers/Core/UserController.php:134
 * @route '/admin/users/bulk-destroy'
 */
bulkDestroy.url = (options?: RouteQueryOptions) => {
    return bulkDestroy.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::bulkDestroy
 * @see app/Http/Controllers/Core/UserController.php:134
 * @route '/admin/users/bulk-destroy'
 */
bulkDestroy.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDestroy.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UserController::toggleBan
 * @see app/Http/Controllers/Core/UserController.php:40
 * @route '/admin/users/{user}/ban'
 */
export const toggleBan = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleBan.url(args, options),
    method: 'post',
})

toggleBan.definition = {
    methods: ["post"],
    url: '/admin/users/{user}/ban',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UserController::toggleBan
 * @see app/Http/Controllers/Core/UserController.php:40
 * @route '/admin/users/{user}/ban'
 */
toggleBan.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return toggleBan.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UserController::toggleBan
 * @see app/Http/Controllers/Core/UserController.php:40
 * @route '/admin/users/{user}/ban'
 */
toggleBan.post = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleBan.url(args, options),
    method: 'post',
})
const UserController = { user_data, index, create, store, edit, update, destroy, exportMethod, bulkDestroy, toggleBan, export: exportMethod }

export default UserController