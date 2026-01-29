<script setup>
import { computed } from "vue";

const props = defineProps({
    variant: {
        type: String,
        default: "primary",
        validator: (value) =>
            [
                "primary",
                "secondary",
                "success",
                "danger",
                "warning",
                "info",
            ].includes(value),
    },
});

const variantClasses = {
    primary:
        "bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300",
    secondary:
        "bg-secondary-100 text-secondary-700 dark:bg-secondary-700 dark:text-secondary-300",
    success:
        "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300",
    danger: "bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300",
    warning:
        "bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300",
    info: "bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300",
};

const classes = computed(() => ["badge", variantClasses[props.variant]]);
</script>

<template>
    <span :class="classes">
        <slot />
    </span>
</template>
