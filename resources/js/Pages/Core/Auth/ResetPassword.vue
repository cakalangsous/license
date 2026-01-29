<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import FormInput from "@/Components/Form/FormInput.vue";
import Button from "@/Components/UI/Button.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post("/reset-password", {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Reset Password" />
    <div
        class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-secondary-900 p-4"
    >
        <div
            class="w-full max-w-md bg-white dark:bg-secondary-800 rounded-lg shadow-md p-8"
        >
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Reset Password
                </h1>
            </div>

            <form @submit.prevent="submit">
                <FormInput
                    v-model="form.email"
                    type="email"
                    label="Email"
                    placeholder="Enter your email"
                    :error="form.errors.email"
                    required
                    autofocus
                    class="mb-4"
                />

                <FormInput
                    v-model="form.password"
                    type="password"
                    label="Password"
                    placeholder="New password"
                    :error="form.errors.password"
                    required
                    class="mb-4"
                />

                <FormInput
                    v-model="form.password_confirmation"
                    type="password"
                    label="Confirm Password"
                    placeholder="Confirm new password"
                    :error="form.errors.password_confirmation"
                    required
                    class="mb-6"
                />

                <div class="flex items-center justify-end">
                    <Button
                        type="submit"
                        :loading="form.processing"
                        class="w-full"
                    >
                        Reset Password
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
