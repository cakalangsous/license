<script setup>
import { Head } from "@inertiajs/vue3";
import FrontendNavbar from "@/Components/Frontend/FrontendNavbar.vue";
import DemoBanner from "@/Components/DemoBanner.vue";

defineProps({
    title: String,
    appName: String,
    appLogo: String,
    appDescription: String,
});
</script>

<template>
    <div class="frontend-layout min-h-screen bg-gray-50 dark:bg-gray-950">
        <Head :title="title" />
        <DemoBanner />

        <FrontendNavbar :appName="appName" :appLogo="appLogo" />

        <main class="pt-16">
            <slot />
        </main>

        <!-- Footer -->
        <footer
            class="bg-gray-900 dark:bg-gray-950 text-gray-300 border-t border-gray-800"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div class="col-span-1 md:col-span-2">
                        <h3
                            class="text-2xl font-bold bg-gradient-to-r from-primary-400 to-purple-500 bg-clip-text text-transparent"
                        >
                            {{ appName || "Laraku" }}
                        </h3>
                        <p class="mt-4 text-gray-400 max-w-md">
                            {{
                                appDescription ||
                                "A modern, powerful Laravel admin panel with everything you need to build amazing applications."
                            }}
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold text-white mb-4">
                            Quick Links
                        </h4>
                        <ul class="space-y-2">
                            <li>
                                <a
                                    href="/"
                                    class="hover:text-primary-400 transition-colors"
                                    >Home</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/blog"
                                    class="hover:text-primary-400 transition-colors"
                                    >Blog</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/admin/login"
                                    class="hover:text-primary-400 transition-colors"
                                    >Login</a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="font-semibold text-white mb-4">Connect</h4>
                        <ul class="space-y-2">
                            <li>
                                <a
                                    href="#"
                                    class="hover:text-primary-400 transition-colors"
                                    >Documentation</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="hover:text-primary-400 transition-colors"
                                    >Support</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-500"
                >
                    <p>
                        &copy; {{ new Date().getFullYear() }}
                        {{ appName || "Laraku" }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
