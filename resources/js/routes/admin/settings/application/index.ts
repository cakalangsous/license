import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/settings/application',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})
const application = {
    update: Object.assign(update, update),
}

export default application