<script setup>
import { ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";
import Navbar from "@/Components/Navbar/Navbar.vue";
import DemoBanner from "@/Components/DemoBanner.vue";

defineProps({
    title: {
        type: String,
        default: "Dashboard",
    },
});

const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
</script>

<template>
    <Head :title="title" />
    <div class="min-h-screen bg-body-bg dark:bg-secondary-900">
        <DemoBanner />
        <Navbar :sidebar-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />

        <Sidebar :open="sidebarOpen" @toggle="toggleSidebar" />

        <div
            class="transition-all duration-300 pt-16 lg:pl-64 flex flex-col min-h-screen"
        >
            <main class="p-4 lg:p-6 flex-1">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-heading dark:text-white">
                        {{ title }}
                    </h3>
                </div>

                <slot />
            </main>

            <footer
                class="mt-auto py-4 px-6 text-center text-sm text-secondary-500 dark:text-secondary-400"
            >
                Copyright &copy; {{ new Date().getFullYear() }}
                {{ $page.props.appName || "Laravel" }}.
            </footer>
        </div>
    </div>
</template>
