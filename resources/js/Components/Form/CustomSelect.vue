<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount, nextTick } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: "",
    },
    label: String,
    options: {
        type: Array,
        default: () => [],
    },
    placeholder: {
        type: String,
        default: "Select an option...",
    },
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
    groupKey: {
        type: String,
        default: "group",
    },
});

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const searchQuery = ref("");
const containerRef = ref(null);
const triggerRef = ref(null);
const dropdownRef = ref(null);
const dropdownStyle = ref({});

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

// Get option group
const getOptionGroup = (option) => {
    if (typeof option === "object") {
        return option[props.groupKey] || null;
    }
    return null;
};

// Get selected label
const selectedLabel = computed(() => {
    if (!props.modelValue && props.modelValue !== 0) return "";
    const option = props.options.find(
        (opt) => getOptionValue(opt) === props.modelValue
    );
    return option ? getOptionLabel(option) : props.modelValue;
});

// Group options if they have group property
const groupedOptions = computed(() => {
    const groups = {};
    const ungrouped = [];

    props.options.forEach((option) => {
        const group = getOptionGroup(option);
        if (group) {
            if (!groups[group]) {
                groups[group] = [];
            }
            groups[group].push(option);
        } else {
            ungrouped.push(option);
        }
    });

    // Return as array of { group, options } or just options for ungrouped
    const result = [];
    if (ungrouped.length > 0) {
        result.push({ group: null, options: ungrouped });
    }
    Object.keys(groups).forEach((groupName) => {
        result.push({ group: groupName, options: groups[groupName] });
    });

    return result;
});

// Filter options based on search
const filteredGroupedOptions = computed(() => {
    if (!searchQuery.value) return groupedOptions.value;

    const query = searchQuery.value.toLowerCase();
    return groupedOptions.value
        .map((group) => ({
            ...group,
            options: group.options.filter((opt) =>
                getOptionLabel(opt).toLowerCase().includes(query)
            ),
        }))
        .filter((group) => group.options.length > 0);
});

// Select option
const selectOption = (option) => {
    const value = getOptionValue(option);
    emit("update:modelValue", value);
    isOpen.value = false;
    searchQuery.value = "";
};

// Check if option is selected
const isSelected = (option) => {
    return getOptionValue(option) === props.modelValue;
};

// Update dropdown position
const updateDropdownPosition = () => {
    if (!triggerRef.value) return;
    
    const rect = triggerRef.value.getBoundingClientRect();
    const dropdownHeight = 250; // approximate max height
    const spaceBelow = window.innerHeight - rect.bottom;
    const spaceAbove = rect.top;
    
    // Determine if dropdown should open upward
    const openUpward = spaceBelow < dropdownHeight && spaceAbove > spaceBelow;
    
    dropdownStyle.value = {
        position: 'fixed',
        left: `${rect.left}px`,
        width: `${rect.width}px`,
        zIndex: 9999,
        ...(openUpward
            ? { bottom: `${window.innerHeight - rect.top + 4}px` }
            : { top: `${rect.bottom + 4}px` }
        ),
    };
};

// Toggle dropdown
const toggleDropdown = () => {
    if (!props.disabled) {
        isOpen.value = !isOpen.value;
        if (isOpen.value) {
            searchQuery.value = "";
            nextTick(() => {
                updateDropdownPosition();
            });
        }
    }
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (containerRef.value && !containerRef.value.contains(event.target)) {
        // Also check if click is inside the teleported dropdown
        if (dropdownRef.value && dropdownRef.value.contains(event.target)) {
            return;
        }
        isOpen.value = false;
    }
};

// Handle scroll and resize to update position
const handleScrollOrResize = () => {
    if (isOpen.value) {
        updateDropdownPosition();
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
    window.addEventListener("scroll", handleScrollOrResize, true);
    window.addEventListener("resize", handleScrollOrResize);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
    window.removeEventListener("scroll", handleScrollOrResize, true);
    window.removeEventListener("resize", handleScrollOrResize);
});
</script>

