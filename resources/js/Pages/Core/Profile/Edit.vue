<script setup>
import { computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FileUpload from "@/Components/Form/FileUpload.vue";
import Avatar from "@/Components/UI/Avatar.vue";
import TwoFactorAuthentication from "./Partials/TwoFactorAuthentication.vue";

const props = defineProps({
    title: {
        type: String,
        default: "My Profile",
    },
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    avatar: null, // For file input
    filepond: null, // If handling filepond
    timezone: props.user.timezone || "",
    locale: props.user.locale || "",
});

const passwordForm = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const avatarUrl = computed(() => {
    if (props.user.avatar) {
        if (props.user.avatar.startsWith("http")) {
            return props.user.avatar;
        }
        // Ensure leading slash and check if it needs 'storage/' prefix based on how it's saved
        // The saved path is 'admin/filename.jpg', correct public path is '/storage/admin/filename.jpg'
        return props.user.avatar.startsWith("/")
            ? props.user.avatar
            : "/" + props.user.avatar;
    }
    return "/assets/images/faces/2.jpg"; // Default
});

const submitProfile = () => {
    form.post("/admin/profile/update", {
        preserveScroll: true,
        onSuccess: () => {
            // Handle success info if needed, or rely on flash message
        },
    });
};

const submitPassword = () => {
    passwordForm.put("/admin/profile/password", {
        preserveScroll: true,
        onSuccess: () => passwordForm.reset(),
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Profile Card -->
            <Card class="lg:col-span-1">
                <div class="flex flex-col items-center text-center">
                    <Avatar :src="avatarUrl" size="2xl" :alt="user.name" />
                    <h3
                        class="mt-4 text-xl font-bold text-heading dark:text-white"
                    >
                        {{ user.name }}
                    </h3>
                    <p class="text-secondary-500">{{ user.email }}</p>
                    <p
                        v-if="user.last_login"
                        class="text-sm text-secondary-400 mt-2"
                    >
                        Last login:
                        {{ new Date(user.last_login).toLocaleString() }}
                    </p>

                    <div class="mt-4 w-full">
                        <div
                            class="p-3 bg-gray-50 dark:bg-secondary-800 rounded-lg text-left"
                        >
                            <span
                                class="text-xs uppercase font-semibold text-gray-500"
                                >Roles</span
                            >
                            <div class="flex flex-wrap gap-1 mt-1">
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    class="px-2 py-0.5 text-xs rounded-full bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300"
                                >
                                    {{ role.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </Card>

            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Settings -->
                <Card title="Profile Settings">
                    <form @submit.prevent="submitProfile" class="space-y-4">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Timezone</label
                                >
                                <select
                                    v-model="form.timezone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                >
                                    <option value="" disabled>
                                        Select Timezone
                                    </option>
                                    <option
                                        v-for="tz in $page.props.timezones"
                                        :key="tz"
                                        :value="tz"
                                    >
                                        {{ tz }}
                                    </option>
                                </select>
                                <p
                                    v-if="form.errors.timezone"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.timezone }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Locale</label
                                >
                                <select
                                    v-model="form.locale"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                >
                                    <option value="" disabled>
                                        Select Locale
                                    </option>
                                    <option
                                        v-for="(label, key) in $page.props
                                            .locales"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ label }}
                                    </option>
                                </select>
                                <p
                                    v-if="form.errors.locale"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.locale }}
                                </p>
                            </div>
                        </div>

                        <!-- Avatar Input (FilePond) -->
                        <div class="mb-4">
                            <FileUpload
                                label="Avatar"
                                v-model="form.filepond"
                                :error="form.errors.filepond"
                                :existing-files="avatarUrl"
                                :accepted-file-types="[
                                    'image/jpeg',
                                    'image/png',
                                    'image/jpg',
                                ]"
                            />
                        </div>

                        <div class="flex justify-end pt-4">
                            <Button type="submit" :loading="form.processing">
                                Save Profile
                            </Button>
                        </div>
                    </form>
                </Card>

                <!-- Password Update -->
                <Card title="Update Password">
                    <form @submit.prevent="submitPassword" class="space-y-4">
                        <FormInput
                            v-model="passwordForm.current_password"
                            label="Current Password"
                            type="password"
                            :error="passwordForm.errors.current_password"
                            required
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <FormInput
                                v-model="passwordForm.password"
                                label="New Password"
                                type="password"
                                :error="passwordForm.errors.password"
                                required
                            />

                            <FormInput
                                v-model="passwordForm.password_confirmation"
                                label="Confirm New Password"
                                type="password"
                                :error="
                                    passwordForm.errors.password_confirmation
                                "
                                required
                            />
                        </div>

                        <div class="flex justify-end pt-4">
                            <Button
                                type="submit"
                                :loading="passwordForm.processing"
                            >
                                Update Password
                            </Button>
                        </div>
                    </form>
                </Card>

                <!-- Two Factor Authentication -->
                <TwoFactorAuthentication :user="user" />
            </div>
        </div>
    </AdminLayout>
</template>
