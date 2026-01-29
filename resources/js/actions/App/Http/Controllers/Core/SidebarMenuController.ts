import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Core\SidebarMenuController::index
 * @see app/Http/Controllers/Core/SidebarMenuController.php:22
 * @route '/admin/sidebar-menus'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/sidebar-menus',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::index
 * @see app/Http/Controllers/Core/SidebarMenuController.php:22
 * @route '/admin/sidebar-menus'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::index
 * @see app/Http/Controllers/Core/SidebarMenuController.php:22
 * @route '/admin/sidebar-menus'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Core\SidebarMenuController::index
 * @see app/Http/Controllers/Core/SidebarMenuController.php:22
 * @route '/admin/sidebar-menus'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::store
 * @see app/Http/Controllers/Core/SidebarMenuController.php:29
 * @route '/admin/sidebar-menus'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/sidebar-menus',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::store
 * @see app/Http/Controllers/Core/SidebarMenuController.php:29
 * @route '/admin/sidebar-menus'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::store
 * @see app/Http/Controllers/Core/SidebarMenuController.php:29
 * @route '/admin/sidebar-menus'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::update
 * @see app/Http/Controllers/Core/SidebarMenuController.php:36
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
export const update = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/sidebar-menus/{sidebarMenu}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::update
 * @see app/Http/Controllers/Core/SidebarMenuController.php:36
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
update.url = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sidebarMenu: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { sidebarMenu: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    sidebarMenu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sidebarMenu: typeof args.sidebarMenu === 'object'
                ? args.sidebarMenu.id
                : args.sidebarMenu,
                }

    return update.definition.url
            .replace('{sidebarMenu}', parsedArgs.sidebarMenu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::update
 * @see app/Http/Controllers/Core/SidebarMenuController.php:36
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
update.put = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::destroy
 * @see app/Http/Controllers/Core/SidebarMenuController.php:43
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
export const destroy = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/sidebar-menus/{sidebarMenu}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::destroy
 * @see app/Http/Controllers/Core/SidebarMenuController.php:43
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
destroy.url = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sidebarMenu: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { sidebarMenu: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    sidebarMenu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sidebarMenu: typeof args.sidebarMenu === 'object'
                ? args.sidebarMenu.id
                : args.sidebarMenu,
                }

    return destroy.definition.url
            .replace('{sidebarMenu}', parsedArgs.sidebarMenu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::destroy
 * @see app/Http/Controllers/Core/SidebarMenuController.php:43
 * @route '/admin/sidebar-menus/{sidebarMenu}'
 */
destroy.delete = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::reorder
 * @see app/Http/Controllers/Core/SidebarMenuController.php:50
 * @route '/admin/sidebar-menus/reorder'
 */
export const reorder = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reorder.url(options),
    method: 'post',
})

reorder.definition = {
    methods: ["post"],
    url: '/admin/sidebar-menus/reorder',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::reorder
 * @see app/Http/Controllers/Core/SidebarMenuController.php:50
 * @route '/admin/sidebar-menus/reorder'
 */
reorder.url = (options?: RouteQueryOptions) => {
    return reorder.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::reorder
 * @see app/Http/Controllers/Core/SidebarMenuController.php:50
 * @route '/admin/sidebar-menus/reorder'
 */
reorder.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reorder.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::toggleActive
 * @see app/Http/Controllers/Core/SidebarMenuController.php:65
 * @route '/admin/sidebar-menus/{sidebarMenu}/toggle'
 */
export const toggleActive = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleActive.url(args, options),
    method: 'post',
})

toggleActive.definition = {
    methods: ["post"],
    url: '/admin/sidebar-menus/{sidebarMenu}/toggle',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::toggleActive
 * @see app/Http/Controllers/Core/SidebarMenuController.php:65
 * @route '/admin/sidebar-menus/{sidebarMenu}/toggle'
 */
toggleActive.url = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sidebarMenu: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { sidebarMenu: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    sidebarMenu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sidebarMenu: typeof args.sidebarMenu === 'object'
                ? args.sidebarMenu.id
                : args.sidebarMenu,
                }

    return toggleActive.definition.url
            .replace('{sidebarMenu}', parsedArgs.sidebarMenu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::toggleActive
 * @see app/Http/Controllers/Core/SidebarMenuController.php:65
 * @route '/admin/sidebar-menus/{sidebarMenu}/toggle'
 */
toggleActive.post = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleActive.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::addChild
 * @see app/Http/Controllers/Core/SidebarMenuController.php:72
 * @route '/admin/sidebar-menus/{sidebarMenu}/add-child'
 */
export const addChild = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addChild.url(args, options),
    method: 'post',
})

addChild.definition = {
    methods: ["post"],
    url: '/admin/sidebar-menus/{sidebarMenu}/add-child',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::addChild
 * @see app/Http/Controllers/Core/SidebarMenuController.php:72
 * @route '/admin/sidebar-menus/{sidebarMenu}/add-child'
 */
addChild.url = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sidebarMenu: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { sidebarMenu: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    sidebarMenu: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sidebarMenu: typeof args.sidebarMenu === 'object'
                ? args.sidebarMenu.id
                : args.sidebarMenu,
                }

    return addChild.definition.url
            .replace('{sidebarMenu}', parsedArgs.sidebarMenu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Core\SidebarMenuController::addChild
 * @see app/Http/Controllers/Core/SidebarMenuController.php:72
 * @route '/admin/sidebar-menus/{sidebarMenu}/add-child'
 */
addChild.post = (args: { sidebarMenu: string | number | { id: string | number } } | [sidebarMenu: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addChild.url(args, options),
    method: 'post',
})
const SidebarMenuController = { index, store, update, destroy, reorder, toggleActive, addChild }

export default SidebarMenuController