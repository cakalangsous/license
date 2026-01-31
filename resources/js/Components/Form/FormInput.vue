<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    type: {
        type: String,
        default: "text",
    },
    placeholder: String,
    error: String,
    hint: String,
    required: Boolean,
    disabled: Boolean,
    readonly: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

const inputValue = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const inputClasses = computed(() => [
    "form-control",
    { "border-danger focus:ring-danger": props.error },
]);
</script>

<template>
    <div>
        <label
            v-if="label"
            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <input
            v-model="inputValue"
            :type="type"
            :placeholder="placeholder"
            :disabled="disabled"
            :readonly="readonly"
            class="block w-full rounded-lg border px-4 py-2.5 text-sm transition-colors duration-200 focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60"
            :class="[
                error
                    ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-red-900/20 dark:text-red-400'
                    : 'border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500/20 dark:border-secondary-600 dark:bg-secondary-800 dark:text-white dark:placeholder-secondary-400',
            ]"
        />

        <p v-if="error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </p>
        <p
            v-else-if="hint"
            class="mt-1 text-sm text-gray-500 dark:text-gray-400"
        >
            {{ hint }}
        </p>
    </div>
</template>
