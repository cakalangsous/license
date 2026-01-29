import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
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
const login = {
    store: Object.assign(store, store),
}

export default login