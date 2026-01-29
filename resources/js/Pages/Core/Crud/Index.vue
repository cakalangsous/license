<script setup>
import { Head, router, usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import LinkButton from "@/Components/UI/LinkButton.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import crud from "@/routes/admin/crud";
import { useToast } from "vue-toastification";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Crud",
    },
    paginatedCruds: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();
const page = usePage();

// Show toast on success flash message
onMounted(() => {
    if (page.props.flash?.success) {
        toast.success(page.props.flash.success);
    }
});

const columns = [
    { key: "model_name", label: "Model Name", sortable: true },
    { key: "table_name", label: "Table Name", sortable: true },
    { key: "builder_options", label: "Type", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Confirm dialog state
const showConfirmDialog = ref(false);
const confirmDialogData = ref(null);
const isDeleting = ref(false);

const openDeleteConfirm = (row) => {
    confirmDialogData.value = row;
    showConfirmDialog.value = true;
};

const confirmDelete = () => {
    if (confirmDialogData.value) {
        isDeleting.value = true;
        router.delete(crud.destroy.url(confirmDialogData.value.id), {
            onSuccess: () => {
                toast.success("CRUD deleted successfully!");
                showConfirmDialog.value = false;
                confirmDialogData.value = null;
                isDeleting.value = false;
            },
            onError: () => {
                toast.error("Failed to delete CRUD");
                isDeleting.value = false;
            },
        });
    }
};

const cancelDelete = () => {
    showConfirmDialog.value = false;
    confirmDialogData.value = null;
};

// Format builder options for display
const formatBuilderOption = (option) => {
    const options = {
        generate_crud: "Web CRUD",
        generate_api: "API Only",
        generate_crud_api: "Web + API",
    };
    return options[option] || option;
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card :title="`${title} List`">
            <template #header-actions>
                <LinkButton :href="crud.create.url()" variant="primary">
                    Add {{ title }}
                </LinkButton>
            </template>

            <DataTable :paginated-data="paginatedCruds" :columns="columns">
                <template #cell-builder_options="{ row }">
                    <span
                        :class="{
                            'px-2 py-1 text-xs font-medium rounded-full': true,
                            'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300':
                                row.builder_options === 'generate_crud',
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                row.builder_options === 'generate_api',
                            'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300':
                                row.builder_options === 'generate_crud_api',
                        }"
                    >
                        {{ formatBuilderOption(row.builder_options) }}
                    </span>
                </template>
                <template #cell-action="{ row }">
                    <div class="flex gap-2">
                        <LinkButton
                            v-if="row.has_web_route"
                            :href="row.index_url"
                            size="sm"
                            variant="outline-info"
                        >
                            Visit
                        </LinkButton>
                        <LinkButton
                            :href="crud.edit.url(row.id)"
                            size="sm"
                            variant="outline-primary"
                        >
                            Edit
                        </LinkButton>
                        <Button
                            size="sm"
                            variant="danger"
                            @click="openDeleteConfirm(row)"
                        >
                            Delete
                        </Button>
                    </div>
                </template>
            </DataTable>
        </Card>

        <!-- Modern Confirm Dialog -->
        <Teleport to="body">
            <Transition name="modal">
                <div
                    v-if="showConfirmDialog"
                    class="fixed inset-0 z-50 flex items-center justify-center"
                >
                    <!-- Backdrop -->
                    <div
                        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                        @click="cancelDelete"
                    ></div>

                    <!-- Dialog -->
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 transform transition-all"
                    >
                        <!-- Icon -->
                        <div
                            class="mx-auto w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4"
                        >
                            <ExclamationTriangleIcon
                                class="w-8 h-8 text-red-600 dark:text-red-400"
                            />
                        </div>

                        <!-- Content -->
                        <h3
                            class="text-xl font-semibold text-center text-gray-900 dark:text-white mb-2"
                        >
                            Delete CRUD?
                        </h3>
                        <p
                            class="text-center text-gray-500 dark:text-gray-400 mb-6"
                        >
                            Are you sure you want to delete
                            <span
                                class="font-semibold text-gray-700 dark:text-gray-300"
                            >
                                "{{ confirmDialogData?.model_name }}" </span
                            >? This will remove the database entry and all
                            generated files.
                        </p>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button
                                @click="cancelDelete"
                                class="flex-1 px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                @click="confirmDelete"
                                :disabled="isDeleting"
                                class="flex-1 px-4 py-2.5 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="isDeleting">Deleting...</span>
                                <span v-else>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </AdminLayout>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: transform 0.2s ease;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    transform: scale(0.95);
}
</style>
