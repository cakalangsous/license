<script setup>
import { ref, reactive } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import CustomSelect from "@/Components/Form/CustomSelect.vue";
import CrudFieldRow from "@/Pages/Core/Crud/Partials/CrudFieldRow.vue";
import { useToast } from "vue-toastification";
import crud from "@/routes/admin/crud";
import draggable from "vuedraggable";
import {
    InformationCircleIcon,
    PlusIcon,
    CheckIcon,
} from "@heroicons/vue/24/solid";

const props = defineProps({
    title: {
        type: String,
        default: "Create CRUD",
    },
    input_types: {
        type: Array,
        default: () => [],
    },
    all_validations: {
        type: Array,
        default: () => [],
    },
    available_tables: {
        type: Array,
        default: () => [],
    },
});

const toast = useToast();

const modelName = ref("");
const tableName = ref("");
const builderOption = ref("generate_crud");
const softDeletes = ref(false);
const pages = reactive({
    create: true,
    edit: true,
    show: true,
});

const fields = ref([]);

let fieldIdCounter = 0;

const addField = () => {
    fields.value.push({
        _id: ++fieldIdCounter,
        field_name: "",
        field_type: "string",
        default_value: "none",
        defined_value: "",
        input_type: "",
        table_ref: "",
        value_field_ref: "",
        label_field_ref: "",
        where_field_ref: "",
        custom_options: [],
        validations: [],
        row_create_page: true,
        row_edit_page: true,
        row_list_page: true,
        row_details_page: true,
        searchable: true,
        sortable: true,
    });
};

// Add initial field
if (fields.value.length === 0) {
    addField();
}

// Auto-fill table name
const onModelNameInput = () => {
    if (modelName.value) {
        tableName.value =
            modelName.value.toLowerCase().replace(/\s+/g, "_") + "s";
    }
};

const form = useForm({
    model_name: "",
    table_name: "",
    builder_options: "generate_crud",
    soft_deletes: false,
    create_page: true,
    edit_page: true,
    show_page: true,
    // Arrays will be populated in submit
    field_name: [],
    field_type: [],
    default_value: [],
    defined_value: [],
    input_type: [],
    row_create_page: [],
    row_edit_page: [],
    row_list_page: [],
    row_details_page: [],
    searchable: [],
    sortable: [],
    validations: [],
    table_ref: [],
    value_field_ref: [],
    label_field_ref: [],
    where_field_ref: [],
    custom_options: [],
});

const validateForm = () => {
    // Validate model name
    if (!modelName.value || !modelName.value.trim()) {
        toast.error("Model name is required");
        return false;
    }

    // Validate table name
    if (!tableName.value || !tableName.value.trim()) {
        toast.error("Table name is required");
        return false;
    }

    // Validate fields
    if (fields.value.length === 0) {
        toast.error("At least one field is required");
        return false;
    }

    // Validate each field that has a name
    const filledFields = fields.value.filter(
        (f) => f.field_name && f.field_name.trim(),
    );

    if (filledFields.length === 0) {
        toast.error("At least one field with a name is required");
        return false;
    }

    for (let i = 0; i < filledFields.length; i++) {
        const field = filledFields[i];
        if (!field.input_type) {
            toast.error(`Field "${field.field_name}": Input type is required`);
            return false;
        }
    }

    return true;
};

const submit = () => {
    // Validate first
    if (!validateForm()) {
        return;
    }

    // Transform data
    form.model_name = modelName.value;
    form.table_name = tableName.value;
    form.builder_options = builderOption.value;
    form.soft_deletes = softDeletes.value;
    form.create_page = pages.create;
    form.edit_page = pages.edit;
    form.show_page = pages.show;

    // Reset arrays
    form.field_name = [];
    form.field_type = [];
    form.default_value = [];
    form.defined_value = [];
    form.input_type = [];
    form.row_create_page = [];
    form.row_edit_page = [];
    form.row_list_page = [];
    form.row_details_page = [];
    form.searchable = [];
    form.sortable = [];
    form.validations = [];
    form.table_ref = [];
    form.value_field_ref = [];
    form.label_field_ref = [];
    form.where_field_ref = [];
    form.custom_options = [];
    // Filter out fields with empty names and process only filled fields
    const filledFields = fields.value.filter(
        (f) => f.field_name && f.field_name.trim(),
    );

    filledFields.forEach((f) => {
        form.field_name.push(f.field_name);
        form.field_type.push(f.field_type);
        form.default_value.push(f.default_value);
        form.defined_value.push(f.defined_value || ""); // Empty string if not defined
        form.input_type.push(f.input_type);
        form.row_create_page.push(f.row_create_page);
        form.row_edit_page.push(f.row_edit_page);
        form.row_list_page.push(f.row_list_page);
        form.row_details_page.push(f.row_details_page);
        form.searchable.push(f.searchable);
        form.sortable.push(f.sortable);
        form.table_ref.push(f.table_ref || "");
        form.value_field_ref.push(f.value_field_ref || "");
        form.label_field_ref.push(f.label_field_ref || "");
        form.where_field_ref.push(f.where_field_ref || "");
        form.custom_options.push(f.custom_options || []);

        // Transform validations
        const rowValidations = [];
        f.validations.forEach((v) => {
            if (v.is_input_able && v.value) {
                // Return object { [id]: value }
                let obj = {};
                obj[v.id] = v.value;
                rowValidations.push(obj);
            } else {
                // Return id
                rowValidations.push(v.id);
            }
        });

        form.validations.push(rowValidations);
    });

    form.post(crud.store.url(), {
        onSuccess: () => {
            toast.success("CRUD generated successfully! Files created.");
            // Use router.visit to ensure redirect happens even if Vite HMR interferes
            router.visit(crud.index.url());
        },
        onError: (errors) => {
            if (errors.message) {
                toast.error(errors.message);
            } else {
                toast.error(
                    "Failed to generate CRUD. Check console for details.",
                );
            }
            console.error(errors);
        },
    });
};

