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
    <div class="form-group">
        <label v-if="label" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <select
            :value="multiple ? undefined : internalValue"
            :multiple="multiple"
            :disabled="disabled"
            class="form-control"
            :class="{ 'border-danger focus:ring-danger': error }"
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

        <p v-if="error" class="mt-1 text-sm text-danger">{{ error }}</p>
    </div>
</template>

<style scoped>
/* Style select dropdown options with primary color */
select.form-control {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1rem;
    padding-right: 2.5rem;
}

select.form-control option {
    background-color: var(--color-primary, #6771cf);
    color: white;
    padding: 0.5rem;
}

select.form-control option:checked {
    background-color: var(--color-primary-700, #4a52a0);
}

/* Dark mode */
:root.dark select.form-control,
.dark select.form-control {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
}

:root.dark select.form-control option,
.dark select.form-control option {
    background-color: var(--color-primary-900, #062626);
    color: white;
}
</style>
