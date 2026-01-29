import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import loginDf2c2a from './login'
/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::login
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/two-factor-challenge',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::login
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::login
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Auth\TwoFactorChallengeController::login
 * @see app/Http/Controllers/Core/Auth/TwoFactorChallengeController.php:15
 * @route '/two-factor-challenge'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})
const twoFactor = {
    login: Object.assign(login, loginDf2c2a),
}

export default twoFactor