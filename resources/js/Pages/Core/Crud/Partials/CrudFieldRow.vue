<script setup>
import { ref, watch, computed, onMounted } from "vue";
import crud from "@/routes/admin/crud";
import Button from "@/Components/UI/Button.vue";
import CustomSelect from "@/Components/Form/CustomSelect.vue";
import {
    Bars2Icon,
    XMarkIcon,
    PlusIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    index: Number,
    field: Object, // { field_name, field_type, default_value, defined_value, input_type, validations: [], table_ref, ... }
    inputTypes: Array,
    allValidations: Array, // All validations passed as prop from controller
    availableTables: {
        type: Array,
        default: () => [],
    },
    canDelete: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["update:field", "remove"]);

const localField = ref({ ...props.field });

// Table columns for the selected table reference
const tableColumns = ref([]);
const loadingColumns = ref(false);

// Check if input type requires table reference (has_relation types)
const needsTableRef = computed(() => {
    if (!localField.value.input_type) return false;
    const typeObj = props.inputTypes.find(
        (t) => t.id == localField.value.input_type,
    );
    if (!typeObj) return false;
    return ["select", "select_multiple", "checkboxes", "radio"].includes(
        typeObj.type,
    );
});

// Check if input type requires custom options (custom_value types)
const needsCustomOptions = computed(() => {
    if (!localField.value.input_type) return false;
    const typeObj = props.inputTypes.find(
        (t) => t.id == localField.value.input_type,
    );
    if (!typeObj) return false;
    return [
        "custom_select",
        "custom_select_multiple",
        "custom_checkbox",
        "custom_radio",
    ].includes(typeObj.type);
});

// Initialize custom_options if not exists
if (!localField.value.custom_options) {
    localField.value.custom_options = [];
}

// Watch for input type changes to add default option for custom types
watch(
    () => localField.value.input_type,
    (newTypeId) => {
        if (!newTypeId) return;
        const typeObj = props.inputTypes.find((t) => t.id == newTypeId);
        if (
            typeObj &&
            [
                "custom_select",
                "custom_select_multiple",
                "custom_checkbox",
                "custom_radio",
            ].includes(typeObj.type)
        ) {
            // Add a default empty option if none exist
            if (
                !localField.value.custom_options ||
                localField.value.custom_options.length === 0
            ) {
                localField.value.custom_options = [{ value: "", label: "" }];
            }
        }
    },
);

// Add a new custom option
const addCustomOption = () => {
    localField.value.custom_options.push({
        value: "",
        label: "",
    });
};

// Remove a custom option
const removeCustomOption = (index) => {
    localField.value.custom_options.splice(index, 1);
};

// Fetch table columns when table_ref changes
const fetchTableColumns = async (tableName) => {
    if (!tableName) {
        tableColumns.value = [];
        return;
    }

    loadingColumns.value = true;
    try {
        const response = await fetch(`/admin/crud/table-columns/${tableName}`);
        const data = await response.json();
        if (data.status === "success") {
            tableColumns.value = data.columns;
        }
    } catch (error) {
        console.error("Failed to fetch table columns:", error);
        tableColumns.value = [];
    } finally {
        loadingColumns.value = false;
    }
};

// Watch for table_ref changes to fetch columns
watch(
    () => localField.value.table_ref,
    (newTable) => {
        if (newTable) {
            fetchTableColumns(newTable);
        } else {
            tableColumns.value = [];
            // Clear dependent fields
            localField.value.value_field_ref = "";
            localField.value.label_field_ref = "";
            localField.value.where_field_ref = "";
        }
    },
);

// Load columns on mount if table_ref already has value
onMounted(() => {
    if (localField.value.table_ref) {
        fetchTableColumns(localField.value.table_ref);
    }
});

// Clear where field ref
const clearWhereField = () => {
    localField.value.where_field_ref = "";
};

// Watch for changes and emit update
watch(
    localField,
    (newVal) => {
        emit("update:field", newVal);
    },
    { deep: true },
);

// Validations options (filtered from props based on selected input type)
const validationOptions = computed(() => {
    const typeId = localField.value.input_type;
    if (!typeId || !props.allValidations) return [];

    // Find type name from ID
    const typeObj = props.inputTypes.find((t) => t.id == typeId);
    if (!typeObj) return [];

    // Filter validations that contain this input type in their input_group
    return props.allValidations.filter((v) => {
        if (!v.input_group) return false;
        const groups = v.input_group.split(",").map((g) => g.trim());
        return groups.includes(typeObj.type);
    });
});

// Validation management
const selectedValidation = ref("");

