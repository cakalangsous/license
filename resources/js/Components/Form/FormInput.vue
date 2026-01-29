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
            class="w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white dark:placeholder-gray-400 disabled:bg-gray-100 dark:disabled:bg-secondary-700"
            :class="{
                'border-red-500 focus:border-red-500 focus:ring-red-500': error,
            }"
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
