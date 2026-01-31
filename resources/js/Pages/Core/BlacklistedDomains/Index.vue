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
import {
    PencilSquareIcon,
    TrashIcon,
    ShieldExclamationIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Blacklisted Domains",
    },
    domains: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "pattern", label: "Pattern", sortable: true },
    { key: "reason", label: "Reason", sortable: false },
    { key: "created_at", label: "Added", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

const form = useForm({
    pattern: "",
    reason: "",
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

const editDomain = (domain) => {
    editingId.value = domain.id;
    form.pattern = domain.pattern;
    form.reason = domain.reason || "";
    showFormModal.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/admin/blacklisted-domains/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Blacklist entry updated successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    } else {
        form.post("/admin/blacklisted-domains", {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Domain added to blacklist");
                showFormModal.value = false;
                resetForm();
            },
        });
    }
};

const confirmDelete = (domain) => {
    deleteTarget.value = domain;
    showDeleteModal.value = true;
};

const deleteDomain = () => {
    if (deleteTarget.value) {
        router.delete(`/admin/blacklisted-domains/${deleteTarget.value.id}`, {
            onSuccess: () => {
                toast.success("Domain removed from blacklist");
                showDeleteModal.value = false;
                deleteTarget.value = null;
            },
        });
    }
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card>
            <template #header>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-2">
                        <ShieldExclamationIcon class="w-5 h-5 text-red-500" />
                        <span class="font-semibold">Blacklisted Domains</span>
                    </div>
                    <Button @click="openAddModal">Add Pattern</Button>
                </div>
            </template>

            <div
                class="mb-4 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800"
            >
                <p class="text-sm text-amber-700 dark:text-amber-300">
                    <strong>Patterns:</strong> Use wildcards like
                    <code class="bg-amber-100 dark:bg-amber-900 px-1 rounded"
                        >*.nulled.*</code
                    >
                    or
                    <code class="bg-amber-100 dark:bg-amber-900 px-1 rounded"
                        >nulled.to</code
                    >
                </p>
            </div>

            <DataTable
                :paginated-data="domains"
                :columns="columns"
                :show-actions="false"
            >
                <template #cell-pattern="{ row }">
                    <span
                        class="font-mono text-sm bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded text-red-600 dark:text-red-400"
                    >
                        {{ row.pattern }}
                    </span>
                </template>

                <template #cell-reason="{ row }">
                    <span
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        {{ row.reason || "-" }}
                    </span>
                </template>

                <template #cell-created_at="{ row }">
                    {{ formatDate(row.created_at) }}
                </template>

                <template #cell-action="{ row }">
                    <div class="flex items-center gap-2">
                        <button
                            @click="editDomain(row)"
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
            :title="
                editingId ? 'Edit Blacklist Entry' : 'Add Blacklist Pattern'
            "
            @close="showFormModal = false"
        >
            <form @submit.prevent="submit" class="space-y-4">
                <FormInput
                    v-model="form.pattern"
                    label="Domain Pattern"
                    :error="form.errors.pattern"
                    placeholder="*.nulled.*, warez.com, *.cracked.*"
                    required
                />

                <FormTextarea
                    v-model="form.reason"
                    label="Reason (Optional)"
                    :error="form.errors.reason"
                    :rows="2"
                    placeholder="Why is this domain blacklisted?"
                />
            </form>

            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showFormModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button @click="submit" :loading="form.processing">
                    {{ editingId ? "Update" : "Add to Blacklist" }}
                </Button>
            </template>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal
            :show="showDeleteModal"
            title="Remove from Blacklist"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to remove
                <code
                    class="bg-secondary-100 dark:bg-secondary-800 px-2 py-1 rounded"
                    >{{ deleteTarget?.pattern }}</code
                >
                from the blacklist?
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteDomain">Remove</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
