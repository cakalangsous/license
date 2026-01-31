<script setup>
import { ref } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Marketplaces",
    },
    marketplaces: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "slug", label: "Slug", sortable: true },
    { key: "licenses_count", label: "Licenses", sortable: false },
    { key: "sales_count", label: "Sales", sortable: false },
    { key: "is_active", label: "Status", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

const form = useForm({
    name: "",
    slug: "",
    api_token: "",
    api_base_url: "",
    is_active: true,
});

const editingId = ref(null);
const showFormModal = ref(false);
const showDeleteModal = ref(false);
const deleteTarget = ref(null);

const resetForm = () => {
    form.reset();
    editingId.value = null;
};

const openAddModal = () => {
    resetForm();
    showFormModal.value = true;
};

const editMarketplace = (marketplace) => {
    editingId.value = marketplace.id;
    form.name = marketplace.name;
    form.slug = marketplace.slug;
    form.api_token = "";
    form.api_base_url = marketplace.api_base_url || "";
    form.is_active = marketplace.is_active;
    showFormModal.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/admin/marketplaces/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Marketplace updated successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    } else {
        form.post("/admin/marketplaces", {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Marketplace created successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    }
};

const confirmDelete = (marketplace) => {
    deleteTarget.value = marketplace;
    showDeleteModal.value = true;
};

const deleteMarketplace = () => {
    if (deleteTarget.value) {
        router.delete(`/admin/marketplaces/${deleteTarget.value.id}`, {
            onSuccess: () => {
                toast.success("Marketplace deleted successfully");
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

        <Card>
            <template #header>
                <div class="flex items-center justify-between w-full">
                    <span class="font-semibold">Marketplaces</span>
                    <Button @click="openAddModal">Add Marketplace</Button>
                </div>
            </template>

            <DataTable
                :paginated-data="marketplaces"
                :columns="columns"
                :show-actions="false"
            >
                <template #cell-is_active="{ row }">
                    <span
                        :class="[
                            'px-2 py-1 rounded-full text-xs font-medium',
                            row.is_active
                                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                        ]"
                    >
                        {{ row.is_active ? "Active" : "Inactive" }}
                    </span>
                </template>

                <template #cell-action="{ row }">
                    <div class="flex items-center gap-2">
                        <button
                            @click="editMarketplace(row)"
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

        <!-- Add/Edit Modal -->
        <Modal
            :show="showFormModal"
            :title="editingId ? 'Edit Marketplace' : 'Add Marketplace'"
            @close="showFormModal = false"
        >
            <form @submit.prevent="submit" class="space-y-4">
                <FormInput
                    v-model="form.name"
                    label="Marketplace Name"
                    :error="form.errors.name"
                    required
                />

                <FormInput
                    v-model="form.slug"
                    label="Slug"
                    :error="form.errors.slug"
                    placeholder="Leave empty to auto-generate"
                />

                <FormInput
                    v-model="form.api_base_url"
                    label="API Base URL"
                    :error="form.errors.api_base_url"
                    placeholder="https://api.envato.com"
                />

                <FormInput
                    v-model="form.api_token"
                    label="API Token"
                    type="password"
                    :error="form.errors.api_token"
                    :placeholder="
                        editingId
                            ? 'Leave empty to keep existing'
                            : 'Enter API token'
                    "
                />

                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        v-model="form.is_active"
                        id="is_active"
                        class="rounded border-secondary-300 text-primary focus:ring-primary"
                    />
                    <label
                        for="is_active"
                        class="text-sm text-secondary-700 dark:text-secondary-300"
                    >
                        Active
                    </label>
                </div>
            </form>

            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showFormModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button @click="submit" :loading="form.processing">
                    {{ editingId ? "Update" : "Create" }}
                </Button>
            </template>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal
            :show="showDeleteModal"
            title="Delete Marketplace"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to delete
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
                <Button variant="danger" @click="deleteMarketplace"
                    >Delete</Button
                >
            </template>
        </Modal>
    </AdminLayout>
</template>
