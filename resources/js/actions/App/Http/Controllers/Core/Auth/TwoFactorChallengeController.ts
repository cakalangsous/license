import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::create
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/two-factor-challenge',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::create
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::create
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::create
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::store
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:24
 * @route '/two-factor-challenge'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/two-factor-challenge',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::store
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:24
 * @route '/two-factor-challenge'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::store
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:24
 * @route '/two-factor-challenge'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const TwoFactorChallengeController = { create, store }

export default TwoFactorChallengeController