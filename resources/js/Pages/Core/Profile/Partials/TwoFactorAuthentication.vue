<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import axios from "axios";
import TwoFactorController from "@/actions/App/Http/Controllers/Core/TwoFactorController";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";

const props = defineProps({
    user: Object,
});

const toast = useToast();
const enabling = ref(false);
const qrCode = ref(null);
const secret = ref(null);
const recoveryCodes = ref([]);
const showingRecoveryCodes = ref(false);

const confirmForm = useForm({
    code: "",
    secret: "",
});

const disableForm = useForm({
    password: "",
});

const showDisableModal = ref(false);

const enableTwoFactorAuthentication = async () => {
    enabling.value = true;

    try {
        const response = await axios.post(TwoFactorController.enable.url());
        qrCode.value = response.data.svg;
        confirming.value = true;
    } catch (error) {
        console.error("Failed to enable 2FA", error);
        toast.error("Failed to generate 2FA secret.");
    } finally {
        enabling.value = false;
    }
};

const confirmTwoFactorAuthentication = () => {
    confirmForm.post(TwoFactorController.confirm.url(), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupProps.value = true; // Updates parent props via inertia reload usually, but here we might need to handle state
            toast.success("Two factor authentication enabled.");
            showRecoveryCodes();
        },
    });
};

const fetchRecoveryCodes = () => {
    // This would need a password prompt modal.
    // For now, let's skip complex password prompt for recovery codes view in this step and focus on Enable/Disable.
    // We can implement recursive password prompt later or use a unified password confirm modal.

    axios
        .post(TwoFactorController.recoveryCodes.url(), {
            password: prompt("Please confirm your password"),
        })
        .then((response) => {
            recoveryCodes.value = response.data;
            showingRecoveryCodes.value = true;
        })
        .catch((error) => {
            toast.error("Invalid password or failed to fetch codes.");
        });
};

const disableTwoFactor = () => {
    disableForm.delete(route("admin.two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
            showDisableModal.value = false;
            toast.success("Two factor authentication disabled.");
            disableForm.reset();
        },
    });
};
</script>

<template>
    <Card title="Two Factor Authentication">
        <div v-if="!user.two_factor_confirmed_at && !enabling">
            <p class="text-sm text-gray-600 mb-4">
                Add additional security to your account using two factor
                authentication.
            </p>
            <Button @click="enableTwoFactorAuthentication">Enable 2FA</Button>
        </div>

        <div v-else-if="enabling">
            <div class="mb-4">
                <p class="font-semibold mb-2">
                    Scan this QR code with your authenticator app:
                </p>
                <div v-html="qrCode" class="bg-white p-4 inline-block"></div>
                <div class="mt-2 text-sm text-gray-600">
                    Or enter this key manually: <strong>{{ secret }}</strong>
                </div>
            </div>

            <form @submit.prevent="confirmTwoFactor" class="space-y-4 max-w-xs">
                <FormInput
                    v-model="confirmForm.code"
                    label="Verification Code"
                    :error="confirmForm.errors.code"
                    placeholder="123456"
                    required
                />
                <div class="flex gap-2">
                    <Button type="submit" :loading="confirmForm.processing"
                        >Confirm</Button
                    >
                    <Button variant="secondary" @click="enabling = false"
                        >Cancel</Button
                    >
                </div>
            </form>
        </div>

        <div v-else>
            <p class="text-sm text-green-600 mb-4 font-semibold">
                Two factor authentication is enabled.
            </p>

            <div class="flex gap-2">
                <Button variant="outline-secondary" @click="fetchRecoveryCodes"
                    >Show Recovery Codes</Button
                >
                <Button variant="danger" @click="showDisableModal = true"
                    >Disable 2FA</Button
                >
            </div>

            <div
                v-if="showingRecoveryCodes"
                class="mt-4 p-4 bg-gray-100 rounded text-sm"
            >
                <p class="font-bold mb-2">Recovery Codes:</p>
                <ul class="grid grid-cols-2 gap-2">
                    <li
                        v-for="code in recoveryCodes"
                        :key="code"
                        class="font-mono"
                    >
                        {{ code }}
                    </li>
                </ul>
                <Button
                    size="xs"
                    variant="text"
                    class="mt-2"
                    @click="showingRecoveryCodes = false"
                    >Hide</Button
                >
            </div>
        </div>

        <!-- Disable Confirmation Modal -->
        <Modal
            :show="showDisableModal"
            title="Disable Two Factor Authentication"
            @close="showDisableModal = false"
        >
            <div class="space-y-4">
                <p>
                    Are you sure you want to disable 2FA? This will lower your
                    account security.
                </p>
                <FormInput
                    v-model="disableForm.password"
                    type="password"
                    label="Confirm Password"
                    :error="disableForm.errors.password"
                    required
                />
            </div>
            <template #footer>
                <Button variant="secondary" @click="showDisableModal = false"
                    >Cancel</Button
                >
                <Button
                    variant="danger"
                    :loading="disableForm.processing"
                    @click="disableTwoFactor"
                    >Disable</Button
                >
            </template>
        </Modal>
    </Card>
</template>
