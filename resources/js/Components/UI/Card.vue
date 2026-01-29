<script setup>
defineProps({
    title: String,
    headerClass: String,
});
</script>

<template>
    <div class="bg-white dark:bg-secondary-800 rounded shadow-card">
        <div
            v-if="title || $slots.header || $slots['header-actions']"
            class="px-6 py-4 border-b border-secondary-100 dark:border-secondary-700 font-semibold text-heading dark:text-white flex items-center justify-between"
            :class="headerClass"
        >
            <slot name="header">
                {{ title }}
            </slot>
            <div
                v-if="$slots['header-actions']"
                class="flex items-center gap-2"
            >
                <slot name="header-actions" />
            </div>
        </div>
        <div class="p-6">
            <slot />
        </div>
        <div
            v-if="$slots.footer"
            class="px-6 py-4 border-t border-secondary-100 dark:border-secondary-700"
        >
            <slot name="footer" />
        </div>
    </div>
</template>