const addValidation = () => {
    if (!selectedValidation.value) return;

    const validId = selectedValidation.value;
    const validObj = validationOptions.value.find((v) => v.id == validId);
    if (!validObj) return;

    // Check if already exists
    if (localField.value.validations.some((v) => v.id == validId)) return;

    localField.value.validations.push({
        id: validId,
        validation: validObj.validation,
        is_input_able: validObj.is_input_able,
        placeholder: validObj.input_placeholder,
        value: "", // For input-able validations
    });

    selectedValidation.value = "";
};

const removeValidation = (index) => {
    localField.value.validations.splice(index, 1);
};

// DB Type options with groups
const dbTypeOptions = [
    { value: "string", label: "string", group: "Common" },
    { value: "text", label: "text", group: "Common" },
    { value: "date", label: "date", group: "Common" },
    { value: "boolean", label: "boolean", group: "Common" },
    { value: "integer", label: "integer", group: "Common" },
    { value: "longText", label: "longText", group: "Common" },
    { value: "bigIncrements", label: "bigIncrements", group: "Other" },
    { value: "bigInteger", label: "bigInteger", group: "Other" },
    { value: "binary", label: "binary", group: "Other" },
    { value: "char", label: "char", group: "Other" },
    { value: "dateTime", label: "dateTime", group: "Other" },
    { value: "decimal", label: "decimal", group: "Other" },
    { value: "double", label: "double", group: "Other" },
    { value: "enum", label: "enum", group: "Other" },
    { value: "float", label: "float", group: "Other" },
    { value: "foreignId", label: "foreignId", group: "Other" },
    { value: "json", label: "json", group: "Other" },
    { value: "mediumText", label: "mediumText", group: "Other" },
    { value: "smallInteger", label: "smallInteger", group: "Other" },
    { value: "time", label: "time", group: "Other" },
    { value: "timestamp", label: "timestamp", group: "Other" },
    { value: "tinyInteger", label: "tinyInteger", group: "Other" },
    {
        value: "unsignedBigInteger",
        label: "unsignedBigInteger",
        group: "Other",
    },
    { value: "unsignedInteger", label: "unsignedInteger", group: "Other" },
    { value: "uuid", label: "uuid", group: "Other" },
];

// Default value options
const defaultValueOptions = [
    { value: "none", label: "none" },
    { value: "null", label: "null" },
    { value: "as_defined", label: "as defined" },
];

// Helper to format snake_case to Title Case
const formatLabel = (str) => {
    return str
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
};

// Input type options (computed from prop)
const inputTypeOptions = computed(() => {
    return props.inputTypes.map((type) => ({
        value: type.id,
        label: formatLabel(type.type),
    }));
});

// Validation options formatted for CustomSelect
const validationSelectOptions = computed(() => {
    return validationOptions.value.map((v) => ({
        value: v.id,
        label: v.validation,
    }));
});

// Handle validation selection
const onValidationSelect = (value) => {
    if (!value) return;
    selectedValidation.value = value;
    addValidation();
};
</script>