const builderOptions = [
    { value: "generate_crud", label: "Generate CRUD" },
    { value: "generate_api", label: "Generate API" },
    { value: "generate_crud_api", label: "Generate CRUD & API" },
];
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card :title="title">
            <form @submit.prevent="submit">
                <!-- Basic Settings Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <FormInput
                        v-model="modelName"
                        label="Model Name"
                        placeholder="e.g. Customer (singular)"
                        required
                        @input="onModelNameInput"
                        :error="form.errors.model_name"
                    />
                    <FormInput
                        v-model="tableName"
                        label="Table Name"
                        placeholder="e.g. customers"
                        required
                        :error="form.errors.table_name"
                    />
                </div>

                <div class="mb-6">
                    <CustomSelect
                        v-model="builderOption"
                        label="Builder Options"
                        :options="builderOptions"
                        :error="form.errors.builder_options"
                    />
                </div>

                <!-- Options Toggle Switches -->
                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3"
                    >
                        Options
                    </label>
                    <div class="flex flex-wrap gap-6">
                        <label
                            class="inline-flex items-center cursor-pointer group"
                        >
                            <input
                                type="checkbox"
                                v-model="softDeletes"
                                class="sr-only peer"
                            />
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                            ></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Soft Deletes</span
                            >
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer group"
                        >
                            <input
                                type="checkbox"
                                v-model="pages.create"
                                class="sr-only peer"
                            />
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                            ></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Create Page</span
                            >
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer group"
                        >
                            <input
                                type="checkbox"
                                v-model="pages.edit"
                                class="sr-only peer"
                            />
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                            ></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Edit Page</span
                            >
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer group"
                        >
                            <input
                                type="checkbox"
                                v-model="pages.show"
                                class="sr-only peer"
                            />
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"
                            ></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Show Page</span
                            >
                        </label>
                    </div>
                </div>

                <!-- Fields Section -->
                <div class="mb-6">
                    <h4
                        class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                    >
                        Fields
                    </h4>

                    <!-- Info Alert -->
                    <div
                        class="flex items-start gap-3 p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-blue-900/50 dark:text-blue-300"
                        role="alert"
                    >
                        <InformationCircleIcon
                            class="w-5 h-5 shrink-0 mt-0.5"
                        />
                        <div>
                            <span class="font-medium">Note:</span>
                            <ul class="mt-1.5 list-disc list-inside space-y-1">
                                <li>
                                    Field Name should be
                                    <code
                                        class="px-1 py-0.5 bg-blue-100 dark:bg-blue-800 rounded"
                                        >snake_case</code
                                    >
                                    (e.g.
                                    <code
                                        class="px-1 py-0.5 bg-blue-100 dark:bg-blue-800 rounded"
                                        >post_title</code
                                    >)
                                </li>
                                <li>
                                    <code
                                        class="px-1 py-0.5 bg-blue-100 dark:bg-blue-800 rounded"
                                        >id</code
                                    >,
                                    <code
                                        class="px-1 py-0.5 bg-blue-100 dark:bg-blue-800 rounded"
                                        >created_at</code
                                    >,
                                    <code
                                        class="px-1 py-0.5 bg-blue-100 dark:bg-blue-800 rounded"
                                        >updated_at</code
                                    >
                                    are created automatically
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Fields Table -->
                    <div
                        class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700"
                    >
                        <table class="w-full text-sm text-left">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-2 py-3 w-10">
                                        <span class="sr-only">Drag</span>
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Field Name
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        DB Type
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Default
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Input Type
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Validation
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Create
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Edit
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        List
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Details
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Search
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Sort
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 text-center"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <draggable
                                v-model="fields"
                                tag="tbody"
                                item-key="_id"
                                handle=".drag-handle"
                                :animation="200"
                                ghost-class="opacity-50"
                                class="bg-white dark:bg-gray-900"
                            >
                                <template #item="{ element: field, index }">
                                    <CrudFieldRow
                                        :index="index"
                                        :field="field"
                                        :input-types="input_types"
                                        :all-validations="all_validations"
                                        :available-tables="available_tables"
                                        :can-delete="index > 0"
                                        @update:field="
                                            Object.assign(fields[index], $event)
                                        "
                                        @remove="fields.splice(index, 1)"
                                    />
                                </template>
                            </draggable>
                        </table>
                    </div>

                    <div class="mt-4">
                        <Button
                            type="button"
                            @click="addField"
                            variant="outline-primary"
                            size="sm"
                        >
                            <PlusIcon class="w-4 h-4 mr-1" />
                            Add Field
                        </Button>
                    </div>
                </div>

                <!-- Submit -->
                <div
                    class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700"
                >
                    <Button
                        type="submit"
                        :loading="form.processing"
                        variant="primary"
                    >
                        <CheckIcon class="w-4 h-4 mr-2" />
                        Generate CRUD
                    </Button>
                </div>
            </form>
        </Card>
    </AdminLayout>
</template>