<template>
    <div class="custom-select-wrapper" ref="containerRef">
        <label v-if="label" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <div class="custom-select-container">
            <button
                ref="triggerRef"
                type="button"
                @click="toggleDropdown"
                class="custom-select-trigger"
                :class="{
                    'custom-select-error': error,
                    'custom-select-disabled': disabled,
                    'custom-select-open': isOpen,
                }"
                :disabled="disabled"
            >
                <span
                    :class="
                        selectedLabel
                            ? 'custom-select-value'
                            : 'custom-select-placeholder'
                    "
                >
                    {{ selectedLabel || placeholder }}
                </span>
                <svg
                    class="custom-select-arrow"
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
            </button>

            <!-- Dropdown - Teleported to body to escape overflow containers -->
            <Teleport to="body">
                <div 
                    v-show="isOpen" 
                    ref="dropdownRef"
                    class="custom-select-dropdown"
                    :style="dropdownStyle"
                    @click.stop
                >
                <!-- Search input -->
                <div class="custom-select-search-wrapper">
                    <input
                        v-model="searchQuery"
                        type="text"
                        class="custom-select-search"
                        placeholder="Search..."
                        @click.stop
                    />
                </div>

                <!-- Options -->
                <div class="custom-select-options">
                    <template
                        v-for="(group, gIndex) in filteredGroupedOptions"
                        :key="gIndex"
                    >
                        <!-- Group header -->
                        <div
                            v-if="group.group"
                            class="custom-select-group-header"
                        >
                            {{ group.group }}
                        </div>

                        <!-- Options in group -->
                        <div
                            v-for="option in group.options"
                            :key="getOptionValue(option)"
                            class="custom-select-option"
                            :class="{
                                'custom-select-option-selected':
                                    isSelected(option),
                            }"
                            @click="selectOption(option)"
                        >
                            {{ getOptionLabel(option) }}
                            <svg
                                v-if="isSelected(option)"
                                class="custom-select-check"
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
                        </div>
                    </template>

                    <!-- No results -->
                    <div
                        v-if="filteredGroupedOptions.length === 0"
                        class="custom-select-no-results"
                    >
                        No options found
                    </div>
                </div>
            </div>
            </Teleport>
        </div>

        <p v-if="error" class="mt-1 text-sm text-danger">{{ error }}</p>
    </div>
</template>

<style>
/* Note: Not scoped because dropdown is teleported to body */
.custom-select-wrapper {
    position: relative;
}

.custom-select-container {
    position: relative;
}

.custom-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 36px;
    padding: 0.375rem 0.625rem;
    background-color: white;
    border: 1px solid var(--color-secondary-200, #d1d5db);
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
    font-size: 0.8125rem;
}

