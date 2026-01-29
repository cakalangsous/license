import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\InstallerController::saveEnvironment
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
export const saveEnvironment = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: saveEnvironment.url(options),
    method: 'get',
})

saveEnvironment.definition = {
    methods: ["get","head"],
    url: '/install/environment/save',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\InstallerController::saveEnvironment
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
saveEnvironment.url = (options?: RouteQueryOptions) => {
    return saveEnvironment.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::saveEnvironment
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
saveEnvironment.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: saveEnvironment.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\InstallerController::saveEnvironment
 * @see app/Http/Controllers/InstallerController.php:17
 * @route '/install/environment/save'
 */
saveEnvironment.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: saveEnvironment.url(options),
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
* @see \App\Http\Controllers\InstallerController::finish
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
export const finish = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: finish.url(options),
    method: 'get',
})

finish.definition = {
    methods: ["get","head"],
    url: '/install/final',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\InstallerController::finish
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
finish.url = (options?: RouteQueryOptions) => {
    return finish.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\InstallerController::finish
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
finish.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: finish.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\InstallerController::finish
 * @see app/Http/Controllers/InstallerController.php:156
 * @route '/install/final'
 */
finish.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: finish.url(options),
    method: 'head',
})
const InstallerController = { saveEnvironment, database, runMigrations, finish }

export default InstallerController