<script setup>
import { ref, computed } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import {
    PencilSquareIcon,
    TrashIcon,
    EyeIcon,
    NoSymbolIcon,
    PauseIcon,
    PlayIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Licenses",
    },
    licenses: {
        type: Object,
        default: () => ({}),
    },
    products: {
        type: Array,
        default: () => [],
    },
    marketplaces: {
        type: Array,
        default: () => [],
    },
});

const toast = useToast();

const columns = [
    { key: "purchase_code", label: "Purchase Code", sortable: true },
    { key: "buyer_email", label: "Buyer", sortable: true },
    { key: "product.name", label: "Product", sortable: false },
    { key: "license_type", label: "Type", sortable: true },
    { key: "prod_activations", label: "Prod", sortable: false },
    { key: "dev_activations", label: "Dev", sortable: false },
    { key: "support_status", label: "Support", sortable: false },
    { key: "status", label: "Status", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Form for add/edit
const form = useForm({
    product_id: "",
    marketplace_id: "",
    purchase_code: "",
    buyer_email: "",
    buyer_name: "",
    buyer_username: "",
    license_type: "regular",
    purchased_at: "",
    supported_until: "",
    status: "active",
    notes: "",
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

const editLicense = (license) => {
    editingId.value = license.id;
    form.product_id = license.product_id;
    form.marketplace_id = license.marketplace_id;
    form.purchase_code = license.purchase_code;
    form.buyer_email = license.buyer_email;
    form.buyer_name = license.buyer_name || "";
    form.buyer_username = license.buyer_username || "";
    form.license_type = license.license_type;
    form.purchased_at = license.purchased_at?.split("T")[0] || "";
    form.supported_until = license.supported_until?.split("T")[0] || "";
    form.status = license.status;
    form.notes = license.notes || "";
    showFormModal.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/admin/licenses/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("License updated successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    } else {
        form.post("/admin/licenses", {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("License created successfully");
                showFormModal.value = false;
                resetForm();
            },
        });
    }
};

const confirmDelete = (license) => {
    deleteTarget.value = license;
    showDeleteModal.value = true;
};

const deleteLicense = () => {
    if (deleteTarget.value) {
        router.delete(`/admin/licenses/${deleteTarget.value.id}`, {
            onSuccess: () => {
                toast.success("License deleted successfully");
                showDeleteModal.value = false;
                deleteTarget.value = null;
            },
        });
    }
};

const revokeLicense = (license) => {
    if (confirm("Are you sure you want to revoke this license?")) {
        router.post(
            `/admin/licenses/${license.id}/revoke`,
            {},
            {
                onSuccess: () => toast.success("License revoked"),
            },
        );
    }
};

const suspendLicense = (license) => {
    router.post(
        `/admin/licenses/${license.id}/suspend`,
        {},
        {
            onSuccess: () => toast.success("License suspended"),
        },
    );
};

const reactivateLicense = (license) => {
    router.post(
        `/admin/licenses/${license.id}/reactivate`,
        {},
        {
            onSuccess: () => toast.success("License reactivated"),
        },
    );
};

const getStatusBadge = (status) => {
    const badges = {
        active: "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
        suspended:
            "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400",
        revoked: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
        expired:
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400",
    };
    return badges[status] || badges.expired;
};

const getSupportBadge = (supportStatus) => {
    const badges = {
        active: {
            class: "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
            label: "Active",
        },
        expiring: {
            class: "bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400",
            label: "Expiring",
        },
        expired: {
            class: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
            label: "Expired",
        },
        lifetime: {
            class: "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400",
            label: "Lifetime",
        },
    };
    return badges[supportStatus] || badges.expired;
};

const licenseTypeOptions = [
    { value: "regular", label: "Regular (1 domain)" },
    { value: "extended", label: "Extended (5 domains)" },
];

const statusOptions = [
    { value: "active", label: "Active" },
    { value: "suspended", label: "Suspended" },
    { value: "revoked", label: "Revoked" },
    { value: "expired", label: "Expired" },
];
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card>
            <template #header>
                <div class="flex items-center justify-between w-full">
                    <span class="font-semibold">Licenses</span>
                    <Button @click="openAddModal">Add License</Button>
                </div>
            </template>

            <DataTable :paginated-data="licenses" :columns="columns">
                <template #cell-purchase_code="{ row }">
                    <code
                        class="text-sm bg-secondary-100 dark:bg-secondary-800 px-2 py-1 rounded"
                    >
                        {{ row.purchase_code.substring(0, 8) }}...
                    </code>
                </template>

                <template #cell-buyer_email="{ row }">
                    <div>
                        <p class="font-medium">{{ row.buyer_email }}</p>
                        <p
                            v-if="row.buyer_name"
                            class="text-sm text-secondary-500"
                        >
                            {{ row.buyer_name }}
                        </p>
                    </div>
                </template>

                <template #cell-license_type="{ row }">
                    <span class="capitalize">{{ row.license_type }}</span>
                </template>

                <template #cell-prod_activations="{ row }">
                    <span class="font-medium">
                        {{ row.production_activations_count || 0 }} /
                        {{ row.product?.extended_domains_limit || 1 }}
                    </span>
                </template>

                <template #cell-dev_activations="{ row }">
                    <span class="text-blue-500">
                        {{ row.local_activations_count || 0 }}
                    </span>
                </template>

                <template #cell-support_status="{ row }">
                    <span
                        :class="[
                            'px-2 py-1 rounded-full text-xs font-medium',
                            getSupportBadge(row.support_status).class,
                        ]"
                    >
                        {{ getSupportBadge(row.support_status).label }}
                    </span>
                </template>

                <template #cell-status="{ row }">
                    <span
                        :class="[
                            'px-2 py-1 rounded-full text-xs font-medium capitalize',
                            getStatusBadge(row.status),
                        ]"
                    >
                        {{ row.status }}
                    </span>
                </template>

                <template #cell-action="{ row }">
                    <div class="flex items-center gap-1">
                        <a
                            :href="`/admin/licenses/${row.id}`"
                            class="p-1.5 rounded hover:bg-secondary-100 dark:hover:bg-secondary-700 text-secondary-600 dark:text-secondary-400"
                            title="View"
                        >
                            <EyeIcon class="w-5 h-5" />
                        </a>
                        <button
                            @click="editLicense(row)"
                            class="p-1.5 rounded hover:bg-secondary-100 dark:hover:bg-secondary-700 text-primary"
                            title="Edit"
                        >
                            <PencilSquareIcon class="w-5 h-5" />
                        </button>
                        <button
                            v-if="row.status === 'active'"
                            @click="suspendLicense(row)"
                            class="p-1.5 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900/30 text-yellow-600"
                            title="Suspend"
                        >
                            <PauseIcon class="w-5 h-5" />
                        </button>
                        <button
                            v-if="row.status === 'suspended'"
                            @click="reactivateLicense(row)"
                            class="p-1.5 rounded hover:bg-green-100 dark:hover:bg-green-900/30 text-green-600"
                            title="Reactivate"
                        >
                            <PlayIcon class="w-5 h-5" />
                        </button>
                        <button
                            v-if="row.status !== 'revoked'"
                            @click="revokeLicense(row)"
                            class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                            title="Revoke"
                        >
                            <NoSymbolIcon class="w-5 h-5" />
                        </button>
                        <button
                            @click="confirmDelete(row)"
                            class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                            title="Delete"
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
            :title="editingId ? 'Edit License' : 'Add License'"
            @close="showFormModal = false"
            size="lg"
        >
            <form @submit.prevent="submit" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <FormSelect
                        v-model="form.product_id"
                        label="Product"
                        :options="
                            products.map((p) => ({
                                value: p.id,
                                label: p.name,
                            }))
                        "
                        :error="form.errors.product_id"
                        required
                    />
                    <FormSelect
                        v-model="form.marketplace_id"
                        label="Marketplace"
                        :options="
                            marketplaces.map((m) => ({
                                value: m.id,
                                label: m.name,
                            }))
                        "
                        :error="form.errors.marketplace_id"
                        required
                    />
                </div>

                <FormInput
                    v-model="form.purchase_code"
                    label="Purchase Code"
                    :error="form.errors.purchase_code"
                    required
                />

                <div class="grid grid-cols-2 gap-4">
                    <FormInput
                        v-model="form.buyer_email"
                        label="Buyer Email"
                        type="email"
                        :error="form.errors.buyer_email"
                        required
                    />
                    <FormInput
                        v-model="form.buyer_name"
                        label="Buyer Name"
                        :error="form.errors.buyer_name"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <FormSelect
                        v-model="form.license_type"
                        label="License Type"
                        :options="licenseTypeOptions"
                        :error="form.errors.license_type"
                        required
                    />
                    <FormSelect
                        v-model="form.status"
                        label="Status"
                        :options="statusOptions"
                        :error="form.errors.status"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <FormInput
                        v-model="form.purchased_at"
                        label="Purchased At"
                        type="date"
                        :error="form.errors.purchased_at"
                        required
                    />
                    <FormInput
                        v-model="form.supported_until"
                        label="Support Expires"
                        type="date"
                        :error="form.errors.supported_until"
                    />
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
            title="Delete License"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to delete this license? All activations
                will also be removed.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteLicense">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
