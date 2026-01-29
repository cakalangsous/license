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
        default: "Create User",
    },
    roles: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    roles: [],
    filepond: null,
});

const roleOptions = computed(() =>
    props.roles.map((r) => ({ value: r.name, label: r.name })),
);

const submit = () => {
    form.post("/admin/users", {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Card title="Create New User" class="max-w-2xl">
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
                    label="Avatar"
                    v-model="form.filepond"
                    :error="form.errors.filepond"
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
                    :error="form.errors.password"
                    required
                />

                <FormInput
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    type="password"
                    :error="form.errors.password_confirmation"
                    required
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
                        Create User
                    </Button>
                    <Link href="/admin/users" class="btn btn-outline-secondary">
                        Cancel
                    </Link>
                </div>
            </form>
        </Card>
    </AdminLayout>
</template>
