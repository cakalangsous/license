import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\VerificationLogController::index
 * @see app/Http/Controllers/Core/VerificationLogController.php:20
 * @route '/admin/verification-logs'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/verification-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\VerificationLogController::index
 * @see app/Http/Controllers/Core/VerificationLogController.php:20
 * @route '/admin/verification-logs'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\VerificationLogController::index
 * @see app/Http/Controllers/Core/VerificationLogController.php:20
 * @route '/admin/verification-logs'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\VerificationLogController::index
 * @see app/Http/Controllers/Core/VerificationLogController.php:20
 * @route '/admin/verification-logs'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\VerificationLogController::show
 * @see app/Http/Controllers/Core/VerificationLogController.php:29
 * @route '/admin/verification-logs/{verificationLog}'
 */
export const show = (args: { verificationLog: number | { id: number } } | [verificationLog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/verification-logs/{verificationLog}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\VerificationLogController::show
 * @see app/Http/Controllers/Core/VerificationLogController.php:29
 * @route '/admin/verification-logs/{verificationLog}'
 */
show.url = (args: { verificationLog: number | { id: number } } | [verificationLog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { verificationLog: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { verificationLog: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    verificationLog: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        verificationLog: typeof args.verificationLog === 'object'
                ? args.verificationLog.id
                : args.verificationLog,
                }

    return show.definition.url
            .replace('{verificationLog}', parsedArgs.verificationLog.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\VerificationLogController::show
 * @see app/Http/Controllers/Core/VerificationLogController.php:29
 * @route '/admin/verification-logs/{verificationLog}'
 */
show.get = (args: { verificationLog: number | { id: number } } | [verificationLog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\VerificationLogController::show
 * @see app/Http/Controllers/Core/VerificationLogController.php:29
 * @route '/admin/verification-logs/{verificationLog}'
 */
show.head = (args: { verificationLog: number | { id: number } } | [verificationLog: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})
const verificationLogs = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
}

export default verificationLogs