import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
export const welcome = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

welcome.definition = {
    methods: ["get","head"],
    url: '/install',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.url = (options?: RouteQueryOptions) => {
    return welcome.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\WelcomeController::welcome
 * @see vendor/froiden/laravel-installer/src/Controllers/WelcomeController.php:15
 * @route '/install'
 */
welcome.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: welcome.url(options),
    method: 'head',
})

/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
export const environment = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environment.url(options),
    method: 'get',
})

environment.definition = {
    methods: ["get","head"],
    url: '/install/environment',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.url = (options?: RouteQueryOptions) => {
    return environment.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environment.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\EnvironmentController::environment
 * @see vendor/froiden/laravel-installer/src/Controllers/EnvironmentController.php:34
 * @route '/install/environment'
 */
environment.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: environment.url(options),
    method: 'head',
})

/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
export const requirements = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: requirements.url(options),
    method: 'get',
})

requirements.definition = {
    methods: ["get","head"],
    url: '/install/requirements',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.url = (options?: RouteQueryOptions) => {
    return requirements.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: requirements.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\RequirementsController::requirements
 * @see vendor/froiden/laravel-installer/src/Controllers/RequirementsController.php:29
 * @route '/install/requirements'
 */
requirements.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: requirements.url(options),
    method: 'head',
})

/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
export const permissions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})

permissions.definition = {
    methods: ["get","head"],
    url: '/install/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.url = (options?: RouteQueryOptions) => {
    return permissions.definition.url + queryParams(options)
}

/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})
/**
* @see \Froiden\LaravelInstaller\Controllers\PermissionsController::permissions
 * @see vendor/froiden/laravel-installer/src/Controllers/PermissionsController.php:30
 * @route '/install/permissions'
 */
permissions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: permissions.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\InstallerController::environmentSave
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
export const environmentSave = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environmentSave.url(options),
    method: 'get',
})

environmentSave.definition = {
    methods: ["get","head"],
    url: '/install/environment/save',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\InstallerController::environmentSave
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
environmentSave.url = (options?: RouteQueryOptions) => {
    return environmentSave.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::environmentSave
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
environmentSave.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: environmentSave.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\InstallerController::environmentSave
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
environmentSave.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: environmentSave.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\InstallerController::database
 * @see app/Http/Controllers/InstallerController.php:148
 * @route '/install/database'
 */
export const database = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: database.url(options),
    method: 'get',
})

database.definition = {
    methods: ["get","head"],
    url: '/install/database',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\InstallerController::database
 * @see app/Http/Controllers/InstallerController.php:148
 * @route '/install/database'
 */
database.url = (options?: RouteQueryOptions) => {
    return database.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::database
 * @see app/Http/Controllers/InstallerController.php:148
 * @route '/install/database'
 */
database.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: database.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\InstallerController::database
 * @see app/Http/Controllers/InstallerController.php:148
 * @route '/install/database'
 */
database.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: database.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\InstallerController::runMigrations
 * @see app/Http/Controllers/InstallerController.php:108
 * @route '/install/run-migrations'
 */
export const runMigrations = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: runMigrations.url(options),
    method: 'post',
})

runMigrations.definition = {
    methods: ["post"],
    url: '/install/run-migrations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\InstallerController::runMigrations
 * @see app/Http/Controllers/InstallerController.php:108
 * @route '/install/run-migrations'
 */
runMigrations.url = (options?: RouteQueryOptions) => {
    return runMigrations.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::runMigrations
 * @see app/Http/Controllers/InstallerController.php:108
 * @route '/install/run-migrations'
 */
runMigrations.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: runMigrations.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\InstallerController::final
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
export const final = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: final.url(options),
    method: 'get',
})

final.definition = {
    methods: ["get","head"],
    url: '/install/final',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\InstallerController::final
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
final.url = (options?: RouteQueryOptions) => {
    return final.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::final
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
final.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: final.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\InstallerController::final
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
final.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: final.url(options),
    method: 'head',
})
const LaravelInstaller = {
    welcome: Object.assign(welcome, welcome),
environment: Object.assign(environment, environment),
requirements: Object.assign(requirements, requirements),
permissions: Object.assign(permissions, permissions),
environmentSave: Object.assign(environmentSave, environmentSave),
database: Object.assign(database, database),
runMigrations: Object.assign(runMigrations, runMigrations),
final: Object.assign(final, final),
}

export default LaravelInstaller