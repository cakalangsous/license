import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\BackupController::index
 * @see app/Http/Controllers/Core/BackupController.php:27
 * @route '/admin/backup'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/backup',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\BackupController::index
 * @see app/Http/Controllers/Core/BackupController.php:27
 * @route '/admin/backup'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BackupController::index
 * @see app/Http/Controllers/Core/BackupController.php:27
 * @route '/admin/backup'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\BackupController::index
 * @see app/Http/Controllers/Core/BackupController.php:27
 * @route '/admin/backup'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\BackupController::createDatabase
 * @see app/Http/Controllers/Core/BackupController.php:42
 * @route '/admin/backup/database'
 */
export const createDatabase = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createDatabase.url(options),
    method: 'post',
})

createDatabase.definition = {
    methods: ["post"],
    url: '/admin/backup/database',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\BackupController::createDatabase
 * @see app/Http/Controllers/Core/BackupController.php:42
 * @route '/admin/backup/database'
 */
createDatabase.url = (options?: RouteQueryOptions) => {
    return createDatabase.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BackupController::createDatabase
 * @see app/Http/Controllers/Core/BackupController.php:42
 * @route '/admin/backup/database'
 */
createDatabase.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createDatabase.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\BackupController::createFiles
 * @see app/Http/Controllers/Core/BackupController.php:54
 * @route '/admin/backup/files'
 */
export const createFiles = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createFiles.url(options),
    method: 'post',
})

createFiles.definition = {
    methods: ["post"],
    url: '/admin/backup/files',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\BackupController::createFiles
 * @see app/Http/Controllers/Core/BackupController.php:54
 * @route '/admin/backup/files'
 */
createFiles.url = (options?: RouteQueryOptions) => {
    return createFiles.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BackupController::createFiles
 * @see app/Http/Controllers/Core/BackupController.php:54
 * @route '/admin/backup/files'
 */
createFiles.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createFiles.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\BackupController::download
 * @see app/Http/Controllers/Core/BackupController.php:66
 * @route '/admin/backup/download/{filename}'
 */
export const download = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/admin/backup/download/{filename}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\BackupController::download
 * @see app/Http/Controllers/Core/BackupController.php:66
 * @route '/admin/backup/download/{filename}'
 */
download.url = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { filename: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    filename: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        filename: args.filename,
                }

    return download.definition.url
            .replace('{filename}', parsedArgs.filename.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BackupController::download
 * @see app/Http/Controllers/Core/BackupController.php:66
 * @route '/admin/backup/download/{filename}'
 */
download.get = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\BackupController::download
 * @see app/Http/Controllers/Core/BackupController.php:66
 * @route '/admin/backup/download/{filename}'
 */
download.head = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\BackupController::destroy
 * @see app/Http/Controllers/Core/BackupController.php:87
 * @route '/admin/backup/{filename}'
 */
export const destroy = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/backup/{filename}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\BackupController::destroy
 * @see app/Http/Controllers/Core/BackupController.php:87
 * @route '/admin/backup/{filename}'
 */
destroy.url = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { filename: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    filename: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        filename: args.filename,
                }

    return destroy.definition.url
            .replace('{filename}', parsedArgs.filename.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\BackupController::destroy
 * @see app/Http/Controllers/Core/BackupController.php:87
 * @route '/admin/backup/{filename}'
 */
destroy.delete = (args: { filename: string | number } | [filename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const BackupController = { index, createDatabase, createFiles, download, destroy }

export default BackupController