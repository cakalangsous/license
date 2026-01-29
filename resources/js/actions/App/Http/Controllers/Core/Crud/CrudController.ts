import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::crud_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/data'
 */
export const crud_data = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: crud_data.url(options),
    method: 'get',
})

crud_data.definition = {
    methods: ["get","head"],
    url: '/admin/crud/data',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::crud_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/data'
 */
crud_data.url = (options?: RouteQueryOptions) => {
    return crud_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::crud_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/data'
 */
crud_data.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: crud_data.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::crud_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/data'
 */
crud_data.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: crud_data.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::get_validations_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/get_validations_data'
 */
export const get_validations_data = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: get_validations_data.url(options),
    method: 'post',
})

get_validations_data.definition = {
    methods: ["post"],
    url: '/admin/crud/get_validations_data',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::get_validations_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/get_validations_data'
 */
get_validations_data.url = (options?: RouteQueryOptions) => {
    return get_validations_data.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::get_validations_data
 * @see app/Http/Controllers/Core/Crud/CrudController.php:0
 * @route '/admin/crud/get_validations_data'
 */
get_validations_data.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: get_validations_data.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::getTableColumns
 * @see app/Http/Controllers/Core/Crud/CrudController.php:74
 * @route '/admin/crud/table-columns/{table}'
 */
export const getTableColumns = (args: { table: string | number } | [table: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getTableColumns.url(args, options),
    method: 'get',
})

getTableColumns.definition = {
    methods: ["get","head"],
    url: '/admin/crud/table-columns/{table}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::getTableColumns
 * @see app/Http/Controllers/Core/Crud/CrudController.php:74
 * @route '/admin/crud/table-columns/{table}'
 */
getTableColumns.url = (args: { table: string | number } | [table: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { table: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    table: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        table: args.table,
                }

    return getTableColumns.definition.url
            .replace('{table}', parsedArgs.table.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::getTableColumns
 * @see app/Http/Controllers/Core/Crud/CrudController.php:74
 * @route '/admin/crud/table-columns/{table}'
 */
getTableColumns.get = (args: { table: string | number } | [table: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getTableColumns.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::getTableColumns
 * @see app/Http/Controllers/Core/Crud/CrudController.php:74
 * @route '/admin/crud/table-columns/{table}'
 */
getTableColumns.head = (args: { table: string | number } | [table: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getTableColumns.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::index
 * @see app/Http/Controllers/Core/Crud/CrudController.php:31
 * @route '/admin/crud'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/crud',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::index
 * @see app/Http/Controllers/Core/Crud/CrudController.php:31
 * @route '/admin/crud'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::index
 * @see app/Http/Controllers/Core/Crud/CrudController.php:31
 * @route '/admin/crud'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::index
 * @see app/Http/Controllers/Core/Crud/CrudController.php:31
 * @route '/admin/crud'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::create
 * @see app/Http/Controllers/Core/Crud/CrudController.php:102
 * @route '/admin/crud/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/crud/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::create
 * @see app/Http/Controllers/Core/Crud/CrudController.php:102
 * @route '/admin/crud/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::create
 * @see app/Http/Controllers/Core/Crud/CrudController.php:102
 * @route '/admin/crud/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::create
 * @see app/Http/Controllers/Core/Crud/CrudController.php:102
 * @route '/admin/crud/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::store
 * @see app/Http/Controllers/Core/Crud/CrudController.php:119
 * @route '/admin/crud'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/crud',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::store
 * @see app/Http/Controllers/Core/Crud/CrudController.php:119
 * @route '/admin/crud'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::store
 * @see app/Http/Controllers/Core/Crud/CrudController.php:119
 * @route '/admin/crud'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::show
 * @see app/Http/Controllers/Core/Crud/CrudController.php:210
 * @route '/admin/crud/{crud}'
 */
export const show = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/crud/{crud}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::show
 * @see app/Http/Controllers/Core/Crud/CrudController.php:210
 * @route '/admin/crud/{crud}'
 */
show.url = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { crud: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    crud: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        crud: args.crud,
                }

    return show.definition.url
            .replace('{crud}', parsedArgs.crud.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::show
 * @see app/Http/Controllers/Core/Crud/CrudController.php:210
 * @route '/admin/crud/{crud}'
 */
show.get = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::show
 * @see app/Http/Controllers/Core/Crud/CrudController.php:210
 * @route '/admin/crud/{crud}'
 */
show.head = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::edit
 * @see app/Http/Controllers/Core/Crud/CrudController.php:218
 * @route '/admin/crud/{crud}/edit'
 */
export const edit = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/crud/{crud}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::edit
 * @see app/Http/Controllers/Core/Crud/CrudController.php:218
 * @route '/admin/crud/{crud}/edit'
 */
edit.url = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { crud: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    crud: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        crud: args.crud,
                }

    return edit.definition.url
            .replace('{crud}', parsedArgs.crud.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::edit
 * @see app/Http/Controllers/Core/Crud/CrudController.php:218
 * @route '/admin/crud/{crud}/edit'
 */
edit.get = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::edit
 * @see app/Http/Controllers/Core/Crud/CrudController.php:218
 * @route '/admin/crud/{crud}/edit'
 */
edit.head = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::update
 * @see app/Http/Controllers/Core/Crud/CrudController.php:296
 * @route '/admin/crud/{crud}'
 */
export const update = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/crud/{crud}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::update
 * @see app/Http/Controllers/Core/Crud/CrudController.php:296
 * @route '/admin/crud/{crud}'
 */
update.url = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { crud: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    crud: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        crud: args.crud,
                }

    return update.definition.url
            .replace('{crud}', parsedArgs.crud.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::update
 * @see app/Http/Controllers/Core/Crud/CrudController.php:296
 * @route '/admin/crud/{crud}'
 */
update.put = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Core\Crud\CrudController::update
 * @see app/Http/Controllers/Core/Crud/CrudController.php:296
 * @route '/admin/crud/{crud}'
 */
update.patch = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::destroy
 * @see app/Http/Controllers/Core/Crud/CrudController.php:416
 * @route '/admin/crud/{crud}'
 */
export const destroy = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/crud/{crud}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::destroy
 * @see app/Http/Controllers/Core/Crud/CrudController.php:416
 * @route '/admin/crud/{crud}'
 */
destroy.url = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { crud: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    crud: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        crud: args.crud,
                }

    return destroy.definition.url
            .replace('{crud}', parsedArgs.crud.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\Crud\CrudController::destroy
 * @see app/Http/Controllers/Core/Crud/CrudController.php:416
 * @route '/admin/crud/{crud}'
 */
destroy.delete = (args: { crud: string | number } | [crud: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const CrudController = { crud_data, get_validations_data, getTableColumns, index, create, store, show, edit, update, destroy }

export default CrudController