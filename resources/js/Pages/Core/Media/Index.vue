<script setup>
import { ref } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import MediaController from "@/actions/App/Http/Controllers/Core/MediaController";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Pagination from "@/Components/Data/Pagination.vue";
import FileUpload from "@/Components/Form/FileUpload.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import { DocumentIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    media: Object,
});

const toast = useToast();
const showUploadModal = ref(false);

const uploadForm = useForm({
    filepond: null,
});

const submitUpload = () => {
    uploadForm.post(MediaController.store.url(), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Media uploaded successfully");
            showUploadModal.value = false;
            uploadForm.reset();
        },
        onError: () => {
            toast.error("Failed to upload media");
        },
    });
};

const deleteMedia = (id) => {
    if (!confirm("Are you sure you want to delete this file?")) return;

    router.delete(MediaController.destroy.url({ medium: id }), {
        onSuccess: () => toast.success("File deleted"),
        onError: () => toast.error("Failed to delete file"),
    });
};

const copyUrl = (url) => {
    navigator.clipboard.writeText(url);
    toast.info("URL copied to clipboard");
};
</script>

<template>
    <AdminLayout title="Media Library">
        <Head title="Media Library" />

        <Card>
            <template #header>
                <div class="flex justify-between items-center w-full">
                    <span class="font-semibold text-lg">Media Library</span>
                    <Button @click="showUploadModal = true" variant="primary">
                        Upload Media
                    </Button>
                </div>
            </template>

            <div
                v-if="media.data.length === 0"
                class="text-center py-8 text-gray-500"
            >
                No media files found. Upload some files to get started.
            </div>

            <div
                v-else
                class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4"
            >
                <div
                    v-for="item in media.data"
                    :key="item.id"
                    class="group relative border rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 aspect-square flex items-center justify-center shadow-sm hover:shadow-md transition-shadow"
                >
                    <img
                        v-if="item.mime_type.startsWith('image/')"
                        :src="item.original_url"
                        :alt="item.name"
                        class="object-cover w-full h-full"
                    />
                    <div
                        v-else
                        class="text-gray-500 flex flex-col items-center"
                    >
                        <DocumentIcon class="w-12 h-12 mb-2" />
                        <span class="text-xs truncate px-2 text-center">{{
                            item.file_name
                        }}</span>
                    </div>

                    <!-- Overlay Actions -->
                    <div
                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2"
                    >
                        <Button
                            size="sm"
                            variant="secondary"
                            @click="copyUrl(item.original_url)"
                        >
                            Copy URL
                        </Button>
                        <Button
                            size="sm"
                            variant="danger"
                            @click="deleteMedia(item.id)"
                        >
                            Delete
                        </Button>
                    </div>

                    <div
                        class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-1 truncate text-center"
                    >
                        {{ item.name }}
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <Pagination :links="media.links" />
            </div>
        </Card>

        <Modal
            :show="showUploadModal"
            title="Upload Media"
            @close="showUploadModal = false"
        >
            <div class="p-4">
                <FileUpload
                    v-model="uploadForm.filepond"
                    label="Select File"
                    :error="uploadForm.errors.filepond"
                    :max-file-size="10240"
                    allowed-extensions="jpg,jpeg,png,gif,webkit,pdf,doc,docx,zip"
                />
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button
                        variant="outline-secondary"
                        @click="showUploadModal = false"
                        >Cancel</Button
                    >
                    <Button
                        :disabled="!uploadForm.filepond"
                        variant="primary"
                        @click="submitUpload"
                    >
                        Save
                    </Button>
                </div>
            </template>
        </Modal>
    </AdminLayout>
</template>
