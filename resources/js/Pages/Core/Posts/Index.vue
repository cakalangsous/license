<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import LinkButton from "@/Components/UI/LinkButton.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import Badge from "@/Components/UI/Badge.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import posts from "@/routes/admin/posts";

const props = defineProps({
    title: {
        type: String,
        default: "Posts",
    },
    paginatedPosts: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const columns = [
    { key: "title", label: "Title", sortable: true },
    { key: "category", label: "Category", sortable: false },
    { key: "tags", label: "Tags", sortable: false },
    { key: "publish_status", label: "Status", sortable: false },
    { key: "published_at", label: "Published At", sortable: true },
    { key: "action", label: "Action", sortable: false, searchable: false },
];

// Delete confirmation
const showDeleteModal = ref(false);
const deleteTarget = ref(null);

const confirmDelete = (post) => {
    deleteTarget.value = post;
    showDeleteModal.value = true;
};

const deletePost = () => {
    if (deleteTarget.value) {
        router.delete(posts.destroy.url({ post: deleteTarget.value.id }), {
            onSuccess: () => {
                toast.success("Post deleted successfully");
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
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold">All Posts</span>
                    <LinkButton :href="posts.create.url()" variant="primary">
                        Add New
                    </LinkButton>
                </div>
            </template>

            <DataTable :paginated-data="paginatedPosts" :columns="columns">
                <!-- Custom cell for publish status -->
                <template #cell-publish_status="{ value }">
                    <Badge
                        :variant="value === 'Published' ? 'success' : 'warning'"
                    >
                        {{ value }}
                    </Badge>
                </template>

                <!-- Custom cell for actions -->
                <template #cell-action="{ row }">
                    <div class="flex items-center gap-2">
                        <LinkButton
                            :href="posts.edit.url({ post: row.id })"
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
            title="Delete Post"
            @close="showDeleteModal = false"
        >
            <p>
                Are you sure you want to delete post
                <strong>{{ deleteTarget?.title }}</strong
                >? This action cannot be undone.
            </p>
            <template #footer>
                <Button
                    variant="outline-secondary"
                    @click="showDeleteModal = false"
                    class="mr-2"
                    >Cancel</Button
                >
                <Button variant="danger" @click="deletePost">Delete</Button>
            </template>
        </Modal>
    </AdminLayout>
</template>
