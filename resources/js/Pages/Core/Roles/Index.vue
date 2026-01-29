<script setup>
import { ref } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import roles from "@/routes/admin/roles";
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Roles",
    },
    paginatedRoles: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Form for add/edit
const form = useForm({
    name: "",
});
const editingId = ref(null);

const resetForm = () => {
    form.reset();
    editingId.value = null;
};

const submit = () => {
    if (editingId.value) {
        form.put(roles.update.url({ role: editingId.value }), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Role updated successfully");
                resetForm();
            },
        });
    } else {
        form.post(roles.store.url(), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Role created successfully");
                resetForm();
            },
        });
    }
};

const editRole = (role) => {
    editingId.value = role.id;
    form.name = role.name;
};

// Delete confirmation
const showDeleteModal = ref(false);
const deleteTarget = ref(null);

const confirmDelete = (role) => {
    deleteTarget.value = role;
    showDeleteModal.value = true;
};

const deleteRole = () => {
    if (deleteTarget.value) {
        router.delete(roles.destroy.url({ role: deleteTarget.value.id }), {
            onSuccess: () => {
                toast.success("Role deleted successfully");
                showDeleteModal.value = false;
                deleteTarget.value = null;
            },
        });
    }
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Roles List -->
            <Card title="Roles List" class="lg:col-span-2">
                <DataTable :paginated-data="paginatedRoles" :columns="columns">
                    <template #cell-action="{ row }">
                        <div class="flex items-center gap-2">
                            <button
                                @click="editRole(row)"
                                class="p-1.5 rounded hover:bg-secondary-100 dark:hover:bg-secondary-700 text-primary"
                            >
                                <PencilSquareIcon class="w-5 h-5" />
                            </button>
                            <button
                                @click="confirmDelete(row)"
                                class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                            >
                                <TrashIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </template>
                </DataTable>
            </Card>

            <!-- Add/Edit Form -->
            <Card :title="editingId ? 'Edit Role' : 'Add Role'">
                <form @submit.prevent="submit" class="space-y-4">
                    <FormInput
                        v-model="form.name"
                        label="Role Name"
                        placeholder="Role Name *"
                        :error="form.errors.name"
                        required
                    />

                    <div class="flex items-center gap-2">
                        <Button type="submit" :loading="form.processing">
                            {{ editingId ? "Update" : "Submit" }}
                        </Button>
                        <Button
                            v-if="editingId"
                            type="button"
                            variant="outline-secondary"
                            @click="resetForm"
                        >
                            Cancel
                        </Button>
                    </div>
                </form>
            </Card>
        </div>

        <!-- Delete Confirmation Modal -->
        <Modal
            :show="showDeleteModal"
            title="Delete Role"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to delete role
                <strong>{{ deleteTarget?.name }}</strong
                >? This action cannot be undone.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteRole">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
