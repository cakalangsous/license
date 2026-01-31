import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\ActivationController::index
 * @see app/Http/Controllers/Core/ActivationController.php:24
 * @route '/admin/activations'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/activations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\ActivationController::index
 * @see app/Http/Controllers/Core/ActivationController.php:24
 * @route '/admin/activations'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ActivationController::index
 * @see app/Http/Controllers/Core/ActivationController.php:24
 * @route '/admin/activations'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\ActivationController::index
 * @see app/Http/Controllers/Core/ActivationController.php:24
 * @route '/admin/activations'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\ActivationController::deactivate
 * @see app/Http/Controllers/Core/ActivationController.php:52
 * @route '/admin/activations/{activation}/deactivate'
 */
export const deactivate = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(args, options),
    method: 'post',
})

deactivate.definition = {
    methods: ["post"],
    url: '/admin/activations/{activation}/deactivate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\ActivationController::deactivate
 * @see app/Http/Controllers/Core/ActivationController.php:52
 * @route '/admin/activations/{activation}/deactivate'
 */
deactivate.url = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { activation: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { activation: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    activation: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        activation: typeof args.activation === 'object'
                ? args.activation.id
                : args.activation,
                }

    return deactivate.definition.url
            .replace('{activation}', parsedArgs.activation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ActivationController::deactivate
 * @see app/Http/Controllers/Core/ActivationController.php:52
 * @route '/admin/activations/{activation}/deactivate'
 */
deactivate.post = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deactivate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\ActivationController::block
 * @see app/Http/Controllers/Core/ActivationController.php:64
 * @route '/admin/activations/{activation}/block'
 */
export const block = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: block.url(args, options),
    method: 'post',
})

block.definition = {
    methods: ["post"],
    url: '/admin/activations/{activation}/block',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\ActivationController::block
 * @see app/Http/Controllers/Core/ActivationController.php:64
 * @route '/admin/activations/{activation}/block'
 */
block.url = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { activation: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { activation: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    activation: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        activation: typeof args.activation === 'object'
                ? args.activation.id
                : args.activation,
                }

    return block.definition.url
            .replace('{activation}', parsedArgs.activation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ActivationController::block
 * @see app/Http/Controllers/Core/ActivationController.php:64
 * @route '/admin/activations/{activation}/block'
 */
block.post = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: block.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\ActivationController::reactivate
 * @see app/Http/Controllers/Core/ActivationController.php:76
 * @route '/admin/activations/{activation}/reactivate'
 */
export const reactivate = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reactivate.url(args, options),
    method: 'post',
})

reactivate.definition = {
    methods: ["post"],
    url: '/admin/activations/{activation}/reactivate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\ActivationController::reactivate
 * @see app/Http/Controllers/Core/ActivationController.php:76
 * @route '/admin/activations/{activation}/reactivate'
 */
reactivate.url = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { activation: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { activation: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    activation: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        activation: typeof args.activation === 'object'
                ? args.activation.id
                : args.activation,
                }

    return reactivate.definition.url
            .replace('{activation}', parsedArgs.activation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ActivationController::reactivate
 * @see app/Http/Controllers/Core/ActivationController.php:76
 * @route '/admin/activations/{activation}/reactivate'
 */
reactivate.post = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reactivate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\ActivationController::destroy
 * @see app/Http/Controllers/Core/ActivationController.php:88
 * @route '/admin/activations/{activation}'
 */
export const destroy = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/activations/{activation}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\ActivationController::destroy
 * @see app/Http/Controllers/Core/ActivationController.php:88
 * @route '/admin/activations/{activation}'
 */
destroy.url = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { activation: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { activation: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    activation: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        activation: typeof args.activation === 'object'
                ? args.activation.id
                : args.activation,
                }

    return destroy.definition.url
            .replace('{activation}', parsedArgs.activation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\ActivationController::destroy
 * @see app/Http/Controllers/Core/ActivationController.php:88
 * @route '/admin/activations/{activation}'
 */
destroy.delete = (args: { activation: number | { id: number } } | [activation: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const activations = {
    index: Object.assign(index, index),
deactivate: Object.assign(deactivate, deactivate),
block: Object.assign(block, block),
reactivate: Object.assign(reactivate, reactivate),
destroy: Object.assign(destroy, destroy),
}

export default activations