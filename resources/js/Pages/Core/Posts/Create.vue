<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import RichEditor from "@/Components/Form/RichEditor.vue";
import FileUpload from "@/Components/Form/FileUpload.vue";
import { useToast } from "vue-toastification";
import posts from "@/routes/admin/posts";

const props = defineProps({
    title: {
        type: String,
        default: "Create Post",
    },
    categories: {
        type: Array,
        default: () => [],
    },
    tags: {
        type: Array,
        default: () => [],
    },
});

const toast = useToast();

const form = useForm({
    title: "",
    slug: "",
    body: "",
    excerpt: "",
    category: "",
    tags: [],
    filepond: "", // This will hold the folder ID from FileUpload
    allow_comments: true,
    meta_description: "",
    meta_keywords: "",
    publish_status: 0, // 0: Draft, 1: Publish
});

const updateSlug = () => {
    form.slug = form.title.toLowerCase().replace(/\s+/g, "-");
};

const submit = () => {
    form.post(posts.store.url(), {
        onSuccess: () => {
            toast.success("Post created successfully");
        },
    });
};

const publishOptions = [
    { value: 0, label: "Draft" },
    { value: 1, label: "Publish" },
];
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-8">
                    <Card class="mb-4">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 pb-0"
                        >
                            <h4
                                class="text-lg font-medium text-gray-900 dark:text-gray-100"
                            >
                                {{ title }}
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <FormInput
                                    v-model="form.title"
                                    label="Title"
                                    placeholder="Post Title"
                                    required
                                    :error="form.errors.title"
                                    @input="updateSlug"
                                />

                                <RichEditor
                                    v-model="form.body"
                                    label="Body"
                                    :error="form.errors.body"
                                />
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-4">
                    <Card class="mb-4">
                        <div class="p-6 space-y-4">
                            <FormInput
                                v-model="form.slug"
                                label="Slug"
                                placeholder="slug"
                                required
                                :error="form.errors.slug"
                            />

                            <FileUpload
                                v-model="form.filepond"
                                label="Image"
                                :error="form.errors.filepond"
                            />

                            <FormSelect
                                v-model="form.category"
                                label="Category"
                                :options="categories"
                                value-key="id"
                                label-key="name"
                                placeholder="Select Category"
                                required
                                :error="form.errors.category"
                            />

                            <MultiSelect
                                v-model="form.tags"
                                label="Tags"
                                :options="tags"
                                value-key="id"
                                label-key="name"
                                placeholder="Select tags..."
                                :error="form.errors.tags"
                            />

                            <div class="flex items-center my-4">
                                <input
                                    class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    type="checkbox"
                                    id="allow_comments"
                                    v-model="form.allow_comments"
                                />
                                <label
                                    class="ml-2 text-sm text-gray-900 dark:text-gray-100"
                                    for="allow_comments"
                                >
                                    Switch off to disable comments
                                </label>
                            </div>

                            <div class="">
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Excerpt</label
                                >
                                <textarea
                                    v-model="form.excerpt"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"
                                    rows="3"
                                ></textarea>
                                <p
                                    v-if="form.errors.excerpt"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.excerpt }}
                                </p>
                            </div>

                            <div class="">
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Meta Description</label
                                >
                                <textarea
                                    v-model="form.meta_description"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white"
                                    rows="3"
                                ></textarea>
                                <p
                                    v-if="form.errors.meta_description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.meta_description }}
                                </p>
                            </div>

                            <FormInput
                                v-model="form.meta_keywords"
                                label="Meta Keywords"
                                placeholder="Keywords"
                                :error="form.errors.meta_keywords"
                            />

                            <FormSelect
                                v-model="form.publish_status"
                                label="Publish Status"
                                :options="publishOptions"
                                :error="form.errors.publish_status"
                            />

                            <div class="mt-6">
                                <Button
                                    type="submit"
                                    class="w-full justify-center"
                                    :loading="form.processing"
                                >
                                    Submit
                                </Button>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
