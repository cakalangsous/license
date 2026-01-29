<script setup>
import { Link } from "@inertiajs/vue3";
import FrontendLayout from "@/Layouts/FrontendLayout.vue";
import { CalendarDaysIcon, TagIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    appName: String,
    appLogo: String,
    appDescription: String,
    posts: Object,
    title: String,
});
</script>

<template>
    <FrontendLayout
        :title="title"
        :appName="appName"
        :appLogo="appLogo"
        :appDescription="appDescription"
    >
        <!-- Hero Banner -->
        <section
            class="relative py-20 bg-gradient-to-br from-primary-500 to-purple-600"
        >
            <div class="absolute inset-0 bg-grid-white/10"></div>
            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
            >
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    Our Blog
                </h1>
                <p class="text-xl text-white/80 max-w-2xl mx-auto">
                    Insights, tutorials, and updates from our team
                </p>
            </div>
        </section>

        <!-- Blog Posts Grid -->
        <section class="py-20 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Empty State -->
                <div
                    v-if="!posts.data || posts.data.length === 0"
                    class="text-center py-20"
                >
                    <div
                        class="w-20 h-20 mx-auto mb-6 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center"
                    >
                        <TagIcon
                            class="w-10 h-10 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white mb-2"
                    >
                        No Posts Yet
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Check back later for new content!
                    </p>
                </div>

                <!-- Posts Grid -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <Link
                        v-for="post in posts.data"
                        :key="post.id"
                        :href="`/blog/${post.slug}`"
                        class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                    >
                        <!-- Image -->
                        <div
                            class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-700"
                        >
                            <img
                                v-if="post.image"
                                :src="post.image"
                                :alt="post.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center text-gray-400"
                            >
                                <TagIcon class="w-12 h-12" />
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            <span
                                class="inline-block px-3 py-1 text-xs font-medium bg-primary-500/10 text-primary-600 dark:text-primary-400 rounded-full mb-3"
                            >
                                {{ post.category }}
                            </span>

                            <!-- Title -->
                            <h2
                                class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-500 transition-colors line-clamp-2"
                            >
                                {{ post.title }}
                            </h2>

                            <!-- Excerpt -->
                            <p
                                class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4"
                            >
                                {{ post.excerpt }}
                            </p>

                            <!-- Date -->
                            <div
                                class="flex items-center text-sm text-gray-500 dark:text-gray-500"
                            >
                                <CalendarDaysIcon class="w-4 h-4 mr-1.5" />
                                {{ post.published_at }}
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div
                    v-if="posts.links && posts.links.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <nav class="flex items-center space-x-2">
                        <template v-for="link in posts.links" :key="link.label">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                                :class="
                                    link.active
                                        ? 'bg-primary-500 text-white'
                                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700'
                                "
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-4 py-2 text-sm text-gray-400 dark:text-gray-600"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>

<style scoped>
.bg-grid-white\/10 {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
