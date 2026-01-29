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
import tags from "@/routes/admin/tags";

const props = defineProps({
    title: {
        type: String,
        default: "Tags",
    },
    paginatedTags: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();
const isEditing = ref(false);
const editingId = ref(null);

// Form handling
const form = useForm({
    name: "",
    slug: "",
    description: "",
});

// Auto-generate slug from name
const updateSlug = () => {
    form.slug = form.name.toLowerCase().replace(/\s+/g, "-");
};

// Reset form
const resetForm = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
};

// Submit form
const submit = () => {
    if (isEditing.value) {
        form.put(tags.update.url({ tag: editingId.value }), {
            onSuccess: () => {
                toast.success("Tag updated successfully");
                resetForm();
            },
        });
    } else {
        form.post(tags.store.url(), {
            onSuccess: () => {
                toast.success("Tag created successfully");
                resetForm();
            },
        });
    }
};

// Edit tag
const edit = (tag) => {
    isEditing.value = true;
    editingId.value = tag.id;
    form.name = tag.name;
    form.slug = tag.slug;
    form.description = tag.description;

    const formElement = document.getElementById("tag-form");
    if (formElement) {
        formElement.scrollIntoView({ behavior: "smooth" });
    }
};

// Delete tag
const deleteModalOpen = ref(false);
const itemToDelete = ref(null);

const confirmDelete = (tag) => {
    itemToDelete.value = tag;
    deleteModalOpen.value = true;
};

const deleteItem = () => {
    if (itemToDelete.value) {
        router.delete(tags.destroy.url({ tag: itemToDelete.value.id }), {
            onSuccess: () => {
                toast.success("Tag deleted successfully");
                deleteModalOpen.value = false;
                itemToDelete.value = null;
            },
        });
    }
};

// Table Columns
const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "slug", label: "Slug", sortable: true },
    { key: "description", label: "Description", sortable: false },
    { key: "action", label: "Action", sortable: false, searchable: false },
];
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Table Column -->
            <div class="lg:col-span-8">
                <Card :title="`${title} List`">
                    <DataTable
                        :paginated-data="paginatedTags"
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

            <!-- Form Column -->
            <div class="lg:col-span-4">
                <Card :title="isEditing ? `Edit ${title}` : `Add ${title}`">
                    <form @submit.prevent="submit" id="tag-form">
                        <div class="space-y-4">
                            <FormInput
                                v-model="form.name"
                                label="Name"
                                placeholder="Tag Name"
                                required
                                :error="form.errors.name"
                                @input="updateSlug"
                            />

                            <FormInput
                                v-model="form.slug"
                                label="Slug"
                                placeholder="slug"
                                required
                                :error="form.errors.slug"
                            />

                            <div class="">
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"
                                    rows="3"
                                    placeholder="Description"
                                ></textarea>
                                <p
                                    v-if="form.errors.description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </div>

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

        <!-- Delete Confirmation Modal -->
        <Modal
            :show="deleteModalOpen"
            title="Delete Tag"
            @close="deleteModalOpen = false"
        >
            <p>
                Are you sure you want to delete tag
                <strong>{{ itemToDelete?.name }}</strong
                >? This action cannot be undone.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="deleteModalOpen = false"
                    class="mr-2"
                >
                    Cancel
                </Button>
                <Button variant="danger" @click="deleteItem"> Delete </Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
