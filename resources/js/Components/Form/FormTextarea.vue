<script setup>
const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    error: {
        type: String,
        default: "",
    },
    rows: {
        type: [String, Number],
        default: 4,
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    emit("update:modelValue", event.target.value);
};
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
        <textarea
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            :disabled="disabled"
            :required="required"
            class="block w-full rounded-lg border px-4 py-2.5 text-sm transition-colors duration-200 focus:outline-none focus:ring-2"
            :class="[
                error
                    ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-red-900/20 dark:text-red-400'
                    : 'border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400',
                disabled ? 'cursor-not-allowed opacity-60' : '',
            ]"
            @input="updateValue"
        ></textarea>
        <p v-if="error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </p>
    </div>
</template>
