import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\AccessController::update
 * @see app/Http/Controllers/Core/AccessController.php:76
 * @route '/admin/access/update/{role}'
 */
export const update = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/access/update/{role}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\AccessController::update
 * @see app/Http/Controllers/Core/AccessController.php:76
 * @route '/admin/access/update/{role}'
 */
update.url = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { role: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    role: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        role: args.role,
                }

    return update.definition.url
            .replace('{role}', parsedArgs.role.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\AccessController::update
 * @see app/Http/Controllers/Core/AccessController.php:76
 * @route '/admin/access/update/{role}'
 */
update.put = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\AccessController::index
 * @see app/Http/Controllers/Core/AccessController.php:27
 * @route '/admin/access'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/access',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\AccessController::index
 * @see app/Http/Controllers/Core/AccessController.php:27
 * @route '/admin/access'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\AccessController::index
 * @see app/Http/Controllers/Core/AccessController.php:27
 * @route '/admin/access'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\AccessController::index
 * @see app/Http/Controllers/Core/AccessController.php:27
 * @route '/admin/access'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\AccessController::getAccessByRole
 * @see app/Http/Controllers/Core/AccessController.php:39
 * @route '/admin/access/role/{role}'
 */
export const getAccessByRole = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getAccessByRole.url(args, options),
    method: 'post',
})

getAccessByRole.definition = {
    methods: ["post"],
    url: '/admin/access/role/{role}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\AccessController::getAccessByRole
 * @see app/Http/Controllers/Core/AccessController.php:39
 * @route '/admin/access/role/{role}'
 */
getAccessByRole.url = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { role: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    role: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        role: args.role,
                }

    return getAccessByRole.definition.url
            .replace('{role}', parsedArgs.role.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\AccessController::getAccessByRole
 * @see app/Http/Controllers/Core/AccessController.php:39
 * @route '/admin/access/role/{role}'
 */
getAccessByRole.post = (args: { role: string | number } | [role: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getAccessByRole.url(args, options),
    method: 'post',
})
const AccessController = { update, index, getAccessByRole }

export default AccessController