<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import FormInput from "@/Components/Form/FormInput.vue";
import Button from "@/Components/UI/Button.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post("/forgot-password");
};
</script>

<template>
    <Head title="Forgot Password" />
    <div
        class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-secondary-900 p-4"
    >
        <div
            class="w-full max-w-md bg-white dark:bg-secondary-800 rounded-lg shadow-md p-8"
        >
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Forgot Password?
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                    Enter your email address and we'll send you a link to reset
                    your password.
                </p>
            </div>

            <div
                v-if="status"
                class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center"
            >
                {{ status }}
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
                />

                <div class="flex items-center justify-end mt-4">
                    <Button
                        type="submit"
                        :loading="form.processing"
                        class="w-full"
                    >
                        Email Password Reset Link
                    </Button>
                </div>

                <div class="mt-4 text-center">
                    <Link
                        href="/admin/login"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white underline"
                    >
                        Back to Login
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
