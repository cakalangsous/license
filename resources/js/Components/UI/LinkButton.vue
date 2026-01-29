<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    variant: {
        type: String,
        default: "primary",
        validator: (value) =>
            [
                "primary",
                "secondary",
                "danger",
                "info",
                "success",
                "warning",
                "outline-primary",
                "outline-secondary",
                "outline-danger",
                "outline-info",
            ].includes(value),
    },
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg"].includes(value),
    },
    preserveState: Boolean,
    preserveScroll: Boolean,
});

const variantClasses = {
    primary: "bg-primary text-white hover:bg-primary-600 focus:ring-primary",
    secondary:
        "bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary",
    danger: "bg-danger text-white hover:bg-red-600 focus:ring-danger",
    info: "bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500",
    success: "bg-green-500 text-white hover:bg-green-600 focus:ring-green-500",
    warning:
        "bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500",
    "outline-primary":
        "border border-primary text-primary hover:bg-primary hover:text-white focus:ring-primary bg-transparent",
    "outline-secondary":
        "border border-secondary-300 text-secondary-600 hover:bg-secondary-100 focus:ring-secondary bg-transparent dark:border-secondary-600 dark:text-secondary-300 dark:hover:bg-secondary-700",
    "outline-danger":
        "border border-danger text-danger hover:bg-danger hover:text-white focus:ring-danger bg-transparent",
    "outline-info":
        "border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white focus:ring-blue-500 bg-transparent",
};

const sizeClasses = {
    sm: "px-3 py-1.5 text-sm",
    md: "px-4 py-2",
    lg: "px-6 py-3 text-lg",
};

const classes = computed(() => [
    "inline-flex items-center justify-center rounded font-medium transition-all focus:outline-none",
    variantClasses[props.variant],
    sizeClasses[props.size],
]);
</script>

<template>
    <Link
        :href="href"
        :class="classes"
        :preserve-state="preserveState"
        :preserve-scroll="preserveScroll"
    >
        <slot />
    </Link>
</template>
