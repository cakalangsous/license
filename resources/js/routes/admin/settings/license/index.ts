import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/settings/license',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})
const license = {
    update: Object.assign(update, update),
}

export default license