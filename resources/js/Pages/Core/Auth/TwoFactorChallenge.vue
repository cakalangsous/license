<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import { ref, nextTick } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import TwoFactorChallengeController from "@/actions/App/Http/Controllers/Core/Auth/TwoFactorChallengeController";

const recovery = ref(false);
const form = useForm({
    code: "",
    recovery_code: "",
});

const codeInput = ref(null);
const recoveryCodeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value = !recovery.value;
    form.code = "";
    form.recovery_code = "";

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value?.focus();
    } else {
        codeInput.value?.focus();
    }
};

const submit = () => {
    form.post(TwoFactorChallengeController.store.url(), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Two-factor Confirmation" />

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            <template v-if="!recovery">
                Please confirm access to your account by entering the
                authentication code provided by your authenticator application.
            </template>
            <template v-else>
                Please confirm access to your account by entering one of your
                emergency recovery codes.
            </template>
        </div>

        <form @submit.prevent="submit">
            <div v-if="!recovery">
                <FormInput
                    v-model="form.code"
                    id="code"
                    type="text"
                    label="Code"
                    inputmode="numeric"
                    ref="codeInput"
                    autofocus
                    autocomplete="one-time-code"
                    :error="form.errors.code"
                />
            </div>

            <div v-else>
                <FormInput
                    v-model="form.recovery_code"
                    id="recovery_code"
                    type="text"
                    label="Recovery Code"
                    ref="recoveryCodeInput"
                    autocomplete="one-time-code"
                    :error="form.errors.recovery_code"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button
                    type="button"
                    class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer dark:text-gray-400"
                    @click.prevent="toggleRecovery"
                >
                    <template v-if="!recovery"> Use a recovery code </template>
                    <template v-else> Use an authentication code </template>
                </button>

                <Button class="ml-4" :loading="form.processing">
                    Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
