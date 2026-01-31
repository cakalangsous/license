import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\LicenseController::index
 * @see app/Http/Controllers/Core/LicenseController.php:30
 * @route '/admin/licenses'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/licenses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::index
 * @see app/Http/Controllers/Core/LicenseController.php:30
 * @route '/admin/licenses'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::index
 * @see app/Http/Controllers/Core/LicenseController.php:30
 * @route '/admin/licenses'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\LicenseController::index
 * @see app/Http/Controllers/Core/LicenseController.php:30
 * @route '/admin/licenses'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::show
 * @see app/Http/Controllers/Core/LicenseController.php:42
 * @route '/admin/licenses/{license}'
 */
export const show = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/licenses/{license}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::show
 * @see app/Http/Controllers/Core/LicenseController.php:42
 * @route '/admin/licenses/{license}'
 */
show.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return show.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::show
 * @see app/Http/Controllers/Core/LicenseController.php:42
 * @route '/admin/licenses/{license}'
 */
show.get = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\LicenseController::show
 * @see app/Http/Controllers/Core/LicenseController.php:42
 * @route '/admin/licenses/{license}'
 */
show.head = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::store
 * @see app/Http/Controllers/Core/LicenseController.php:67
 * @route '/admin/licenses'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/licenses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::store
 * @see app/Http/Controllers/Core/LicenseController.php:67
 * @route '/admin/licenses'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::store
 * @see app/Http/Controllers/Core/LicenseController.php:67
 * @route '/admin/licenses'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::update
 * @see app/Http/Controllers/Core/LicenseController.php:93
 * @route '/admin/licenses/{license}'
 */
export const update = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/licenses/{license}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::update
 * @see app/Http/Controllers/Core/LicenseController.php:93
 * @route '/admin/licenses/{license}'
 */
update.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return update.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::update
 * @see app/Http/Controllers/Core/LicenseController.php:93
 * @route '/admin/licenses/{license}'
 */
update.put = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::destroy
 * @see app/Http/Controllers/Core/LicenseController.php:119
 * @route '/admin/licenses/{license}'
 */
export const destroy = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/licenses/{license}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::destroy
 * @see app/Http/Controllers/Core/LicenseController.php:119
 * @route '/admin/licenses/{license}'
 */
destroy.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return destroy.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::destroy
 * @see app/Http/Controllers/Core/LicenseController.php:119
 * @route '/admin/licenses/{license}'
 */
destroy.delete = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::revoke
 * @see app/Http/Controllers/Core/LicenseController.php:131
 * @route '/admin/licenses/{license}/revoke'
 */
export const revoke = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: revoke.url(args, options),
    method: 'post',
})

revoke.definition = {
    methods: ["post"],
    url: '/admin/licenses/{license}/revoke',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::revoke
 * @see app/Http/Controllers/Core/LicenseController.php:131
 * @route '/admin/licenses/{license}/revoke'
 */
revoke.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return revoke.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::revoke
 * @see app/Http/Controllers/Core/LicenseController.php:131
 * @route '/admin/licenses/{license}/revoke'
 */
revoke.post = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: revoke.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::suspend
 * @see app/Http/Controllers/Core/LicenseController.php:143
 * @route '/admin/licenses/{license}/suspend'
 */
export const suspend = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: suspend.url(args, options),
    method: 'post',
})

suspend.definition = {
    methods: ["post"],
    url: '/admin/licenses/{license}/suspend',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::suspend
 * @see app/Http/Controllers/Core/LicenseController.php:143
 * @route '/admin/licenses/{license}/suspend'
 */
suspend.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return suspend.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::suspend
 * @see app/Http/Controllers/Core/LicenseController.php:143
 * @route '/admin/licenses/{license}/suspend'
 */
suspend.post = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: suspend.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\LicenseController::reactivate
 * @see app/Http/Controllers/Core/LicenseController.php:155
 * @route '/admin/licenses/{license}/reactivate'
 */
export const reactivate = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reactivate.url(args, options),
    method: 'post',
})

reactivate.definition = {
    methods: ["post"],
    url: '/admin/licenses/{license}/reactivate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\LicenseController::reactivate
 * @see app/Http/Controllers/Core/LicenseController.php:155
 * @route '/admin/licenses/{license}/reactivate'
 */
reactivate.url = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { license: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { license: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    license: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        license: typeof args.license === 'object'
                ? args.license.id
                : args.license,
                }

    return reactivate.definition.url
            .replace('{license}', parsedArgs.license.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\LicenseController::reactivate
 * @see app/Http/Controllers/Core/LicenseController.php:155
 * @route '/admin/licenses/{license}/reactivate'
 */
reactivate.post = (args: { license: number | { id: number } } | [license: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reactivate.url(args, options),
    method: 'post',
})
const LicenseController = { index, show, store, update, destroy, revoke, suspend, reactivate }

export default LicenseController