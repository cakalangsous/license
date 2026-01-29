<script setup>
import { computed } from "vue";
import * as OutlineIcons from "@heroicons/vue/24/outline";
import * as SolidIcons from "@heroicons/vue/24/solid";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "outline", // 'outline' or 'solid'
        validator: (value) => ["outline", "solid"].includes(value),
    },
});

/**
 * Convert kebab-case icon name to PascalCase component name
 * e.g., 'squares-2x2' -> 'Squares2X2Icon'
 */
const toPascalCase = (name) => {
    return (
        name
            .split("-")
            .map((part) => {
                // Handle numeric parts like '2x2' -> '2X2'
                if (/^\d/.test(part)) {
                    return part.toUpperCase();
                }
                return part.charAt(0).toUpperCase() + part.slice(1);
            })
            .join("") + "Icon"
    );
};

/**
 * Get the icon component based on name and type
 */
const iconComponent = computed(() => {
    if (!props.name) return null;

    const componentName = toPascalCase(props.name);
    const icons = props.type === "solid" ? SolidIcons : OutlineIcons;

    return icons[componentName] || null;
});
</script>

<template>
    <component v-if="iconComponent" :is="iconComponent" />
    <svg
        v-else
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"
        />
    </svg>
</template>
