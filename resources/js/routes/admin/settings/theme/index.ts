import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:77
 * @route '/admin/settings/theme'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/settings/theme',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:77
 * @route '/admin/settings/theme'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:77
 * @route '/admin/settings/theme'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::reset
 * @see app/Http/Controllers/Core/SettingsController.php:143
 * @route '/admin/settings/theme/reset'
 */
export const reset = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})

reset.definition = {
    methods: ["post"],
    url: '/admin/settings/theme/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::reset
 * @see app/Http/Controllers/Core/SettingsController.php:143
 * @route '/admin/settings/theme/reset'
 */
reset.url = (options?: RouteQueryOptions) => {
    return reset.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::reset
 * @see app/Http/Controllers/Core/SettingsController.php:143
 * @route '/admin/settings/theme/reset'
 */
reset.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})
const theme = {
    update: Object.assign(update, update),
reset: Object.assign(reset, reset),
}

export default theme