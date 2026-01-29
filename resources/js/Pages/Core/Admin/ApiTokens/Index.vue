<script setup>
import { ref, computed } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Modal from "@/Components/UI/Modal.vue";
import ConfirmationModal from "@/Components/UI/ConfirmationModal.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import {
    PlusIcon,
    TrashIcon,
    ClipboardDocumentIcon,
    CheckIcon,
} from "@heroicons/vue/24/outline";
import ApiTokenController from "@/actions/App/Http/Controllers/Core/ApiTokenController";

const props = defineProps({
    tokens: Array,
});

const page = usePage();
const creatingToken = ref(false);
const displayToken = ref(false);
const newlyCreatedToken = ref(null);
const copied = ref(false);
const confirmingDeletion = ref(false);
const tokenToDelete = ref(null);

const form = useForm({
    name: "",
    permissions: ["*"],
});

const deleteForm = useForm({});

const createToken = () => {
    form.post(ApiTokenController.store.url(), {
        preserveScroll: true,
        onSuccess: () => {
            creatingToken.value = false;
            displayToken.value = true;
            newlyCreatedToken.value = page.props.flash?.plainTextToken; // Access custom flash data
            form.reset();
        },
    });
};

const deleteToken = (token) => {
    tokenToDelete.value = token;
    confirmingDeletion.value = true;
};

const confirmDelete = () => {
    if (tokenToDelete.value) {
        deleteForm.delete(
            ApiTokenController.destroy.url(tokenToDelete.value.id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    confirmingDeletion.value = false;
                    tokenToDelete.value = null;
                },
            },
        );
    }
};

const cancelDelete = () => {
    confirmingDeletion.value = false;
    tokenToDelete.value = null;
};

const copyToken = () => {
    const token = newlyCreatedToken.value;
    if (!token) return;

    // Try modern clipboard API first
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(token).then(() => {
            copied.value = true;
            setTimeout(() => (copied.value = false), 2000);
        });
    } else {
        // Fallback for non-HTTPS contexts
        const textArea = document.createElement("textarea");
        textArea.value = token;
        textArea.style.position = "fixed";
        textArea.style.left = "-9999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand("copy");
            copied.value = true;
            setTimeout(() => (copied.value = false), 2000);
        } catch (err) {
            console.error("Failed to copy token:", err);
        }
        document.body.removeChild(textArea);
    }
};

const closeDisplayModal = () => {
    displayToken.value = false;
    newlyCreatedToken.value = null;
};
</script>

<template>
    <Head title="API Tokens" />

    <AdminLayout>
        <Card title="API Tokens">
            <template #header-actions>
                <Button @click="creatingToken = true" size="sm">
                    <PlusIcon class="w-4 h-4 mr-2" />
                    Create Token
                </Button>
            </template>

            <div class="overflow-x-auto">
                <table
                    class="w-full text-left text-sm text-gray-600 dark:text-gray-300"
                >
                    <thead
                        class="bg-gray-50 dark:bg-secondary-700 text-xs uppercase font-medium text-gray-500 dark:text-gray-400"
                    >
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Last Used</th>
                            <th class="px-6 py-3">Created</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-gray-200 dark:divide-secondary-600"
                    >
                        <tr v-if="tokens.length === 0">
                            <td
                                colspan="4"
                                class="px-6 py-4 text-center text-gray-500"
                            >
                                No API tokens found.
                            </td>
                        </tr>
                        <tr
                            v-for="token in tokens"
                            :key="token.id"
                            class="hover:bg-gray-50 dark:hover:bg-secondary-700"
                        >
                            <td class="px-6 py-4">{{ token.name }}</td>
                            <td class="px-6 py-4">{{ token.last_used_at }}</td>
                            <td class="px-6 py-4">{{ token.created_at }}</td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="deleteToken(token)"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                >
                                    <TrashIcon class="w-5 h-5" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <!-- Create Token Modal -->
        <Modal
            :show="creatingToken"
            title="Create API Token"
            @close="creatingToken = false"
        >
            <div class="space-y-4">
                <div>
                    <FormInput
                        v-model="form.name"
                        label="Token Name"
                        placeholder="My API Token"
                        :error="form.errors.name"
                        @keyup.enter="createToken"
                    />
                </div>
            </div>
            <template #footer>
                <Button
                    variant="secondary"
                    @click="creatingToken = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button @click="createToken" :disabled="form.processing"
                    >Create</Button
                >
            </template>
        </Modal>

        <!-- Display Token Modal -->
        <Modal
            :show="displayToken"
            title="API Token Generated"
            @close="closeDisplayModal"
        >
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Please copy your new API token. For your security, it won't
                    be shown again.
                </p>
                <div
                    class="relative bg-gray-50 dark:bg-secondary-800 border border-gray-200 dark:border-secondary-700 p-4 rounded-lg font-mono text-sm break-all text-gray-800 dark:text-gray-200 pr-14"
                >
                    {{ newlyCreatedToken }}
                    <button
                        @click="copyToken"
                        class="absolute top-1/2 -translate-y-1/2 right-3 p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-200 dark:text-gray-400 dark:hover:text-white dark:hover:bg-secondary-700 transition-colors"
                        title="Copy to clipboard"
                    >
                        <CheckIcon
                            v-if="copied"
                            class="w-5 h-5 text-green-500"
                        />
                        <ClipboardDocumentIcon v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>
            <template #footer>
                <Button @click="closeDisplayModal">Close</Button>
            </template>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <ConfirmationModal
            :show="confirmingDeletion"
            title="Delete API Token"
            :message="`Are you sure you want to delete the token '${tokenToDelete?.name}'? This action cannot be undone.`"
            confirm-text="Delete"
            variant="danger"
            :loading="deleteForm.processing"
            @confirm="confirmDelete"
            @cancel="cancelDelete"
        />
    </AdminLayout>
</template>
