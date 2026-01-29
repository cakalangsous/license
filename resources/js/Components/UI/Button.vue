<script setup>
import { computed } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "button",
    },
    variant: {
        type: String,
        default: "primary",
        validator: (value) =>
            [
                "primary",
                "secondary",
                "danger",
                "success",
                "warning",
                "info",
                "outline-primary",
                "outline-secondary",
                "outline-danger",
                "outline-success",
                "outline-warning",
                "outline-info",
                "ghost",
            ].includes(value),
    },
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg"].includes(value),
    },
    loading: Boolean,
    disabled: Boolean,
});

const variantClasses = {
    primary: "bg-primary text-white hover:bg-primary-600 focus:ring-primary",
    secondary:
        "bg-secondary text-white hover:bg-secondary-600 focus:ring-secondary",
    danger: "bg-danger text-white hover:bg-red-600 focus:ring-danger",
    success: "bg-green-600 text-white hover:bg-green-700 focus:ring-green-500",
    warning: "bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500",
    info: "bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500",
    "outline-primary":
        "border border-primary text-primary hover:bg-primary hover:text-white focus:ring-primary bg-transparent",
    "outline-secondary":
        "border border-secondary-300 text-secondary-600 hover:bg-secondary-100 focus:ring-secondary bg-transparent dark:border-secondary-600 dark:text-secondary-300 dark:hover:bg-secondary-700",
    "outline-danger":
        "border border-red-500 text-red-500 hover:bg-red-500 hover:text-white focus:ring-red-500 bg-transparent",
    "outline-success":
        "border border-green-500 text-green-500 hover:bg-green-500 hover:text-white focus:ring-green-500 bg-transparent",
    "outline-warning":
        "border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white focus:ring-amber-500 bg-transparent",
    "outline-info":
        "border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white focus:ring-blue-500 bg-transparent",
    ghost: "bg-transparent text-gray-600 hover:bg-gray-100 focus:ring-gray-500 dark:text-gray-300 dark:hover:bg-gray-700",
};

const sizeClasses = {
    sm: "px-3 py-1.5 text-sm",
    md: "px-4 py-2",
    lg: "px-6 py-3 text-lg",
};

const classes = computed(() => [
    "inline-flex items-center justify-center rounded font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed",
    variantClasses[props.variant],
    sizeClasses[props.size],
    { "opacity-50 cursor-not-allowed": props.loading },
]);
</script>

<template>
    <button :type="type" :class="classes" :disabled="disabled || loading">
        <svg
            v-if="loading"
            class="animate-spin -ml-1 mr-2 h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            />
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            />
        </svg>
        <slot />
    </button>
</template>
