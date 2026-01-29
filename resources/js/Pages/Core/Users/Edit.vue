<script setup>
import { computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import FileUpload from "@/Components/Form/FileUpload.vue";

const props = defineProps({
    title: {
        type: String,
        default: "Edit User",
    },
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array,
        default: () => [],
    },
    user_roles: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: "",
    password_confirmation: "",
    roles: props.user_roles
        .map((id) => props.roles.find((r) => r.id === id)?.name)
        .filter(Boolean),
    filepond: null,
});

const roleOptions = computed(() =>
    props.roles.map((r) => ({ value: r.name, label: r.name })),
);

// Format existing avatar for FilePond if it exists
// FileUpload component expects a full URL or path that can be loaded
const existingAvatar = computed(() => {
    return props.user.avatar ? props.user.avatar : null;
});

const submit = () => {
    form.put(`/admin/users/${props.user.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Card title="Edit User" class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-4">
                <FormInput
                    v-model="form.name"
                    label="Name"
                    :error="form.errors.name"
                    required
                />

                <FormInput
                    v-model="form.email"
                    label="Email"
                    type="email"
                    :error="form.errors.email"
                    required
                />

                <FileUpload
                    label="Avatar (Leave empty if no changes)"
                    v-model="form.filepond"
                    :error="form.errors.filepond"
                    :existing-files="existingAvatar"
                    :accepted-file-types="[
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                    ]"
                />

                <FormInput
                    v-model="form.password"
                    label="Password"
                    type="password"
                    hint="Leave empty if no changes"
                    :error="form.errors.password"
                />

                <FormInput
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    type="password"
                    hint="Leave empty if no changes for password"
                    :error="form.errors.password_confirmation"
                />

                <MultiSelect
                    v-model="form.roles"
                    label="Roles"
                    :options="roles"
                    value-key="name"
                    label-key="name"
                    placeholder="Select roles..."
                    :error="form.errors.roles"
                    required
                />

                <div class="flex items-center gap-3 pt-4">
                    <Button type="submit" :loading="form.processing">
                        Save Changes
                    </Button>
                    <Link
                        href="/admin/users"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-secondary-800 dark:text-gray-300 dark:border-secondary-600 dark:hover:bg-secondary-700"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </Card>
    </AdminLayout>
</template>
