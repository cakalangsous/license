<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    Bars3Icon,
    XMarkIcon,
    SunIcon,
    MoonIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    appName: String,
    appLogo: String,
});

const isMenuOpen = ref(false);
const isDarkMode = ref(document.documentElement.classList.contains("dark"));

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle("dark");
    localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
};

const navLinks = [
    { name: "Home", href: "/" },
    { name: "Blog", href: "/blog" },
];
</script>

<template>
    <nav
        class="fixed top-0 left-0 right-0 z-50 backdrop-blur-lg bg-white/80 dark:bg-gray-900/80 border-b border-gray-200/50 dark:border-gray-700/50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center space-x-2">
                        <img
                            v-if="appLogo"
                            :src="appLogo"
                            :alt="appName"
                            class="h-8 w-auto"
                        />
                        <span
                            v-else
                            class="text-xl font-bold bg-gradient-to-r from-primary-500 to-purple-600 bg-clip-text text-transparent"
                        >
                            {{ appName || "Laraku" }}
                        </span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link
                        v-for="link in navLinks"
                        :key="link.name"
                        :href="link.href"
                        class="text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium"
                    >
                        {{ link.name }}
                    </Link>

                    <!-- Dark Mode Toggle -->
                    <button
                        @click="toggleDarkMode"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                    >
                        <SunIcon v-if="isDarkMode" class="w-5 h-5" />
                        <MoonIcon v-else class="w-5 h-5" />
                    </button>

                    <!-- Login Button -->
                    <Link
                        v-if="$page.props.auth?.user"
                        href="/admin/dashboard"
                        class="px-5 py-2.5 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-lg font-medium hover:from-primary-600 hover:to-purple-700 transition-all shadow-lg shadow-primary-500/25"
                    >
                        Dashboard
                    </Link>
                    <Link
                        v-else
                        href="/admin/login"
                        class="px-5 py-2.5 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-lg font-medium hover:from-primary-600 hover:to-purple-700 transition-all shadow-lg shadow-primary-500/25"
                    >
                        Login
                    </Link>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-2">
                    <button
                        @click="toggleDarkMode"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300"
                    >
                        <SunIcon v-if="isDarkMode" class="w-5 h-5" />
                        <MoonIcon v-else class="w-5 h-5" />
                    </button>
                    <button
                        @click="isMenuOpen = !isMenuOpen"
                        class="p-2 rounded-lg text-gray-700 dark:text-gray-300"
                    >
                        <Bars3Icon v-if="!isMenuOpen" class="w-6 h-6" />
                        <XMarkIcon v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div
            v-show="isMenuOpen"
            class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700"
        >
            <div class="px-4 py-4 space-y-3">
                <Link
                    v-for="link in navLinks"
                    :key="link.name"
                    :href="link.href"
                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                >
                    {{ link.name }}
                </Link>
                <Link
                    v-if="$page.props.auth?.user"
                    href="/admin/dashboard"
                    class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-lg font-medium"
                >
                    Dashboard
                </Link>
                <Link
                    v-else
                    href="/admin/login"
                    class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-lg font-medium"
                >
                    Login
                </Link>
            </div>
        </div>
    </nav>
</template>
