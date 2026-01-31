import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\PermissionController::permissions_data
 * @see app/Http/Controllers/Core/PermissionController.php:0
 * @route '/admin/permissions/data'
 */
export const permissions_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions_data.url(options),
    method: 'get',
})

permissions_data.definition = {
    methods: ["get","head"],
    url: '/admin/permissions/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PermissionController::permissions_data
 * @see app/Http/Controllers/Core/PermissionController.php:0
 * @route '/admin/permissions/data'
 */
permissions_data.url = (options?: RouteQueryOptions) => {
    return permissions_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PermissionController::permissions_data
 * @see app/Http/Controllers/Core/PermissionController.php:0
 * @route '/admin/permissions/data'
 */
permissions_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PermissionController::permissions_data
 * @see app/Http/Controllers/Core/PermissionController.php:0
 * @route '/admin/permissions/data'
 */
permissions_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: permissions_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PermissionController::index
 * @see app/Http/Controllers/Core/PermissionController.php:29
 * @route '/admin/permissions'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\PermissionController::index
 * @see app/Http/Controllers/Core/PermissionController.php:29
 * @route '/admin/permissions'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PermissionController::index
 * @see app/Http/Controllers/Core/PermissionController.php:29
 * @route '/admin/permissions'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\PermissionController::index
 * @see app/Http/Controllers/Core/PermissionController.php:29
 * @route '/admin/permissions'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\PermissionController::store
 * @see app/Http/Controllers/Core/PermissionController.php:44
 * @route '/admin/permissions'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\PermissionController::store
 * @see app/Http/Controllers/Core/PermissionController.php:44
 * @route '/admin/permissions'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PermissionController::store
 * @see app/Http/Controllers/Core/PermissionController.php:44
 * @route '/admin/permissions'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\PermissionController::update
 * @see app/Http/Controllers/Core/PermissionController.php:54
 * @route '/admin/permissions/{permission}'
 */
export const update = (args: { permission: string | number } | [permission: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/permissions/{permission}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\PermissionController::update
 * @see app/Http/Controllers/Core/PermissionController.php:54
 * @route '/admin/permissions/{permission}'
 */
update.url = (args: { permission: string | number } | [permission: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { permission: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    permission: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        permission: args.permission,
                }

    return update.definition.url
            .replace('{permission}', parsedArgs.permission.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PermissionController::update
 * @see app/Http/Controllers/Core/PermissionController.php:54
 * @route '/admin/permissions/{permission}'
 */
update.put = (args: { permission: string | number } | [permission: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\PermissionController::update
 * @see app/Http/Controllers/Core/PermissionController.php:54
 * @route '/admin/permissions/{permission}'
 */
update.patch = (args: { permission: string | number } | [permission: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\PermissionController::destroy
 * @see app/Http/Controllers/Core/PermissionController.php:67
 * @route '/admin/permissions/{permission}'
 */
export const destroy = (args: { permission: number | { id: number } } | [permission: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/permissions/{permission}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\PermissionController::destroy
 * @see app/Http/Controllers/Core/PermissionController.php:67
 * @route '/admin/permissions/{permission}'
 */
destroy.url = (args: { permission: number | { id: number } } | [permission: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { permission: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { permission: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    permission: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        permission: typeof args.permission === 'object'
                ? args.permission.id
                : args.permission,
                }

    return destroy.definition.url
            .replace('{permission}', parsedArgs.permission.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\PermissionController::destroy
 * @see app/Http/Controllers/Core/PermissionController.php:67
 * @route '/admin/permissions/{permission}'
 */
destroy.delete = (args: { permission: number | { id: number } } | [permission: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const PermissionController = { permissions_data, index, store, update, destroy }

export default PermissionController