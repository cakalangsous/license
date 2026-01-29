<script setup>
import { ref, onMounted } from "vue";

const isDark = ref(false);

onMounted(() => {
    // Check for saved theme preference or default to system
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        isDark.value = true;
        document.documentElement.classList.add("dark");
    } else if (savedTheme === "light") {
        isDark.value = false;
        document.documentElement.classList.remove("dark");
    } else if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        // No saved preference, use system preference
        isDark.value = true;
        document.documentElement.classList.add("dark");
    } else {
        isDark.value = false;
        document.documentElement.classList.remove("dark");
    }
});

const toggleTheme = () => {
    isDark.value = !isDark.value;

    if (isDark.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
    }
};
</script>

<template>
    <button
        @click="toggleTheme"
        class="p-2 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors"
        :title="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
    >
        <!-- Sun icon (shows in dark mode, click to go light) -->
        <svg
            v-if="isDark"
            class="w-5 h-5 text-yellow-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
            />
        </svg>

        <!-- Moon icon (shows in light mode, click to go dark) -->
        <svg
            v-else
            class="w-5 h-5 text-secondary-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
            />
        </svg>
    </button>
</template>