.custom-select-trigger:hover {
    border-color: var(--color-secondary-400, #9ca3af);
}

.custom-select-open {
    border-color: var(--color-primary, #6771cf);
    box-shadow: 0 0 0 2px rgba(103, 113, 207, 0.2);
}

.custom-select-error {
    border-color: #dc3545;
}

.custom-select-disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
    opacity: 0.7;
}

.custom-select-value {
    color: var(--color-body-text, #374151);
}

.custom-select-placeholder {
    color: var(--color-secondary-400, #9ca3af);
    font-size: 0.8125rem;
}

.custom-select-arrow {
    width: 0.875rem;
    height: 0.875rem;
    color: var(--color-secondary-400, #6b7280);
    transition: transform 0.2s;
    flex-shrink: 0;
}

.custom-select-dropdown {
    background-color: white;
    border: 1px solid var(--color-secondary-200, #e5e7eb);
    border-radius: 0.375rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
        0 8px 10px -6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.custom-select-search-wrapper {
    padding: 0.375rem;
    border-bottom: 1px solid var(--color-secondary-200, #e5e7eb);
    background-color: var(--color-secondary-50, #f9fafb);
}

.custom-select-search {
    width: 100%;
    padding: 0.375rem 0.625rem;
    font-size: 0.8125rem;
    border: 1px solid var(--color-secondary-300, #d1d5db);
    border-radius: 0.25rem;
    background-color: white;
    color: var(--color-body-text, #374151);
}

.custom-select-search:focus {
    outline: none;
    border-color: var(--color-primary, #6771cf);
    box-shadow: 0 0 0 2px rgba(103, 113, 207, 0.1);
}

.custom-select-options {
    max-height: 200px;
    overflow-y: auto;
}

.custom-select-group-header {
    padding: 0.375rem 0.625rem;
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--color-secondary-500, #6b7280);
    background-color: var(--color-secondary-100, #f3f4f6);
}

.custom-select-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.625rem;
    cursor: pointer;
    transition: background-color 0.15s;
    color: var(--color-body-text, #374151);
    font-size: 0.8125rem;
}

.custom-select-option:hover {
    background-color: var(--color-primary-50, #f0f1f9);
}

.custom-select-option-selected {
    background-color: var(--color-primary-100, #e1e3f4);
    color: var(--color-primary-700, #3e447e);
}

.custom-select-option-selected:hover {
    background-color: var(--color-primary-100, #e1e3f4);
}

.custom-select-check {
    width: 0.875rem;
    height: 0.875rem;
    color: var(--color-primary, #6771cf);
}

.custom-select-no-results {
    padding: 0.625rem;
    text-align: center;
    color: var(--color-secondary-500, #6b7280);
    font-size: 0.8125rem;
}

/* Dark mode styles */
:root.dark .custom-select-trigger,
.dark .custom-select-trigger {
    background-color: var(--color-secondary-800, #1f2937);
    border-color: var(--color-secondary-600, #4b5563);
    color: white;
}

:root.dark .custom-select-trigger:hover,
.dark .custom-select-trigger:hover {
    border-color: var(--color-secondary-500, #6b7280);
}

:root.dark .custom-select-value,
.dark .custom-select-value {
    color: white;
}

:root.dark .custom-select-disabled,
.dark .custom-select-disabled {
    background-color: var(--color-secondary-700, #374151);
}

:root.dark .custom-select-dropdown,
.dark .custom-select-dropdown {
    background-color: var(--color-secondary-800, #1f2937);
    border-color: var(--color-secondary-600, #4b5563);
}

:root.dark .custom-select-search-wrapper,
.dark .custom-select-search-wrapper {
    background-color: var(--color-secondary-900, #111827);
    border-color: var(--color-secondary-700, #374151);
}

:root.dark .custom-select-search,
.dark .custom-select-search {
    background-color: var(--color-secondary-800, #1f2937);
    border-color: var(--color-secondary-600, #4b5563);
    color: white;
}

:root.dark .custom-select-search:focus,
.dark .custom-select-search:focus {
    border-color: var(--color-primary, #6771cf);
}

:root.dark .custom-select-group-header,
.dark .custom-select-group-header {
    background-color: var(--color-secondary-900, #111827);
    color: var(--color-secondary-400, #9ca3af);
}

:root.dark .custom-select-option,
.dark .custom-select-option {
    color: var(--color-secondary-200, #e5e7eb);
}

:root.dark .custom-select-option:hover,
.dark .custom-select-option:hover {
    background-color: var(--color-secondary-700, #374151);
}

:root.dark .custom-select-option-selected,
.dark .custom-select-option-selected {
    background-color: var(--color-primary-900, #15172a);
    color: var(--color-primary-300, #a5abde);
}

:root.dark .custom-select-option-selected:hover,
.dark .custom-select-option-selected:hover {
    background-color: var(--color-primary-900, #15172a);
}

:root.dark .custom-select-check,
.dark .custom-select-check {
    color: var(--color-primary-400, #878fd3);
}

:root.dark .custom-select-no-results,
.dark .custom-select-no-results {
    color: var(--color-secondary-400, #9ca3af);
}
</style>
