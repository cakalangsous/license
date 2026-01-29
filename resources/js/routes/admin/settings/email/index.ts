import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:87
 * @route '/admin/settings/email'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/settings/email',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:87
 * @route '/admin/settings/email'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::update
 * @see app/Http/Controllers/Core/SettingsController.php:87
 * @route '/admin/settings/email'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::test
 * @see app/Http/Controllers/Core/SettingsController.php:155
 * @route '/admin/settings/email/test'
 */
export const test = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: test.url(options),
    method: 'post',
})

test.definition = {
    methods: ["post"],
    url: '/admin/settings/email/test',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::test
 * @see app/Http/Controllers/Core/SettingsController.php:155
 * @route '/admin/settings/email/test'
 */
test.url = (options?: RouteQueryOptions) => {
    return test.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::test
 * @see app/Http/Controllers/Core/SettingsController.php:155
 * @route '/admin/settings/email/test'
 */
test.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: test.url(options),
    method: 'post',
})
const email = {
    update: Object.assign(update, update),
test: Object.assign(test, test),
}

export default email