<template>
    <tr
        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50"
    >
        <!-- Drag Handle -->
        <td class="px-2 py-3 align-top">
            <div
                class="drag-handle cursor-grab active:cursor-grabbing p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                title="Drag to reorder"
            >
                <Bars2Icon class="w-5 h-5 text-gray-400" />
            </div>
        </td>

        <!-- Field Name -->
        <td class="px-3 py-3 align-top">
            <input
                v-model="localField.field_name"
                type="text"
                class="w-full px-3 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="field_name"
            />
        </td>

        <!-- DB Type -->
        <td class="px-3 py-3 align-top">
            <CustomSelect
                v-model="localField.field_type"
                :options="dbTypeOptions"
                placeholder="Select type..."
            />
        </td>

        <!-- Default Value -->
        <td class="px-3 py-3 align-top">
            <CustomSelect
                v-model="localField.default_value"
                :options="defaultValueOptions"
                placeholder="Select default..."
            />
            <input
                v-if="localField.default_value === 'as_defined'"
                v-model="localField.defined_value"
                type="text"
                class="w-full mt-2 px-3 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Value"
            />
        </td>

        <!-- HTML Input Type -->
        <td class="px-3 py-3 align-top">
            <CustomSelect
                v-model="localField.input_type"
                :options="inputTypeOptions"
                placeholder="Select type..."
            />
            <!-- Table Reference (for select/select_multiple) -->
            <div v-if="needsTableRef" class="mt-2 space-y-2">
                <div>
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1"
                        >Model Ref</label
                    >
                    <CustomSelect
                        v-model="localField.table_ref"
                        :options="availableTables"
                        placeholder="Select Table"
                    />
                </div>

                <!-- Value Field Ref -->
                <div v-if="localField.table_ref">
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1"
                        >Value Field Ref</label
                    >
                    <CustomSelect
                        v-model="localField.value_field_ref"
                        :options="tableColumns"
                        :disabled="loadingColumns"
                        placeholder="Select Value Field"
                    />
                </div>

                <!-- Label Field Ref -->
                <div v-if="localField.table_ref">
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1"
                        >Label Field Ref</label
                    >
                    <CustomSelect
                        v-model="localField.label_field_ref"
                        :options="tableColumns"
                        :disabled="loadingColumns"
                        placeholder="Select Label Field"
                    />
                </div>

                <!-- Where Field Ref -->
                <div v-if="localField.table_ref">
                    <label
                        class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1"
                        >Where</label
                    >
                    <div class="flex items-center gap-1">
                        <div class="flex-1">
                            <CustomSelect
                                v-model="localField.where_field_ref"
                                :options="tableColumns"
                                :disabled="loadingColumns"
                                placeholder="Select Field"
                            />
                        </div>
                        <button
                            v-if="localField.where_field_ref"
                            type="button"
                            @click="clearWhereField"
                            class="p-1.5 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors"
                            title="Clear"
                        >
                            <XMarkIcon class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Custom Options (for custom_select/custom_select_multiple) -->
            <div v-if="needsCustomOptions" class="mt-2 space-y-2">
                <!-- Options List -->
                <div
                    v-for="(option, optIndex) in localField.custom_options"
                    :key="optIndex"
                    class="flex items-center gap-1"
                >
                    <div class="flex-1 flex gap-1">
                        <input
                            v-model="option.value"
                            type="text"
                            class="w-16 px-1.5 py-1 text-xs text-gray-900 border border-gray-300 rounded bg-white focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                            placeholder="Value"
                        />
                        <input
                            v-model="option.label"
                            type="text"
                            class="flex-1 px-1.5 py-1 text-xs text-gray-900 border border-gray-300 rounded bg-white focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                            placeholder="Label"
                        />
                    </div>
                    <button
                        v-if="optIndex > 0"
                        type="button"
                        @click="removeCustomOption(optIndex)"
                        class="p-1 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                        title="Remove option"
                    >
                        <XMarkIcon class="w-4 h-4" />
                    </button>
                    <div v-else class="w-6"></div>
                </div>

                <!-- Add Option Button -->
                <button
                    type="button"
                    @click="addCustomOption"
                    class="w-full flex items-center justify-center gap-1 px-3 py-2 text-xs font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                >
                    <PlusIcon class="w-4 h-4" />
                    Add New Option
                </button>
            </div>
        </td>

        <!-- Validations -->
        <td class="px-3 py-3 align-top min-w-[180px]">
            <CustomSelect
                :model-value="selectedValidation"
                @update:model-value="onValidationSelect"
                :options="validationSelectOptions"
                placeholder="Add validation..."
            />
            <!-- Selected Validations List -->
            <div
                v-if="localField.validations.length > 0"
                class="mt-2 space-y-1"
            >
                <div
                    v-for="(v, vIndex) in localField.validations"
                    :key="vIndex"
                    class="flex items-center gap-2 text-xs bg-primary-50 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300 px-2 py-1.5 rounded-md"
                >
                    <span class="font-medium">{{ v.validation }}</span>
                    <input
                        v-if="v.is_input_able"
                        v-model="v.value"
                        :placeholder="v.placeholder || 'Value'"
                        class="w-16 px-1 py-0.5 text-xs border border-primary-300 dark:border-primary-600 rounded bg-white dark:bg-gray-800 focus:ring-1 focus:ring-primary-500"
                    />
                    <button
                        type="button"
                        @click="removeValidation(vIndex)"
                        class="ml-auto text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                    >
                        <XMarkIcon class="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>
        </td>

        <!-- Checkbox columns with mini toggles -->
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.row_create_page"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.row_edit_page"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.row_list_page"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.row_details_page"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.searchable"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>
        <td class="px-3 py-3 align-top text-center">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    v-model="localField.sortable"
                    class="sr-only peer"
                />
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                ></div>
            </label>
        </td>

        <!-- Delete -->
        <td class="px-3 py-3 align-top text-center">
            <button
                v-if="canDelete"
                type="button"
                @click="$emit('remove')"
                class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors"
            >
                <TrashIcon class="w-4 h-4" />
            </button>
        </td>
    </tr>
</template>
