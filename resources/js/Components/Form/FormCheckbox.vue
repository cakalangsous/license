<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: "",
    },
    description: {
        type: String,
        default: "",
    },
    error: {
        type: String,
        default: "",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const isChecked = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});
</script>

<template>
    <div class="flex items-start gap-3">
        <div class="flex h-6 items-center">
            <input
                type="checkbox"
                v-model="isChecked"
                :disabled="disabled"
                class="h-4 w-4 rounded border-secondary-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition-colors duration-200 dark:border-secondary-600 dark:bg-secondary-800 dark:checked:bg-primary disabled:cursor-not-allowed disabled:opacity-60"
                :class="{
                    'border-red-500': error,
                }"
            />
        </div>
        <div class="leading-6">
            <label
                v-if="label"
                class="text-sm font-medium text-secondary-700 dark:text-secondary-300"
                :class="{ 'cursor-not-allowed opacity-60': disabled }"
            >
                {{ label }}
            </label>
            <p
                v-if="description"
                class="text-sm text-secondary-500 dark:text-secondary-400"
            >
                {{ description }}
            </p>
            <p v-if="error" class="mt-1 text-sm text-red-600 dark:text-red-400">
                {{ error }}
            </p>
        </div>
    </div>
</template>
