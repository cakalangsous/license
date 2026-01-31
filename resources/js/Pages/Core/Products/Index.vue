<script setup>
import { ref } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import FormCheckbox from "@/Components/Form/FormCheckbox.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Products",
    },
    products: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "slug", label: "Slug", sortable: true },
    { key: "regular_domains_limit", label: "Regular Limit", sortable: false },
    { key: "extended_domains_limit", label: "Extended Limit", sortable: false },
    { key: "is_active", label: "Status", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Form for add/edit
const form = useForm({
    name: "",
    slug: "",
    description: "",
    regular_domains_limit: 1,
    extended_domains_limit: 5,
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

const editProduct = (product) => {
    editingId.value = product.id;
    form.name = product.name;
    form.slug = product.slug;
    form.description = product.description || "";
    form.regular_domains_limit = product.regular_domains_limit;
    form.extended_domains_limit = product.extended_domains_limit;
    form.is_active = product.is_active;
    showFormModal.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/admin/products/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Product updated successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    } else {
        form.post("/admin/products", {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Product created successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    }
};

const confirmDelete = (product) => {
    deleteTarget.value = product;
    showDeleteModal.value = true;
};

const deleteProduct = () => {
    if (deleteTarget.value) {
        router.delete(`/admin/products/${deleteTarget.value.id}`, {
            onSuccess: () => {
                toast.success("Product deleted successfully");
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
                    <span class="font-semibold">Products</span>
                    <Button @click="openAddModal">Add Product</Button>
                </div>
            </template>

            <DataTable :paginated-data="products" :columns="columns">
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
                            @click="editProduct(row)"
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
            :title="editingId ? 'Edit Product' : 'Add Product'"
            @close="showFormModal = false"
        >
            <form @submit.prevent="submit" class="space-y-4">
                <FormInput
                    v-model="form.name"
                    label="Product Name"
                    :error="form.errors.name"
                    required
                />

                <FormInput
                    v-model="form.slug"
                    label="Slug"
                    :error="form.errors.slug"
                    required
                />

                <FormTextarea
                    v-model="form.description"
                    label="Description"
                    :error="form.errors.description"
                    :rows="3"
                />

                <div class="grid grid-cols-2 gap-4">
                    <FormInput
                        v-model="form.regular_domains_limit"
                        label="Regular License Domains"
                        type="number"
                        :error="form.errors.regular_domains_limit"
                        required
                    />
                    <FormInput
                        v-model="form.extended_domains_limit"
                        label="Extended License Domains"
                        type="number"
                        :error="form.errors.extended_domains_limit"
                        required
                    />
                </div>

                <FormCheckbox v-model="form.is_active" label="Active" />
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
            title="Delete Product"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to delete
                <strong>{{ deleteTarget?.name }}</strong
                >? This will also remove all associated licenses.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteProduct">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
