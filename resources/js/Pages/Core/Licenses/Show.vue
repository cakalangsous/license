<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import {
    ArrowLeftIcon,
    KeyIcon,
    GlobeAltIcon,
    ClockIcon,
    NoSymbolIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "License Details",
    },
    license: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();
const showDeactivateModal = ref(false);
const deactivateTarget = ref(null);

const getStatusBadge = (status) => {
    const badges = {
        active: "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
        suspended:
            "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400",
        revoked: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
        expired:
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400",
        deactivated:
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400",
        blocked: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
    };
    return badges[status] || badges.expired;
};

const formatDate = (dateString) => {
    if (!dateString) return "N/A";
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const confirmDeactivate = (activation) => {
    deactivateTarget.value = activation;
    showDeactivateModal.value = true;
};

const deactivateActivation = () => {
    if (deactivateTarget.value) {
        router.post(
            `/admin/activations/${deactivateTarget.value.id}/deactivate`,
            {},
            {
                onSuccess: () => {
                    toast.success("Activation deactivated");
                    showDeactivateModal.value = false;
                    deactivateTarget.value = null;
                },
            },
        );
    }
};

const blockActivation = (activation) => {
    if (confirm("Block this domain from future activations?")) {
        router.post(
            `/admin/activations/${activation.id}/block`,
            {},
            {
                onSuccess: () => toast.success("Domain blocked"),
            },
        );
    }
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="space-y-6">
            <!-- Back Button -->
            <div>
                <a
                    href="/admin/licenses"
                    class="inline-flex items-center gap-2 text-secondary-600 hover:text-primary"
                >
                    <ArrowLeftIcon class="w-4 h-4" />
                    Back to Licenses
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- License Info -->
                <Card class="lg:col-span-2">
                    <template #header>
                        <div class="flex items-center gap-2">
                            <KeyIcon class="w-5 h-5 text-primary" />
                            <span class="font-semibold"
                                >License Information</span
                            >
                        </div>
                    </template>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Purchase Code</label
                                >
                                <code
                                    class="text-sm bg-secondary-100 dark:bg-secondary-800 px-2 py-1 rounded"
                                >
                                    {{ license.purchase_code }}
                                </code>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Status</label
                                >
                                <span
                                    :class="[
                                        'px-2 py-1 rounded-full text-xs font-medium capitalize',
                                        getStatusBadge(license.status),
                                    ]"
                                >
                                    {{ license.status }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Product</label
                                >
                                <p class="font-medium">
                                    {{ license.product?.name }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >License Type</label
                                >
                                <p class="font-medium capitalize">
                                    {{ license.license_type }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Buyer Email</label
                                >
                                <p class="font-medium">
                                    {{ license.buyer_email }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Buyer Name</label
                                >
                                <p class="font-medium">
                                    {{ license.buyer_name || "N/A" }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Purchased At</label
                                >
                                <p class="font-medium">
                                    {{ formatDate(license.purchased_at) }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm text-secondary-500"
                                    >Support Until</label
                                >
                                <p class="font-medium">
                                    {{ formatDate(license.supported_until) }}
                                </p>
                            </div>
                        </div>

                        <div
                            v-if="license.notes"
                            class="pt-4 border-t border-secondary-200 dark:border-secondary-700"
                        >
                            <label class="block text-sm text-secondary-500"
                                >Notes</label
                            >
                            <p
                                class="text-secondary-700 dark:text-secondary-300"
                            >
                                {{ license.notes }}
                            </p>
                        </div>
                    </div>
                </Card>

                <!-- Stats -->
                <Card>
                    <template #header>
                        <span class="font-semibold">Usage Stats</span>
                    </template>

                    <div class="space-y-4">
                        <div class="text-center py-4">
                            <p class="text-4xl font-bold text-primary">
                                {{ stats.production_activations || 0 }}
                            </p>
                            <p class="text-sm text-secondary-500">
                                of {{ stats.domain_limit || 1 }} production
                                domains
                            </p>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-secondary-500"
                                    >Production</span
                                >
                                <span class="font-medium text-green-600">
                                    {{ stats.production_activations || 0 }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-500"
                                    >Local (Dev)</span
                                >
                                <span class="font-medium text-blue-600">
                                    {{ stats.local_activations || 0 }}
                                </span>
                            </div>
                            <div
                                class="pt-2 border-t border-secondary-200 dark:border-secondary-700 flex justify-between"
                            >
                                <span class="text-secondary-500"
                                    >Total Active</span
                                >
                                <span class="font-medium">
                                    {{ stats.total_activations || 0 }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-500"
                                    >Deactivated</span
                                >
                                <span class="font-medium text-secondary-500">
                                    {{
                                        license.activations?.filter(
                                            (a) => a.status === "deactivated",
                                        ).length || 0
                                    }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-500">Blocked</span>
                                <span class="font-medium text-red-600">
                                    {{
                                        license.activations?.filter(
                                            (a) => a.status === "blocked",
                                        ).length || 0
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>

            <!-- Activations List -->
            <Card>
                <template #header>
                    <div class="flex items-center gap-2">
                        <GlobeAltIcon class="w-5 h-5 text-primary" />
                        <span class="font-semibold">Domain Activations</span>
                    </div>
                </template>

                <div
                    v-if="license.activations?.length"
                    class="divide-y divide-secondary-200 dark:divide-secondary-700"
                >
                    <div
                        v-for="activation in license.activations"
                        :key="activation.id"
                        class="py-4 flex items-center justify-between"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                :class="[
                                    'p-2 rounded-lg',
                                    activation.is_local
                                        ? 'bg-blue-100 dark:bg-blue-900/30'
                                        : 'bg-secondary-100 dark:bg-secondary-800',
                                ]"
                            >
                                <GlobeAltIcon
                                    :class="[
                                        'w-5 h-5',
                                        activation.is_local
                                            ? 'text-blue-600'
                                            : 'text-secondary-600',
                                    ]"
                                />
                            </div>
                            <div>
                                <p class="font-medium">
                                    {{ activation.domain }}
                                </p>
                                <div
                                    class="flex items-center gap-2 text-sm text-secondary-500"
                                >
                                    <span
                                        v-if="activation.is_local"
                                        class="text-blue-600"
                                        >Local Dev</span
                                    >
                                    <span>{{
                                        formatDate(activation.activated_at)
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span
                                :class="[
                                    'px-2 py-1 rounded-full text-xs font-medium capitalize',
                                    getStatusBadge(activation.status),
                                ]"
                            >
                                {{ activation.status }}
                            </span>

                            <div
                                v-if="activation.status === 'active'"
                                class="flex gap-1"
                            >
                                <button
                                    @click="confirmDeactivate(activation)"
                                    class="p-1.5 rounded hover:bg-secondary-100 dark:hover:bg-secondary-700 text-secondary-600"
                                    title="Deactivate"
                                >
                                    <XCircleIcon class="w-5 h-5" />
                                </button>
                                <button
                                    @click="blockActivation(activation)"
                                    class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-danger"
                                    title="Block"
                                >
                                    <NoSymbolIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="py-8 text-center text-secondary-500">
                    No activations yet
                </div>
            </Card>

            <!-- Recent Verification Logs -->
            <Card v-if="license.verification_logs?.length">
                <template #header>
                    <div class="flex items-center gap-2">
                        <ClockIcon class="w-5 h-5 text-primary" />
                        <span class="font-semibold"
                            >Recent Verification Logs</span
                        >
                    </div>
                </template>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="border-b border-secondary-200 dark:border-secondary-700"
                            >
                                <th class="text-left py-2 px-4">Date</th>
                                <th class="text-left py-2 px-4">Action</th>
                                <th class="text-left py-2 px-4">Domain</th>
                                <th class="text-left py-2 px-4">Result</th>
                                <th class="text-left py-2 px-4">IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="log in license.verification_logs"
                                :key="log.id"
                                class="border-b border-secondary-100 dark:border-secondary-800"
                            >
                                <td class="py-2 px-4">
                                    {{ formatDate(log.created_at) }}
                                </td>
                                <td class="py-2 px-4 capitalize">
                                    {{ log.action }}
                                </td>
                                <td class="py-2 px-4">
                                    {{ log.domain || "N/A" }}
                                </td>
                                <td class="py-2 px-4">
                                    <span
                                        :class="[
                                            'px-2 py-0.5 rounded text-xs',
                                            log.success
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ]"
                                    >
                                        {{ log.success ? "Success" : "Failed" }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 text-secondary-500">
                                    {{ log.ip_address }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>

        <!-- Deactivate Modal -->
        <Modal
            :show="showDeactivateModal"
            title="Deactivate Domain"
            @close="showDeactivateModal = false"
        >
            <p>
                Are you sure you want to deactivate
                <strong>{{ deactivateTarget?.domain }}</strong
                >?
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeactivateModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="warning" @click="deactivateActivation"
                    >Deactivate</Button
                >
            </template>
        </Modal>
    </AdminLayout>
</template>
