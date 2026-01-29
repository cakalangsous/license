import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\UploadController::upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
export const upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

upload.definition = {
    methods: ["post"],
    url: '/admin/editor/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UploadController::upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
upload.url = (options?: RouteQueryOptions) => {
    return upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::upload
 * @see app/Http/Controllers/Core/UploadController.php:17
 * @route '/admin/editor/upload'
 */
upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UploadController::deleteMethod
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteMethod.url(options),
    method: 'delete',
})

deleteMethod.definition = {
    methods: ["delete"],
    url: '/admin/editor/delete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\UploadController::deleteMethod
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::deleteMethod
 * @see app/Http/Controllers/Core/UploadController.php:32
 * @route '/admin/editor/delete'
 */
deleteMethod.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteMethod.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\UploadController::list
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
export const list = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: list.url(options),
    method: 'get',
})

list.definition = {
    methods: ["get","head"],
    url: '/admin/editor/list',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UploadController::list
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
list.url = (options?: RouteQueryOptions) => {
    return list.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::list
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
list.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: list.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UploadController::list
 * @see app/Http/Controllers/Core/UploadController.php:48
 * @route '/admin/editor/list'
 */
list.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: list.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\UploadController::temp_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
export const temp_delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: temp_delete.url(options),
    method: 'delete',
})

temp_delete.definition = {
    methods: ["delete"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\UploadController::temp_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
temp_delete.url = (options?: RouteQueryOptions) => {
    return temp_delete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::temp_delete
 * @see app/Http/Controllers/Core/UploadController.php:73
 * @route '/admin/temp-upload'
 */
temp_delete.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: temp_delete.url(options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
export const temp_upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: temp_upload.url(options),
    method: 'post',
})

temp_upload.definition = {
    methods: ["post"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
temp_upload.url = (options?: RouteQueryOptions) => {
    return temp_upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::temp_upload
 * @see app/Http/Controllers/Core/UploadController.php:55
 * @route '/admin/temp-upload'
 */
temp_upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: temp_upload.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\UploadController::getUploaded
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
export const getUploaded = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getUploaded.url(options),
    method: 'get',
})

getUploaded.definition = {
    methods: ["get","head"],
    url: '/admin/temp-upload',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\UploadController::getUploaded
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
getUploaded.url = (options?: RouteQueryOptions) => {
    return getUploaded.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\UploadController::getUploaded
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
getUploaded.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getUploaded.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\UploadController::getUploaded
 * @see app/Http/Controllers/Core/UploadController.php:78
 * @route '/admin/temp-upload'
 */
getUploaded.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getUploaded.url(options),
    method: 'head',
})
const UploadController = { upload, deleteMethod, list, temp_delete, temp_upload, getUploaded, delete: deleteMethod }

export default UploadController