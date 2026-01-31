<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import {
    NoSymbolIcon,
    TrashIcon,
    PowerIcon,
    ArrowPathIcon,
    GlobeAltIcon,
    ComputerDesktopIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: { type: String, default: "Activations" },
    activations: { type: Object, default: () => ({}) },
});

const toast = useToast();

const columns = [
    { key: "domain", label: "Domain", sortable: true },
    { key: "ip_address", label: "IP", sortable: true },
    { key: "license.product.name", label: "Product", sortable: false },
    { key: "license.purchase_code", label: "License", sortable: false },
    { key: "env", label: "Environment", sortable: true },
    { key: "last_verified_at", label: "Last Verified", sortable: true },
    { key: "status", label: "Status", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

const showActionModal = ref(false);
const actionTarget = ref(null);
const actionType = ref(""); // deactivate, block, delete, reactivate

const openActionModal = (activation, type) => {
    actionTarget.value = activation;
    actionType.value = type;
    showActionModal.value = true;
};

const getActionTitle = () => {
    switch (actionType.value) {
        case "deactivate":
            return "Deactivate Domain";
        case "block":
            return "Block Activation";
        case "delete":
            return "Delete Activation";
        case "reactivate":
            return "Reactivate Domain";
        default:
            return "Confirm Action";
    }
};

const getActionMessage = () => {
    const domain = actionTarget.value?.domain || "this domain";
    switch (actionType.value) {
        case "deactivate":
            return `Are you sure you want to deactivate ${domain}? It can be reactivated later.`;
        case "block":
            return `Are you sure you want to BLOCK ${domain}? This will prevent future activations from this domain.`;
        case "delete":
            return `Are you sure you want to completely delete the activation record for ${domain}?`;
        case "reactivate":
            return `Reactivate access for ${domain}?`;
        default:
            return "Are you sure?";
    }
};

const getActionButtonText = () => {
    switch (actionType.value) {
        case "deactivate":
            return "Deactivate";
        case "block":
            return "Block";
        case "delete":
            return "Delete";
        case "reactivate":
            return "Reactivate";
        default:
            return "Confirm";
    }
};

const getActionVariant = () => {
    switch (actionType.value) {
        case "reactivate":
            return "success";
        case "deactivate":
            return "warning";
        case "block":
            return "danger";
        case "delete":
            return "danger";
        default:
            return "primary";
    }
};

const confirmAction = () => {
    if (!actionTarget.value || !actionType.value) return;

    const routes = {
        deactivate: `/admin/activations/${actionTarget.value.id}/deactivate`,
        block: `/admin/activations/${actionTarget.value.id}/block`,
        delete: `/admin/activations/${actionTarget.value.id}`,
        reactivate: `/admin/activations/${actionTarget.value.id}/reactivate`,
    };

    const method = actionType.value === "delete" ? "delete" : "post";

    router[method](
        routes[actionType.value],
        actionType.value === "delete" ? {} : {},
        {
            onSuccess: () => {
                toast.success("Action completed successfully");
                showActionModal.value = false;
                actionTarget.value = null;
                actionType.value = "";
            },
        },
    );
};

const getStatusBadge = (status) => {
    const badges = {
        active: "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
        inactive:
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400",
        blocked: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
    };
    return badges[status] || badges.inactive;
};

const formatDate = (dateString) => {
    if (!dateString) return "Never";
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card>
            <template #header>
                <div class="flex items-center justify-between w-full">
                    <span class="font-semibold">Domain Activations</span>
                </div>
            </template>

            <DataTable
                :paginated-data="activations"
                :columns="columns"
                :show-actions="false"
            >
                <template #cell-domain="{ row }">
                    <div class="font-medium">{{ row.domain }}</div>
                </template>

                <template #cell-license.purchase_code="{ row }">
                    <code
                        v-if="row.license"
                        class="text-xs bg-secondary-100 dark:bg-secondary-800 px-2 py-1 rounded"
                    >
                        {{ row.license.purchase_code.substring(0, 8) }}...
                    </code>
                    <span v-else class="text-xs text-secondary-500"
                        >Unknown</span
                    >
                </template>

                <template #cell-env="{ row }">
                    <div class="flex items-center gap-1.5">
                        <GlobeAltIcon
                            v-if="!row.is_local"
                            class="w-4 h-4 text-primary"
                        />
                        <ComputerDesktopIcon
                            v-else
                            class="w-4 h-4 text-green-600"
                        />
                        <span class="text-sm">{{
                            row.is_local ? "Local" : "Live"
                        }}</span>
                    </div>
                </template>

                <template #cell-last_verified_at="{ row }">
                    <span class="text-sm text-secondary-600">{{
                        formatDate(row.last_verified_at)
                    }}</span>
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
                        <button
                            v-if="row.status === 'active'"
                            @click="openActionModal(row, 'deactivate')"
                            class="p-1.5 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900/30 text-yellow-600"
                            title="Deactivate"
                        >
                            <PowerIcon class="w-5 h-5" />
                        </button>

                        <button
                            v-if="row.status === 'deactivated'"
                            @click="openActionModal(row, 'reactivate')"
                            class="p-1.5 rounded hover:bg-green-100 dark:hover:bg-green-900/30 text-green-600"
                            title="Reactivate"
                        >
                            <ArrowPathIcon class="w-5 h-5" />
                        </button>

                        <button
                            v-if="row.status !== 'blocked'"
                            @click="openActionModal(row, 'block')"
                            class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                            title="Block Domain"
                        >
                            <NoSymbolIcon class="w-5 h-5" />
                        </button>

                        <button
                            @click="openActionModal(row, 'delete')"
                            class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                            title="Delete"
                        >
                            <TrashIcon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </Card>

        <!-- Action Confirmation Modal -->
        <Modal
            :show="showActionModal"
            :title="getActionTitle()"
            @close="showActionModal = false"
        >
            <p>{{ getActionMessage() }}</p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showActionModal = false"
                    class="mr-2"
                >
                    Cancel
                </Button>
                <Button :variant="getActionVariant()" @click="confirmAction">
                    {{ getActionButtonText() }}
                </Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
