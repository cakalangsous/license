<script setup>
import { computed, ref, watch } from "vue";

const props = defineProps({
    modelValue: [String, Number, Array],
    label: String,
    options: {
        type: Array,
        default: () => [],
    },
    multiple: Boolean,
    placeholder: String,
    error: String,
    required: Boolean,
    disabled: Boolean,
    valueKey: {
        type: String,
        default: "value",
    },
    labelKey: {
        type: String,
        default: "label",
    },
});

const emit = defineEmits(["update:modelValue"]);

// For multiple select, we need to handle the value as array
const internalValue = computed({
    get() {
        if (props.multiple) {
            // Ensure we always return an array for multiple select
            return Array.isArray(props.modelValue) ? props.modelValue : [];
        }
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const getOptionValue = (option) => {
    if (typeof option === "object") {
        return option[props.valueKey];
    }
    return option;
};

const getOptionLabel = (option) => {
    if (typeof option === "object") {
        return option[props.labelKey];
    }
    return option;
};

// Handle select change for multiple select
const handleChange = (event) => {
    if (props.multiple) {
        // Get all selected options and extract their values
        const selectedOptions = Array.from(event.target.selectedOptions);
        const values = selectedOptions.map((opt) => {
            // Parse as number if it looks like a number (for IDs)
            const val = opt.value;
            return isNaN(val) ? val : Number(val);
        });
        emit("update:modelValue", values);
    } else {
        const val = event.target.value;
        // Parse as number if it looks like a number
        emit("update:modelValue", isNaN(val) || val === "" ? val : Number(val));
    }
};

// Check if an option is selected (for multiple select)
const isSelected = (optionValue) => {
    if (props.multiple && Array.isArray(props.modelValue)) {
        return props.modelValue.includes(optionValue);
    }
    return props.modelValue === optionValue;
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

        <div class="relative">
            <select
                :value="multiple ? undefined : internalValue"
                :multiple="multiple"
                :disabled="disabled"
                class="block w-full appearance-none rounded-lg border px-4 py-2.5 pr-10 text-sm transition-colors duration-200 focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:opacity-60"
                :class="[
                    error
                        ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-red-900/20 dark:text-red-400'
                        : 'border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500/20 dark:border-secondary-600 dark:bg-secondary-800 dark:text-white dark:placeholder-secondary-400',
                    multiple ? 'p-2' : '',
                ]"
                @change="handleChange"
            >
                <option v-if="placeholder && !multiple" value="">
                    {{ placeholder }}
                </option>
                <option
                    v-for="option in options"
                    :key="getOptionValue(option)"
                    :value="getOptionValue(option)"
                    :selected="isSelected(getOptionValue(option))"
                >
                    {{ getOptionLabel(option) }}
                </option>
            </select>
            <div
                v-if="!multiple"
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300"
            >
                <svg
                    class="h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </div>

        <p v-if="error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </p>
    </div>
</template>
