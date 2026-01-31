import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::index
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:24
 * @route '/admin/blacklisted-domains'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/blacklisted-domains',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::index
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:24
 * @route '/admin/blacklisted-domains'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::index
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:24
 * @route '/admin/blacklisted-domains'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::index
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:24
 * @route '/admin/blacklisted-domains'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::store
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:33
 * @route '/admin/blacklisted-domains'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/blacklisted-domains',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::store
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:33
 * @route '/admin/blacklisted-domains'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::store
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:33
 * @route '/admin/blacklisted-domains'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::update
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:47
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
export const update = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/blacklisted-domains/{blacklistedDomain}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::update
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:47
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
update.url = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { blacklistedDomain: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { blacklistedDomain: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    blacklistedDomain: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        blacklistedDomain: typeof args.blacklistedDomain === 'object'
                ? args.blacklistedDomain.id
                : args.blacklistedDomain,
                }

    return update.definition.url
            .replace('{blacklistedDomain}', parsedArgs.blacklistedDomain.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::update
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:47
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
update.put = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::destroy
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:61
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
export const destroy = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/blacklisted-domains/{blacklistedDomain}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::destroy
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:61
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
destroy.url = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { blacklistedDomain: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { blacklistedDomain: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    blacklistedDomain: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        blacklistedDomain: typeof args.blacklistedDomain === 'object'
                ? args.blacklistedDomain.id
                : args.blacklistedDomain,
                }

    return destroy.definition.url
            .replace('{blacklistedDomain}', parsedArgs.blacklistedDomain.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::destroy
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:61
 * @route '/admin/blacklisted-domains/{blacklistedDomain}'
 */
destroy.delete = (args: { blacklistedDomain: number | { id: number } } | [blacklistedDomain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::check
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:70
 * @route '/admin/blacklisted-domains/check'
 */
export const check = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: check.url(options),
    method: 'post',
})

check.definition = {
    methods: ["post"],
    url: '/admin/blacklisted-domains/check',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::check
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:70
 * @route '/admin/blacklisted-domains/check'
 */
check.url = (options?: RouteQueryOptions) => {
    return check.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BlacklistedDomainController::check
 * @see app/Http/Controllers/Core/BlacklistedDomainController.php:70
 * @route '/admin/blacklisted-domains/check'
 */
check.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: check.url(options),
    method: 'post',
})
const blacklistedDomains = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
check: Object.assign(check, check),
}

export default blacklistedDomains