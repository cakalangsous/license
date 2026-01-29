import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\TwoFactorController::enable
 * @see app/Http/Controllers/Core/TwoFactorController.php:15
 * @route '/admin/two-factor-authentication'
 */
export const enable = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: enable.url(options),
    method: 'post',
})

enable.definition = {
    methods: ["post"],
    url: '/admin/two-factor-authentication',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\TwoFactorController::enable
 * @see app/Http/Controllers/Core/TwoFactorController.php:15
 * @route '/admin/two-factor-authentication'
 */
enable.url = (options?: RouteQueryOptions) => {
    return enable.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TwoFactorController::enable
 * @see app/Http/Controllers/Core/TwoFactorController.php:15
 * @route '/admin/two-factor-authentication'
 */
enable.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: enable.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\TwoFactorController::confirm
 * @see app/Http/Controllers/Core/TwoFactorController.php:22
 * @route '/admin/two-factor-authentication/confirm'
 */
export const confirm = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(options),
    method: 'post',
})

confirm.definition = {
    methods: ["post"],
    url: '/admin/two-factor-authentication/confirm',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\TwoFactorController::confirm
 * @see app/Http/Controllers/Core/TwoFactorController.php:22
 * @route '/admin/two-factor-authentication/confirm'
 */
confirm.url = (options?: RouteQueryOptions) => {
    return confirm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TwoFactorController::confirm
 * @see app/Http/Controllers/Core/TwoFactorController.php:22
 * @route '/admin/two-factor-authentication/confirm'
 */
confirm.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: confirm.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\TwoFactorController::disable
 * @see app/Http/Controllers/Core/TwoFactorController.php:38
 * @route '/admin/two-factor-authentication'
 */
export const disable = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: disable.url(options),
    method: 'delete',
})

disable.definition = {
    methods: ["delete"],
    url: '/admin/two-factor-authentication',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\TwoFactorController::disable
 * @see app/Http/Controllers/Core/TwoFactorController.php:38
 * @route '/admin/two-factor-authentication'
 */
disable.url = (options?: RouteQueryOptions) => {
    return disable.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TwoFactorController::disable
 * @see app/Http/Controllers/Core/TwoFactorController.php:38
 * @route '/admin/two-factor-authentication'
 */
disable.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: disable.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\TwoFactorController::recoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:49
 * @route '/admin/two-factor-authentication/recovery-codes'
 */
export const recoveryCodes = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recoveryCodes.url(options),
    method: 'post',
})

recoveryCodes.definition = {
    methods: ["post"],
    url: '/admin/two-factor-authentication/recovery-codes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\TwoFactorController::recoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:49
 * @route '/admin/two-factor-authentication/recovery-codes'
 */
recoveryCodes.url = (options?: RouteQueryOptions) => {
    return recoveryCodes.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TwoFactorController::recoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:49
 * @route '/admin/two-factor-authentication/recovery-codes'
 */
recoveryCodes.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recoveryCodes.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\TwoFactorController::regenerateRecoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:62
 * @route '/admin/two-factor-authentication/regenerate-recovery-codes'
 */
export const regenerateRecoveryCodes = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateRecoveryCodes.url(options),
    method: 'post',
})

regenerateRecoveryCodes.definition = {
    methods: ["post"],
    url: '/admin/two-factor-authentication/regenerate-recovery-codes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\TwoFactorController::regenerateRecoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:62
 * @route '/admin/two-factor-authentication/regenerate-recovery-codes'
 */
regenerateRecoveryCodes.url = (options?: RouteQueryOptions) => {
    return regenerateRecoveryCodes.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\TwoFactorController::regenerateRecoveryCodes
 * @see app/Http/Controllers/Core/TwoFactorController.php:62
 * @route '/admin/two-factor-authentication/regenerate-recovery-codes'
 */
regenerateRecoveryCodes.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateRecoveryCodes.url(options),
    method: 'post',
})
const twoFactor = {
    enable: Object.assign(enable, enable),
confirm: Object.assign(confirm, confirm),
disable: Object.assign(disable, disable),
recoveryCodes: Object.assign(recoveryCodes, recoveryCodes),
regenerateRecoveryCodes: Object.assign(regenerateRecoveryCodes, regenerateRecoveryCodes),
}

export default twoFactor