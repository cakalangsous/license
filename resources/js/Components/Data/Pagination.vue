<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap items-center gap-1 -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-200 focus:border-indigo-500 focus:text-indigo-500 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:border-indigo-400 dark:focus:text-indigo-400"
                    :class="{
                        'bg-primary text-white hover:bg-primary-600':
                            link.active,
                    }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
