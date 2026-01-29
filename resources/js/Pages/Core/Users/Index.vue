<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import LinkButton from "@/Components/UI/LinkButton.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import Modal from "@/Components/UI/Modal.vue";
import Badge from "@/Components/UI/Badge.vue";
import { useToast } from "vue-toastification";
import users from "@/routes/admin/users";
import UserController from "@/actions/App/Http/Controllers/Core/UserController";

const props = defineProps({
    title: {
        type: String,
        default: "Users",
    },
    paginatedUsers: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "name", label: "Name", sortable: true },
    { key: "email", label: "Email", sortable: true },
    { key: "role", label: "Role", sortable: false },
    {
        key: "last_login",
        label: "Last Login",
        sortable: false,
        searchable: false,
    },
    { key: "is_banned", label: "Banned", sortable: false, searchable: false },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Delete confirmation
const showDeleteModal = ref(false);
const deleteTarget = ref(null);
const selectedIds = ref([]);

const bulkDelete = () => {
    if (
        confirm(
            `Are you sure you want to delete ${selectedIds.value.length} users?`,
        )
    ) {
        router.post(
            UserController.bulkDestroy.url(),
            {
                ids: selectedIds.value,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Users deleted successfully");
                    selectedIds.value = [];
                    // clear selection in datatable if needed, or it will reactively update
                },
                onError: () => {
                    toast.error("Failed to delete users");
                },
            },
        );
    }
};

const confirmDelete = (user) => {
    deleteTarget.value = user;
    showDeleteModal.value = true;
};

const deleteUser = () => {
    if (deleteTarget.value) {
        router.delete(users.destroy.url({ user: deleteTarget.value.id }), {
            onSuccess: () => {
                toast.success("User deleted successfully");
                showDeleteModal.value = false;
                deleteTarget.value = null;
            },
            onError: () => {
                toast.error("Failed to delete user");
            },
        });
    }
};

// Ban toggle
const toggleBan = (user) => {
    const action = user.is_banned ? "Unban" : "Ban";

    if (!confirm(`${action} user "${user.name}"?`)) return;

    router.post(
        users.toggle_ban.url({ user: user.id }),
        {},
        {
            onSuccess: () => {
                toast.success(`User ${action.toLowerCase()}ned successfully`);
            },
            onError: () => {
                toast.error("Failed to update status");
            },
        },
    );
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <Card>
            <template #header>
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold">{{ title }} List</span>
                    <div class="flex gap-2">
                        <Button
                            v-if="selectedIds.length > 0"
                            variant="danger"
                            @click="bulkDelete"
                        >
                            Delete ({{ selectedIds.length }})
                        </Button>
                        <LinkButton
                            :href="UserController.exportMethod.url()"
                            variant="outline-primary"
                        >
                            Export
                        </LinkButton>
                        <LinkButton
                            :href="users.create.url()"
                            variant="primary"
                        >
                            Add User
                        </LinkButton>
                    </div>
                </div>
            </template>

            <DataTable
                :paginated-data="paginatedUsers"
                :columns="columns"
                selectable
                v-model:selection="selectedIds"
            >
                <!-- Custom cell for role -->
                <template #cell-role="{ value }">
                    <Badge variant="primary">{{ value }}</Badge>
                </template>

                <!-- Custom cell for banned status -->
                <template #cell-is_banned="{ row, value }">
                    <label
                        class="relative inline-flex items-center cursor-pointer"
                    >
                        <input
                            type="checkbox"
                            :checked="value"
                            @change="toggleBan(row)"
                            class="sr-only peer"
                        />
                        <div
                            class="w-9 h-5 bg-secondary-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer dark:bg-secondary-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-secondary-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-secondary-600 peer-checked:bg-danger"
                        ></div>
                    </label>
                </template>

                <!-- Custom cell for actions -->
                <template #cell-action="{ row }">
                    <div class="flex items-center gap-2">
                        <LinkButton
                            :href="users.edit.url({ user: row.id })"
                            variant="outline-primary"
                            size="sm"
                        >
                            Edit
                        </LinkButton>
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

        <!-- Delete Confirmation Modal -->
        <Modal
            :show="showDeleteModal"
            title="Confirm Delete"
            @close="showDeleteModal = false"
        >
            <p class="text-secondary-600 dark:text-secondary-300">
                Are you sure you want to delete
                <strong>{{ deleteTarget?.name }}</strong
                >? This action cannot be undone.
            </p>

            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deleteUser">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
