<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    label: String,
    options: {
        type: Array,
        default: () => [],
    },
    placeholder: {
        type: String,
        default: "Select options...",
    },
    error: String,
    required: Boolean,
    disabled: Boolean,
    valueKey: {
        type: String,
        default: "id",
    },
    labelKey: {
        type: String,
        default: "name",
    },
    searchable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const searchQuery = ref("");
const containerRef = ref(null);

// Get selected values as array
const selectedValues = computed(() => {
    return Array.isArray(props.modelValue) ? props.modelValue : [];
});

// Get option value
const getOptionValue = (option) => {
    if (typeof option === "object") {
        return option[props.valueKey];
    }
    return option;
};

// Get option label
const getOptionLabel = (option) => {
    if (typeof option === "object") {
        return option[props.labelKey];
    }
    return option;
};

// Get label for a selected value
const getSelectedLabel = (value) => {
    const option = props.options.find((opt) => getOptionValue(opt) === value);
    return option ? getOptionLabel(option) : value;
};

// Check if option is selected
const isSelected = (option) => {
    return selectedValues.value.includes(getOptionValue(option));
};

// Filter options based on search query
const filteredOptions = computed(() => {
    if (!searchQuery.value) return props.options;
    const query = searchQuery.value.toLowerCase();
    return props.options.filter((option) =>
        getOptionLabel(option).toLowerCase().includes(query)
    );
});

// Toggle option selection
const toggleOption = (option) => {
    const value = getOptionValue(option);
    const newValues = [...selectedValues.value];
    const index = newValues.indexOf(value);

    if (index === -1) {
        newValues.push(value);
    } else {
        newValues.splice(index, 1);
    }

    emit("update:modelValue", newValues);
};

// Remove a selected tag
const removeTag = (value, event) => {
    event.stopPropagation();
    const newValues = selectedValues.value.filter((v) => v !== value);
    emit("update:modelValue", newValues);
};

// Toggle dropdown
const toggleDropdown = () => {
    if (!props.disabled) {
        isOpen.value = !isOpen.value;
        if (isOpen.value) {
            searchQuery.value = "";
        }
    }
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (containerRef.value && !containerRef.value.contains(event.target)) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <div class="form-group" ref="containerRef">
        <label v-if="label" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <div class="multiselect-wrapper">
            <div
                class="multiselect-container"
                :class="{
                    'multiselect-error': error,
                    'multiselect-disabled': disabled,
                    'multiselect-open': isOpen,
                }"
                @click="toggleDropdown"
            >
                <!-- Selected Tags -->
                <div class="multiselect-tags">
                    <span
                        v-for="value in selectedValues"
                        :key="value"
                        class="multiselect-tag"
                    >
                        {{ getSelectedLabel(value) }}
                        <button
                            type="button"
                            class="multiselect-tag-remove"
                            @click="removeTag(value, $event)"
                            :disabled="disabled"
                        >
                            <svg
                                class="w-3 h-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </span>

                    <!-- Placeholder or Search Input -->
                    <input
                        v-if="searchable && isOpen"
                        v-model="searchQuery"
                        type="text"
                        class="multiselect-search"
                        :placeholder="
                            selectedValues.length === 0 ? placeholder : ''
                        "
                        @click.stop
                    />
                    <span
                        v-else-if="selectedValues.length === 0"
                        class="multiselect-placeholder"
                    >
                        {{ placeholder }}
                    </span>
                </div>

                <!-- Dropdown Arrow -->
                <div class="multiselect-arrow">
                    <svg
                        class="w-4 h-4 transition-transform"
                        :class="{ 'rotate-180': isOpen }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </div>
            </div>

            <!-- Dropdown Options -->
            <div v-show="isOpen" class="multiselect-dropdown">
                <div
                    v-if="filteredOptions.length === 0"
                    class="multiselect-no-results"
                >
                    No options found
                </div>
                <div
                    v-for="option in filteredOptions"
                    :key="getOptionValue(option)"
                    class="multiselect-option"
                    :class="{
                        'multiselect-option-selected': isSelected(option),
                    }"
                    @click.stop="toggleOption(option)"
                >
                    <span class="multiselect-checkbox">
                        <svg
                            v-if="isSelected(option)"
                            class="w-4 h-4 text-primary"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </span>
                    {{ getOptionLabel(option) }}
                </div>
            </div>
        </div>

        <p v-if="error" class="mt-1 text-sm text-danger">{{ error }}</p>
    </div>
