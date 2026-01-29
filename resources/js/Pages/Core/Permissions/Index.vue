<script setup>
import { ref } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import permissions from "@/routes/admin/permissions";

const props = defineProps({
    title: {
        type: String,
        default: "Permissions",
    },
    paginatedPermissions: {
        type: Object,
        default: () => ({}),
    },
    tables: {
        type: Array,
        default: () => [],
    },
});

const toast = useToast();
const isEditing = ref(false);
const editingId = ref(null);

// Form handling
const form = useForm({
    name: "",
    table_name: "",
});

const resetForm = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
};

const submit = () => {
    if (isEditing.value) {
        form.put(permissions.update.url({ permission: editingId.value }), {
            onSuccess: () => {
                toast.success("Permission updated successfully");
                resetForm();
            },
        });
    } else {
        form.post(permissions.store.url(), {
            onSuccess: () => {
                toast.success("Permission created successfully");
                resetForm();
            },
        });
    }
};

const edit = (permission) => {
    isEditing.value = true;
    editingId.value = permission.id;
    form.name = permission.name;
    form.table_name = permission.table_name;

    const formElement = document.getElementById("permission-form");
    if (formElement) {
        formElement.scrollIntoView({ behavior: "smooth" });
    }
};

const deleteModalOpen = ref(false);
const itemToDelete = ref(null);

const confirmDelete = (permission) => {
    itemToDelete.value = permission;
    deleteModalOpen.value = true;
};

const deleteItem = () => {
    if (itemToDelete.value) {
        router.delete(
            permissions.destroy.url({ permission: itemToDelete.value.id }),
            {
                onSuccess: () => {
                    toast.success("Permission deleted successfully");
                    deleteModalOpen.value = false;
                    itemToDelete.value = null;
                },
            },
        );
    }
};

const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "table_name", label: "Table", sortable: true },
    { key: "guard_name", label: "Guard", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8">
                <Card :title="`${title} List`">
                    <DataTable
                        :paginated-data="paginatedPermissions"
                        :columns="columns"
                    >
                        <template #cell-action="{ row }">
                            <div class="flex gap-2">
                                <Button
                                    size="sm"
                                    variant="outline-primary"
                                    @click="edit(row)"
                                >
                                    Edit
                                </Button>
                                <Button
                                    size="sm"
                                    variant="danger"
                                    @click="confirmDelete(row)"
                                >
                                    Delete
                                </Button>
                            </div>
                        </template>
                    </DataTable>
                </Card>
            </div>

            <div class="lg:col-span-4">
                <Card :title="isEditing ? `Edit ${title}` : `Add ${title}`">
                    <form @submit.prevent="submit" id="permission-form">
                        <div class="space-y-4">
                            <FormInput
                                v-model="form.name"
                                label="Name"
                                placeholder="Permission Name"
                                required
                                :error="form.errors.name"
                            />

                            <FormSelect
                                v-model="form.table_name"
                                label="Table Name"
                                :options="tables"
                                placeholder="Select Table"
                                required
                                :error="form.errors.table_name"
                            />

                            <div class="flex justify-end gap-2">
                                <Button
                                    v-if="isEditing"
                                    type="button"
                                    variant="outline-secondary"
                                    @click="resetForm"
                                >
                                    Cancel
                                </Button>
                                <Button
                                    type="submit"
                                    :loading="form.processing"
                                >
                                    {{ isEditing ? "Update" : "Save" }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </Card>
            </div>
        </div>

        <Modal
            :show="deleteModalOpen"
            title="Delete Permission"
            @close="deleteModalOpen = false"
        >
            <p>
                Are you sure you want to delete permission
                <strong>{{ itemToDelete?.name }}</strong
                >? This action cannot be undone.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="deleteModalOpen = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteItem">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
