<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import Modal from "@/Components/UI/Modal.vue";
import Badge from "@/Components/UI/Badge.vue";
import Button from "@/Components/UI/Button.vue";

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({}),
    },
});

const columns = [
    { key: "description", label: "Action", sortable: false },
    { key: "subject_type", label: "Subject", sortable: false },
    { key: "subject_id", label: "ID", sortable: false },
    { key: "causer", label: "User", sortable: false },
    { key: "created_at", label: "Date", sortable: false },
    { key: "properties", label: "Changes", sortable: false },
];

// View Details Modal
const showDetailsModal = ref(false);
const selectedActivity = ref(null);

const viewDetails = (activity) => {
    selectedActivity.value = activity;
    showDetailsModal.value = true;
};

const getBadgeVariant = (description) => {
    switch (description) {
        case "created":
            return "success";
        case "updated":
            return "warning";
        case "deleted":
            return "danger";
        default:
            return "primary";
    }
};
</script>

<template>
    <AdminLayout title="Activity Logs">
        <Head title="Activity Logs" />

        <Card>
            <template #header>
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold">Activity Logs</span>
                </div>
            </template>

            <DataTable :paginated-data="activities" :columns="columns">
                <!-- Custom cell for description -->
                <template #cell-description="{ value }">
                    <Badge :variant="getBadgeVariant(value)">{{ value }}</Badge>
                </template>

                <!-- Custom cell for properties -->
                <template #cell-properties="{ row }">
                    <Button
                        v-if="
                            row.properties &&
                            Object.keys(row.properties).length > 0
                        "
                        size="xs"
                        variant="outline-secondary"
                        @click="viewDetails(row)"
                    >
                        View Details
                    </Button>
                    <span v-else class="text-gray-400 text-xs">-</span>
                </template>
            </DataTable>
        </Card>

        <!-- Details Modal -->
        <Modal
            :show="showDetailsModal"
            title="Activity Details"
            @close="showDetailsModal = false"
        >
            <div v-if="selectedActivity" class="space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-bold text-gray-500 block"
                            >Action</span
                        >
                        {{ selectedActivity.description }}
                    </div>
                    <div>
                        <span class="font-bold text-gray-500 block">Date</span>
                        {{ selectedActivity.created_at }}
                    </div>
                    <div>
                        <span class="font-bold text-gray-500 block"
                            >Subject</span
                        >
                        {{ selectedActivity.subject_type }} #{{
                            selectedActivity.subject_id
                        }}
                    </div>
                    <div>
                        <span class="font-bold text-gray-500 block">User</span>
                        {{ selectedActivity.causer }}
                    </div>
                </div>

                <div class="border-t pt-4 mt-4">
                    <h4 class="font-semibold mb-2">Changes / Properties</h4>
                    <pre
                        class="bg-gray-100 dark:bg-gray-800 p-4 rounded text-xs overflow-auto max-h-60"
                        >{{
                            JSON.stringify(selectedActivity.properties, null, 2)
                        }}</pre
                    >
                </div>
            </div>

            <template #footer>
                <Button variant="secondary" @click="showDetailsModal = false"
                    >Close</Button
                >
            </template>
        </Modal>
    </AdminLayout>
</template>
