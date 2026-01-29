<script setup>
import { Link } from "@inertiajs/vue3";
import FrontendLayout from "@/Layouts/FrontendLayout.vue";
import {
    CalendarDaysIcon,
    TagIcon,
    ArrowLeftIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    appName: String,
    appLogo: String,
    appDescription: String,
    post: Object,
    title: String,
});
</script>

<template>
    <FrontendLayout
        :title="title"
        :appName="appName"
        :appLogo="appLogo"
        :appDescription="post.meta_description || appDescription"
    >
        <article class="bg-white dark:bg-gray-900 min-h-screen">
            <!-- Featured Image -->
            <div
                v-if="post.image"
                class="relative h-[40vh] md:h-[50vh] overflow-hidden bg-gray-900"
            >
                <img
                    :src="post.image"
                    :alt="post.title"
                    class="w-full h-full object-cover opacity-80"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent"
                ></div>

                <!-- Back Button -->
                <Link
                    href="/blog"
                    class="absolute top-6 left-6 inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md text-white rounded-lg hover:bg-white/20 transition-colors"
                >
                    <ArrowLeftIcon class="w-4 h-4 mr-2" />
                    Back to Blog
                </Link>
            </div>

            <!-- No Image Header -->
            <div
                v-else
                class="pt-24 pb-8 bg-gradient-to-br from-primary-500 to-purple-600"
            >
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <Link
                        href="/blog"
                        class="inline-flex items-center text-white/80 hover:text-white mb-6 transition-colors"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Back to Blog
                    </Link>
                </div>
            </div>

            <!-- Content Container -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span
                        class="inline-flex items-center px-3 py-1 text-sm font-medium bg-primary-500/10 text-primary-600 dark:text-primary-400 rounded-full"
                    >
                        {{ post.category }}
                    </span>
                    <span
                        class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400"
                    >
                        <CalendarDaysIcon class="w-4 h-4 mr-1.5" />
                        {{ post.published_at }}
                    </span>
                </div>

                <!-- Title -->
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-8 leading-tight"
                >
                    {{ post.title }}
                </h1>

                <!-- Tags -->
                <div
                    v-if="post.tags && post.tags.length"
                    class="flex flex-wrap gap-2 mb-10"
                >
                    <span
                        v-for="tag in post.tags"
                        :key="tag"
                        class="inline-flex items-center px-3 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full"
                    >
                        <TagIcon class="w-3 h-3 mr-1" />
                        {{ tag }}
                    </span>
                </div>

                <!-- Content -->
                <div
                    class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-a:text-primary-500 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl"
                    v-html="post.body"
                ></div>

                <!-- Back to Blog -->
                <div
                    class="mt-16 pt-8 border-t border-gray-200 dark:border-gray-700"
                >
                    <Link
                        href="/blog"
                        class="inline-flex items-center text-primary-500 hover:text-primary-600 font-medium transition-colors"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Back to all posts
                    </Link>
                </div>
            </div>
        </article>
    </FrontendLayout>
</template>

<style scoped>
/* Prose styling overrides */
:deep(.prose) {
    --tw-prose-body: theme("colors.gray.700");
    --tw-prose-headings: theme("colors.gray.900");
    --tw-prose-links: theme("colors.primary.500");
    --tw-prose-bold: theme("colors.gray.900");
    --tw-prose-quotes: theme("colors.gray.600");
    --tw-prose-code: theme("colors.primary.600");
    --tw-prose-pre-bg: theme("colors.gray.900");
}

:deep(.dark .prose) {
    --tw-prose-body: theme("colors.gray.300");
    --tw-prose-headings: theme("colors.white");
    --tw-prose-links: theme("colors.primary.400");
    --tw-prose-bold: theme("colors.white");
    --tw-prose-quotes: theme("colors.gray.400");
    --tw-prose-code: theme("colors.primary.400");
    --tw-prose-pre-bg: theme("colors.gray.800");
}
</style>
