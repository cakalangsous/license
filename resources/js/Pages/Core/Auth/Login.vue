<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import FormInput from "@/Components/Form/FormInput.vue";
import Button from "@/Components/UI/Button.vue";

defineProps({
    appName: String,
    appLogo: String,
    appLogoDark: String,
    title: {
        type: String,
        default: "Login",
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post("/admin/login", {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head :title="title" />
    <div class="min-h-screen flex">
        <!-- Left side - Image -->
        <div
            class="hidden lg:block lg:w-1/2 bg-linear-to-br from-primary-500 to-primary-700"
        >
            <div class="flex items-center justify-center h-full">
                <div class="text-center text-white p-8">
                    <h2 class="text-4xl font-bold mb-4">Welcome Back</h2>
                    <p class="text-lg opacity-90">
                        Login to access the admin portal
                    </p>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-body-bg dark:bg-secondary-900"
        >
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="mb-8 text-center">
                    <Link href="/" class="inline-block">
                        <img
                            v-if="appLogo"
                            :src="appLogo"
                            :alt="appName"
                            class="h-12 mx-auto object-contain dark:hidden"
                        />
                        <img
                            v-if="appLogoDark || appLogo"
                            :src="appLogoDark || appLogo"
                            :alt="appName"
                            class="h-12 mx-auto object-contain hidden dark:block"
                        />
                        <p
                            v-if="!appLogo"
                            class="text-4xl font-bold text-center text-primary"
                        >
                            {{ appName }}
                        </p>
                    </Link>
                </div>

                <h1
                    class="text-3xl font-bold text-heading dark:text-white mb-2"
                >
                    Log in
                </h1>
                <p class="text-secondary-500 mb-8">
                    Please login to access the admin portal.
                </p>

                <!-- Error Alert -->
                <div
                    v-if="$page.props.errors?.login"
                    class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-300"
                >
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        {{ $page.props.errors.login }}
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <!-- Email -->
                    <FormInput
                        v-model="form.email"
                        type="email"
                        label="Email"
                        placeholder="Enter your email"
                        :error="form.errors.email"
                        required
                    />

                    <!-- Password -->
                    <FormInput
                        v-model="form.password"
                        type="password"
                        label="Password"
                        placeholder="Enter your password"
                        :error="form.errors.password"
                        required
                        class="mt-4"
                    />

                    <!-- Remember Me -->
                    <div class="flex items-center mt-4 mb-6">
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            id="remember"
                            class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500"
                        />
                        <label
                            for="remember"
                            class="ml-2 text-sm text-secondary-600 dark:text-secondary-400"
                        >
                            Keep me logged in
                        </label>

                        <Link
                            href="/forgot-password"
                            class="ml-auto text-sm text-secondary-600 hover:text-secondary-900 dark:text-secondary-400 dark:hover:text-white underline"
                        >
                            Forgot your password?
                        </Link>
                    </div>

                    <!-- Submit -->
                    <Button
                        type="submit"
                        variant="primary"
                        size="lg"
                        :loading="form.processing"
                        class="w-full"
                    >
                        Log in
                    </Button>
                </form>
            </div>
        </div>
    </div>
</template>
