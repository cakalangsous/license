<script setup>
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import { useToast } from "vue-toastification";
import { Cog6ToothIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Application Settings",
    },
    settings: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const form = useForm({
    app_name: props.settings.app_name?.value || "",
    meta_description: props.settings.meta_description?.value || "",
    meta_keywords: props.settings.meta_keywords?.value || "",
});

const submit = () => {
    form.put("/admin/settings/application", {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Application settings updated successfully");
        },
        onError: () => {
            toast.error("Failed to update settings");
        },
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="max-w-3xl">
            <Card>
                <template #header>
                    <div class="flex items-center gap-2">
                        <Cog6ToothIcon class="w-5 h-5 text-primary" />
                        <span class="font-semibold">Application Settings</span>
                    </div>
                </template>

                <form @submit.prevent="submit" class="space-y-6">
                    <FormInput
                        v-model="form.app_name"
                        label="Application Name"
                        placeholder="Enter application name"
                        :error="form.errors.app_name"
                        required
                    />

                    <FormTextarea
                        v-model="form.meta_description"
                        label="Meta Description"
                        placeholder="Enter meta description for SEO"
                        :error="form.errors.meta_description"
                        :rows="3"
                        help="This description appears in search engine results."
                    />

                    <FormInput
                        v-model="form.meta_keywords"
                        label="Meta Keywords"
                        placeholder="keyword1, keyword2, keyword3"
                        :error="form.errors.meta_keywords"
                        help="Comma-separated keywords for SEO."
                    />

                    <div
                        class="flex justify-end pt-4 border-t border-secondary-200 dark:border-secondary-700"
                    >
                        <Button
                            type="submit"
                            variant="primary"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Save Settings</span>
                        </Button>
                    </div>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>