</template>

<style scoped>
.multiselect-wrapper {
    position: relative;
}

.multiselect-container {
    display: flex;
    align-items: center;
    min-height: 42px;
    padding: 0.375rem 0.75rem;
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s;
}

.multiselect-container:hover {
    border-color: #9ca3af;
}

.multiselect-open {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 2px rgba(31, 189, 189, 0.2);
}

.multiselect-error {
    border-color: #dc3545;
}

.multiselect-disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
    opacity: 0.7;
}

.multiselect-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
    flex: 1;
    align-items: center;
}

.multiselect-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    background-color: var(--color-primary-100, #b3ebeb);
    color: var(--color-primary-800, #0c4c4c);
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.multiselect-tag-remove {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.125rem;
    margin-left: 0.125rem;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--color-primary-600, #199797);
    border-radius: 0.125rem;
    transition: all 0.15s;
}

.multiselect-tag-remove:hover {
    background-color: var(--color-primary-200, #8ce1e1);
    color: var(--color-primary-800, #0c4c4c);
}

.multiselect-placeholder {
    color: #9ca3af;
}

.multiselect-search {
    flex: 1;
    min-width: 80px;
    border: none;
    outline: none;
    background: transparent;
    font-size: 0.875rem;
}

.multiselect-arrow {
    display: flex;
    align-items: center;
    padding-left: 0.5rem;
    color: #6b7280;
}

.multiselect-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 50;
    margin-top: 0.25rem;
    max-height: 200px;
    overflow-y: auto;
    background-color: var(--color-primary, #6771cf);
    border: 1px solid var(--color-primary-600, #525ba8);
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
        0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.multiselect-option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 0.75rem;
    cursor: pointer;
    transition: background-color 0.15s;
    color: white;
}

.multiselect-option:hover {
    background-color: var(--color-primary-600, #525ba8);
}

.multiselect-option-selected {
    background-color: var(--color-primary-700, #4a52a0);
}

.multiselect-option-selected:hover {
    background-color: var(--color-primary-800, #3d4485);
}

.multiselect-checkbox {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1rem;
    height: 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    background-color: white;
}

.multiselect-option-selected .multiselect-checkbox {
    background-color: var(--color-primary, #6771cf);
    border-color: var(--color-primary, #6771cf);
}

.multiselect-option-selected .multiselect-checkbox svg {
    color: white;
}

.multiselect-no-results {
    padding: 0.75rem;
    text-align: center;
    color: #6b7280;
    font-size: 0.875rem;
}

/* Dark mode styles */
:root.dark .multiselect-container,
.dark .multiselect-container {
    background-color: #1f2937;
    border-color: #4b5563;
    color: white;
}

:root.dark .multiselect-container:hover,
.dark .multiselect-container:hover {
    border-color: #6b7280;
}

:root.dark .multiselect-tag,
.dark .multiselect-tag {
    background-color: var(--color-primary-800, #0c4c4c);
    color: var(--color-primary-100, #b3ebeb);
}

:root.dark .multiselect-tag-remove,
.dark .multiselect-tag-remove {
    color: var(--color-primary-300, #66d7d7);
}

:root.dark .multiselect-tag-remove:hover,
.dark .multiselect-tag-remove:hover {
    background-color: var(--color-primary-700, #137171);
    color: white;
}

:root.dark .multiselect-placeholder,
.dark .multiselect-placeholder {
    color: #9ca3af;
}

:root.dark .multiselect-search,
.dark .multiselect-search {
    color: white;
}

:root.dark .multiselect-dropdown,
.dark .multiselect-dropdown {
    background-color: var(--color-primary-900, #062626);
    border-color: var(--color-primary-700, #137171);
}

:root.dark .multiselect-option:hover,
.dark .multiselect-option:hover {
    background-color: var(--color-primary-800, #0c4c4c);
}

:root.dark .multiselect-option-selected,
.dark .multiselect-option-selected {
    background-color: var(--color-primary-900, #062626);
}

:root.dark .multiselect-option-selected:hover,
.dark .multiselect-option-selected:hover {
    background-color: var(--color-primary-800, #0c4c4c);
}

:root.dark .multiselect-checkbox,
.dark .multiselect-checkbox {
    border-color: #6b7280;
    background-color: #374151;
}

:root.dark .multiselect-disabled,
.dark .multiselect-disabled {
    background-color: #374151;
}
</style>
