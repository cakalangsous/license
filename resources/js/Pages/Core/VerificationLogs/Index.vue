<script setup>
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { EyeIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Verification Logs",
    },
    logs: {
        type: Object,
        default: () => ({}),
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});

const columns = [
    { key: "created_at", label: "Time", sortable: true },
    { key: "app_name", label: "App", sortable: true },
    { key: "domain", label: "Domain", sortable: true },
    { key: "ip_address", label: "IP Address", sortable: false },
    { key: "request_type", label: "Type", sortable: true },
    { key: "status", label: "Status", sortable: true },
    { key: "failure_reason", label: "Reason", sortable: false },
];

const filters = ref({
    status: "",
    request_type: "",
    date_from: "",
    date_to: "",
});

const applyFilters = () => {
    router.get("/admin/verification-logs", filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleString("en-US", {
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getStatusClass = (status) => {
    switch (status) {
        case "success":
            return "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400";
        case "failed":
            return "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400";
        default:
            return "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400";
    }
};

const getTypeClass = (type) => {
    switch (type) {
        case "verify":
            return "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400";
        case "activate":
            return "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400";
        case "deactivate":
            return "bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400";
        case "heartbeat":
            return "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400";
        default:
            return "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400";
    }
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <Card class="bg-gradient-to-br from-blue-500/10 to-blue-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-blue-600 dark:text-blue-400"
                    >
                        {{ stats.total_requests?.toLocaleString() }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Total Requests
                    </p>
                </div>
            </Card>
            <Card class="bg-gradient-to-br from-green-500/10 to-green-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-green-600 dark:text-green-400"
                    >
                        {{ stats.success_count?.toLocaleString() }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Successful
                    </p>
                </div>
            </Card>
            <Card class="bg-gradient-to-br from-red-500/10 to-red-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-red-600 dark:text-red-400"
                    >
                        {{ stats.failed_count?.toLocaleString() }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Failed
                    </p>
                </div>
            </Card>
            <Card class="bg-gradient-to-br from-purple-500/10 to-purple-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-purple-600 dark:text-purple-400"
                    >
                        {{ stats.today_count?.toLocaleString() }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Today
                    </p>
                </div>
            </Card>
        </div>

        <Card>
            <template #header>
                <div
                    class="flex items-center justify-between w-full flex-wrap gap-4"
                >
                    <span class="font-semibold">Verification Logs</span>
                    <div class="flex items-center gap-2 flex-wrap">
                        <FormSelect
                            v-model="filters.status"
                            class="w-32"
                            @change="applyFilters"
                        >
                            <option value="">All Status</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </FormSelect>
                        <FormSelect
                            v-model="filters.request_type"
                            class="w-32"
                            @change="applyFilters"
                        >
                            <option value="">All Types</option>
                            <option value="verify">Verify</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="heartbeat">Heartbeat</option>
                        </FormSelect>
                        <FormInput
                            v-model="filters.date_from"
                            type="date"
                            class="w-40"
                            @change="applyFilters"
                        />
                        <FormInput
                            v-model="filters.date_to"
                            type="date"
                            class="w-40"
                            @change="applyFilters"
                        />
                    </div>
                </div>
            </template>

            <DataTable
                :paginated-data="logs"
                :columns="columns"
                :show-actions="false"
            >
                <template #cell-created_at="{ row }">
                    {{ formatDate(row.created_at) }}
                </template>

                <template #cell-app_name="{ row }">
                    <span v-if="row.app_name" class="font-medium text-sm">
                        {{ row.app_name }}
                    </span>
                    <span v-else class="text-secondary-400">-</span>
                </template>

                <template #cell-domain="{ row }">
                    <span class="font-mono text-sm">{{ row.domain }}</span>
                </template>

                <template #cell-ip_address="{ row }">
                    <span class="font-mono text-xs text-secondary-500">
                        {{ row.ip_address }}
                    </span>
                </template>

                <template #cell-request_type="{ row }">
                    <span
                        :class="[
                            'px-2 py-1 rounded-full text-xs font-medium capitalize',
                            getTypeClass(row.request_type),
                        ]"
                    >
                        {{ row.request_type }}
                    </span>
                </template>

                <template #cell-status="{ row }">
                    <span
                        :class="[
                            'px-2 py-1 rounded-full text-xs font-medium capitalize',
                            getStatusClass(row.status),
                        ]"
                    >
                        {{ row.status }}
                    </span>
                </template>

                <template #cell-failure_reason="{ row }">
                    <span
                        v-if="row.failure_reason"
                        class="text-xs text-red-500 truncate max-w-[200px] block"
                        :title="row.failure_reason"
                    >
                        {{ row.failure_reason }}
                    </span>
                    <span v-else class="text-secondary-400">-</span>
                </template>
            </DataTable>
        </Card>
    </AdminLayout>
</template>
