<script setup>
import { Link } from "@inertiajs/vue3";
import FrontendLayout from "@/Layouts/FrontendLayout.vue";
import {
    ShieldCheckIcon,
    CubeIcon,
    PaintBrushIcon,
    DocumentTextIcon,
    BellIcon,
    ArchiveBoxIcon,
    UserGroupIcon,
    Cog6ToothIcon,
    PhotoIcon,
    Bars3Icon,
    ServerIcon,
    KeyIcon,
    CheckCircleIcon,
    ArrowRightIcon,
    SparklesIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    appName: String,
    appLogo: String,
    appDescription: String,
    features: Array,
    capabilities: Array,
});

const iconMap = {
    ShieldCheckIcon,
    CubeIcon,
    PaintBrushIcon,
    DocumentTextIcon,
    BellIcon,
    ArchiveBoxIcon,
    UserGroupIcon,
    Cog6ToothIcon,
    PhotoIcon,
    Bars3Icon,
    ServerIcon,
    KeyIcon,
};

const getIcon = (iconName) => iconMap[iconName] || SparklesIcon;
</script>

<template>
    <FrontendLayout
        title="Home"
        :appName="appName"
        :appLogo="appLogo"
        :appDescription="appDescription"
    >
        <!-- Hero Section -->
        <section
            class="relative min-h-[90vh] flex items-center overflow-hidden"
        >
            <!-- Gradient Background -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary-500/10 via-purple-500/5 to-pink-500/10 dark:from-primary-900/20 dark:via-purple-900/10 dark:to-pink-900/20"
            ></div>

            <!-- Animated Orbs -->
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-primary-500/30 rounded-full blur-3xl animate-pulse"
            ></div>
            <div
                class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse delay-700"
            ></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <!-- Badge -->
                    <div
                        class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-600 dark:text-primary-400 text-sm font-medium mb-8"
                    >
                        <SparklesIcon class="w-4 h-4 mr-2" />
                        Premium Laravel Admin Panel
                    </div>

                    <!-- Main Heading -->
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white leading-tight"
                    >
                        Build Amazing Apps
                        <span
                            class="block bg-gradient-to-r from-primary-500 via-purple-500 to-pink-500 bg-clip-text text-transparent"
                        >
                            Faster Than Ever
                        </span>
                    </h1>

                    <!-- Subheading -->
                    <p
                        class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto"
                    >
                        {{ appName || "Laraku" }} is a beautifully designed,
                        feature-rich Laravel admin panel that accelerates your
                        development workflow with powerful tools and modern
                        aesthetics.
                    </p>

                    <!-- CTA Buttons -->
                    <div
                        class="mt-10 flex flex-col sm:flex-row justify-center gap-4"
                    >
                        <Link
                            href="/admin/login"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-xl font-semibold text-lg hover:from-primary-600 hover:to-purple-700 transition-all shadow-xl shadow-primary-500/25 hover:shadow-2xl hover:shadow-primary-500/30 hover:-translate-y-0.5"
                        >
                            Get Started
                            <ArrowRightIcon class="w-5 h-5 ml-2" />
                        </Link>
                        <a
                            href="#features"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl font-semibold text-lg border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 transition-all hover:-translate-y-0.5"
                        >
                            Explore Features
                        </a>
                    </div>

                    <!-- Stats -->
                    <div
                        class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-8 max-w-2xl mx-auto"
                    >
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold text-gray-900 dark:text-white"
                            >
                                20+
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                Features
                            </div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold text-gray-900 dark:text-white"
                            >
                                100%
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                Responsive
                            </div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold text-gray-900 dark:text-white"
                            >
                                Vue 3
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                Inertia.js
                            </div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold text-gray-900 dark:text-white"
                            >
                                Dark
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                Mode Ready
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2
                        class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white"
                    >
                        Powerful Features
                    </h2>
                    <p
                        class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto"
                    >
                        Everything you need to build and manage your
                        applications effectively
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="group relative p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-purple-600 text-white mb-4 group-hover:scale-110 transition-transform"
                        >
                            <component
                                :is="getIcon(feature.icon)"
                                class="w-6 h-6"
                            />
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white mb-2"
                        >
                            {{ feature.title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-24 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2
                            class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6"
                        >
                            Why Choose {{ appName || "Laraku" }}?
                        </h2>
                        <p
                            class="text-lg text-gray-600 dark:text-gray-400 mb-8"
                        >
                            Save weeks of development time with a
                            production-ready admin panel that's built to scale
                            with your needs.
                        </p>

                        <ul class="space-y-4">
                            <li class="flex items-start space-x-3">
                                <CheckCircleIcon
                                    class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5"
                                />
                                <span class="text-gray-700 dark:text-gray-300">
                                    <strong
                                        class="text-gray-900 dark:text-white"
                                        >Clean Architecture</strong
                                    >
                                    - Well-organized codebase following Laravel
                                    best practices
                                </span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <CheckCircleIcon
                                    class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5"
                                />
                                <span class="text-gray-700 dark:text-gray-300">
                                    <strong
                                        class="text-gray-900 dark:text-white"
                                        >Modern Stack</strong
                                    >
                                    - Laravel 12, Vue 3, Inertia.js, and
                                    Tailwind CSS
                                </span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <CheckCircleIcon
                                    class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5"
                                />
                                <span class="text-gray-700 dark:text-gray-300">
                                    <strong
                                        class="text-gray-900 dark:text-white"
                                        >Easy Customization</strong
                                    >
                                    - Fully customizable themes and layouts
                                </span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <CheckCircleIcon
                                    class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5"
                                />
                                <span class="text-gray-700 dark:text-gray-300">
                                    <strong
                                        class="text-gray-900 dark:text-white"
                                        >Documentation</strong
                                    >
                                    - Comprehensive documentation to get you
                                    started fast
                                </span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <CheckCircleIcon
                                    class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5"
                                />
                                <span class="text-gray-700 dark:text-gray-300">
                                    <strong
                                        class="text-gray-900 dark:text-white"
                                        >Lifetime Updates</strong
                                    >
                                    - Free updates with new features and
                                    improvements
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="relative bg-gradient-to-br from-primary-500 to-purple-600 rounded-3xl p-8 text-white"
                    >
                        <div
                            class="absolute inset-0 bg-grid-white/10 rounded-3xl"
                        ></div>
                        <div class="relative">
                            <h3 class="text-2xl font-bold mb-4">
                                Ready to Accelerate Your Development?
                            </h3>
                            <p class="text-white/90 mb-6">
                                Join developers who are shipping faster with our
                                powerful admin panel solution.
                            </p>
                            <Link
                                href="/admin/login"
                                class="inline-flex items-center px-6 py-3 bg-white text-primary-600 rounded-xl font-semibold hover:bg-gray-100 transition-colors"
                            >
                                Start Building Today
                                <ArrowRightIcon class="w-5 h-5 ml-2" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-gray-900 dark:bg-gray-950">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    Start Building Your Next Project
                </h2>
                <p class="text-xl text-gray-400 mb-10">
                    Get access to all features and start creating amazing
                    applications today.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <Link
                        href="/admin/login"
                        class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-500 to-purple-600 text-white rounded-xl font-semibold text-lg hover:from-primary-600 hover:to-purple-700 transition-all shadow-xl"
                    >
                        Get Started Now
                        <ArrowRightIcon class="w-5 h-5 ml-2" />
                    </Link>
                    <Link
                        href="/blog"
                        class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-gray-600 text-white rounded-xl font-semibold text-lg hover:border-primary-500 hover:text-primary-400 transition-all"
                    >
                        Read Our Blog
                    </Link>
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>

<style scoped>
.bg-grid-white\/10 {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.animate-pulse {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.delay-700 {
    animation-delay: 700ms;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>
