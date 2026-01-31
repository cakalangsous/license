import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::handle
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
export const handle = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

handle.definition = {
    methods: ["post"],
    url: '/api/webhooks/envato',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::handle
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
handle.url = (options?: RouteQueryOptions) => {
    return handle.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::handle
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
handle.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})
const EnvatoWebhookController = { handle }

export default EnvatoWebhookController