import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:33
 * @route '/admin/settings'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:33
 * @route '/admin/settings'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:33
 * @route '/admin/settings'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::index
 * @see app/Http/Controllers/Core/SettingsController.php:33
 * @route '/admin/settings'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:50
 * @route '/admin/settings/application'
 */
export const application = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: application.url(options),
    method: 'get',
})

application.definition = {
    methods: ["get","head"],
    url: '/admin/settings/application',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:50
 * @route '/admin/settings/application'
 */
application.url = (options?: RouteQueryOptions) => {
    return application.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:50
 * @route '/admin/settings/application'
 */
application.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: application.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::application
 * @see app/Http/Controllers/Core/SettingsController.php:50
 * @route '/admin/settings/application'
 */
application.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: application.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::updateApplication
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
export const updateApplication = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateApplication.url(options),
    method: 'put',
})

updateApplication.definition = {
    methods: ["put"],
    url: '/admin/settings/application',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::updateApplication
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
updateApplication.url = (options?: RouteQueryOptions) => {
    return updateApplication.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::updateApplication
 * @see app/Http/Controllers/Core/SettingsController.php:58
 * @route '/admin/settings/application'
 */
updateApplication.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateApplication.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:70
 * @route '/admin/settings/theme'
 */
export const theme = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: theme.url(options),
    method: 'get',
})

theme.definition = {
    methods: ["get","head"],
    url: '/admin/settings/theme',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:70
 * @route '/admin/settings/theme'
 */
theme.url = (options?: RouteQueryOptions) => {
    return theme.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:70
 * @route '/admin/settings/theme'
 */
theme.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: theme.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SettingsController::theme
 * @see app/Http/Controllers/Core/SettingsController.php:70
 * @route '/admin/settings/theme'
 */
theme.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: theme.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::updateTheme
 * @see app/Http/Controllers/Core/SettingsController.php:78
 * @route '/admin/settings/theme'
 */
export const updateTheme = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateTheme.url(options),
    method: 'put',
})

updateTheme.definition = {
    methods: ["put"],
    url: '/admin/settings/theme',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::updateTheme
 * @see app/Http/Controllers/Core/SettingsController.php:78
 * @route '/admin/settings/theme'
 */
updateTheme.url = (options?: RouteQueryOptions) => {
    return updateTheme.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::updateTheme
 * @see app/Http/Controllers/Core/SettingsController.php:78
 * @route '/admin/settings/theme'
 */
updateTheme.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateTheme.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::updateEmail
 * @see app/Http/Controllers/Core/SettingsController.php:88
 * @route '/admin/settings/email'
 */
export const updateEmail = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateEmail.url(options),
    method: 'put',
})

updateEmail.definition = {
    methods: ["put"],
    url: '/admin/settings/email',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::updateEmail
 * @see app/Http/Controllers/Core/SettingsController.php:88
 * @route '/admin/settings/email'
 */
updateEmail.url = (options?: RouteQueryOptions) => {
    return updateEmail.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::updateEmail
 * @see app/Http/Controllers/Core/SettingsController.php:88
 * @route '/admin/settings/email'
 */
updateEmail.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateEmail.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::testEmail
 * @see app/Http/Controllers/Core/SettingsController.php:156
 * @route '/admin/settings/email/test'
 */
export const testEmail = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: testEmail.url(options),
    method: 'post',
})

testEmail.definition = {
    methods: ["post"],
    url: '/admin/settings/email/test',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::testEmail
 * @see app/Http/Controllers/Core/SettingsController.php:156
 * @route '/admin/settings/email/test'
 */
testEmail.url = (options?: RouteQueryOptions) => {
    return testEmail.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::testEmail
 * @see app/Http/Controllers/Core/SettingsController.php:156
 * @route '/admin/settings/email/test'
 */
testEmail.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: testEmail.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:111
 * @route '/admin/settings/upload-logo'
 */
export const uploadLogo = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadLogo.url(options),
    method: 'post',
})

uploadLogo.definition = {
    methods: ["post"],
    url: '/admin/settings/upload-logo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:111
 * @route '/admin/settings/upload-logo'
 */
uploadLogo.url = (options?: RouteQueryOptions) => {
    return uploadLogo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::uploadLogo
 * @see app/Http/Controllers/Core/SettingsController.php:111
 * @route '/admin/settings/upload-logo'
 */
uploadLogo.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadLogo.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:128
 * @route '/admin/settings/remove-logo'
 */
export const removeLogo = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: removeLogo.url(options),
    method: 'delete',
})

removeLogo.definition = {
    methods: ["delete"],
    url: '/admin/settings/remove-logo',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:128
 * @route '/admin/settings/remove-logo'
 */
removeLogo.url = (options?: RouteQueryOptions) => {
    return removeLogo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::removeLogo
 * @see app/Http/Controllers/Core/SettingsController.php:128
 * @route '/admin/settings/remove-logo'
 */
removeLogo.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: removeLogo.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::resetTheme
 * @see app/Http/Controllers/Core/SettingsController.php:144
 * @route '/admin/settings/theme/reset'
 */
export const resetTheme = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetTheme.url(options),
    method: 'post',
})

resetTheme.definition = {
    methods: ["post"],
    url: '/admin/settings/theme/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::resetTheme
 * @see app/Http/Controllers/Core/SettingsController.php:144
 * @route '/admin/settings/theme/reset'
 */
resetTheme.url = (options?: RouteQueryOptions) => {
    return resetTheme.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::resetTheme
 * @see app/Http/Controllers/Core/SettingsController.php:144
 * @route '/admin/settings/theme/reset'
 */
resetTheme.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetTheme.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SettingsController::updateLicense
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
export const updateLicense = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateLicense.url(options),
    method: 'put',
})

updateLicense.definition = {
    methods: ["put"],
    url: '/admin/settings/license',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SettingsController::updateLicense
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
updateLicense.url = (options?: RouteQueryOptions) => {
    return updateLicense.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SettingsController::updateLicense
 * @see app/Http/Controllers/Core/SettingsController.php:172
 * @route '/admin/settings/license'
 */
updateLicense.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateLicense.url(options),
    method: 'put',
})
const SettingsController = { index, application, updateApplication, theme, updateTheme, updateEmail, testEmail, uploadLogo, removeLogo, resetTheme, updateLicense }

export default SettingsController