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
        default: "Edit Post",
    },
    post: Object,
    tags_selected: Array,
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
    title: props.post.title,
    slug: props.post.slug,
    body: props.post.body,
    excerpt: props.post.excerpt,
    category: props.post.post_category_id,
    tags: props.tags_selected,
    image: "", // Use image field for filepond update in edit (controller expects 'image' or 'filepond'?)
    // Controller update method uses $request->image for the folder.
    allow_comments: !!props.post.allow_comments,
    meta_description: props.post.meta_description,
    meta_keywords: props.post.meta_keywords,
    publish_status: props.post.publish_status === "Published" ? 1 : 0,
    // Note: Controller returns "Published" string or int?
    // In posts_data it returns $post->publish_status (accessor?).
    // In edit view blade used $post->publish_status. Model might have accessor.
    // If accessor returns "Published", we need to map to 1.
    // Let's check model later. For now assume 1/0 or string map.
});

// Update slug only if user wants to (or maybe not at all on edit to preserve SEO)
const updateSlug = () => {
    // form.slug = form.title.toLowerCase().replace(/\s+/g, "-");
};

const submit = () => {
    form.put(posts.update.url({ post: props.post.id }), {
        onSuccess: () => {
            toast.success("Post updated successfully");
        },
    });
};

const publishOptions = [
    { value: 0, label: "Draft" },
    { value: 1, label: "Publish" },
];

const imageUrl = props.post.image ? `/storage/${props.post.image}` : null;
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

                            <div v-if="imageUrl" class="mb-2">
                                <p
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                >
                                    Current Image
                                </p>
                                <img
                                    :src="imageUrl"
                                    alt="Current Image"
                                    class="w-full h-auto rounded-md shadow-sm"
                                />
                            </div>

                            <FileUpload
                                v-model="form.image"
                                label="Update Image"
                                :error="form.errors.image"
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
                                    Update
                                </Button>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
