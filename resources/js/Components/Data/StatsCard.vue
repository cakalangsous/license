<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    icon: {
        type: String,
        default: "chart",
    },
    color: {
        type: String,
        default: "purple",
        validator: (value) =>
            ["purple", "blue", "green", "red", "yellow", "cyan"].includes(
                value
            ),
    },
});

const colorClasses = {
    purple: "bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300",
    blue: "bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300",
    green: "bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300",
    red: "bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300",
    yellow: "bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300",
    cyan: "bg-cyan-100 text-cyan-600 dark:bg-cyan-900 dark:text-cyan-300",
};

const icons = {
    chart: "M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z",
    eye: "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z",
    users: "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z",
    bookmark: "M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z",
    follow: "M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z",
};
</script>

<template>
    <div class="bg-white dark:bg-secondary-800 rounded shadow-card">
        <div class="p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center"
                    :class="colorClasses[color]"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            :d="icons[icon] || icons.chart"
                        />
                    </svg>
                </div>
                <div>
                    <p
                        class="text-sm font-medium text-secondary-500 dark:text-secondary-400"
                    >
                        {{ title }}
                    </p>
                    <p class="text-2xl font-bold text-heading dark:text-white">
                        {{ value }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
