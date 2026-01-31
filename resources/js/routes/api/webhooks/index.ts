import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::envato
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
export const envato = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: envato.url(options),
    method: 'post',
})

envato.definition = {
    methods: ["post"],
    url: '/api/webhooks/envato',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::envato
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
envato.url = (options?: RouteQueryOptions) => {
    return envato.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\EnvatoWebhookController::envato
 * @see app/Http/Controllers/Api/EnvatoWebhookController.php:15
 * @route '/api/webhooks/envato'
 */
envato.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: envato.url(options),
    method: 'post',
})
const webhooks = {
    envato: Object.assign(envato, envato),
}

export default webhooks