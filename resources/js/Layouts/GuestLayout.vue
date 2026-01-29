<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    title: String,
});
</script>

<template>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 py-6 px-4"
    >
        <Head :title="title" />

        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <Link href="/" class="inline-block">
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-primary-500 to-purple-600 bg-clip-text text-transparent"
                    >
                        Laraku
                    </span>
                </Link>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
                <slot />
            </div>
        </div>
    </div>
</template>
