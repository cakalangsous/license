<script setup>
import Modal from "./Modal.vue";
import Button from "./Button.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: "Confirm Action",
    },
    message: {
        type: String,
        default: "Are you sure you want to proceed?",
    },
    confirmText: {
        type: String,
        default: "Confirm",
    },
    cancelText: {
        type: String,
        default: "Cancel",
    },
    variant: {
        type: String,
        default: "danger",
        validator: (value) => ["danger", "warning", "info"].includes(value),
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["confirm", "cancel"]);

const iconColors = {
    danger: "text-red-500 bg-red-100 dark:bg-red-900/30",
    warning: "text-yellow-500 bg-yellow-100 dark:bg-yellow-900/30",
    info: "text-blue-500 bg-blue-100 dark:bg-blue-900/30",
};

const confirmButtonVariants = {
    danger: "danger",
    warning: "warning",
    info: "primary",
};
</script>

<template>
    <Modal :show="show" size="sm" @close="emit('cancel')">
        <div class="text-center">
            <!-- Icon -->
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4"
                :class="iconColors[variant]"
            >
                <!-- Danger Icon -->
                <svg
                    v-if="variant === 'danger'"
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                </svg>
                <!-- Warning Icon -->
                <svg
                    v-else-if="variant === 'warning'"
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                </svg>
                <!-- Info Icon -->
                <svg
                    v-else
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <!-- Title -->
            <h3
                class="text-lg font-semibold text-gray-900 dark:text-white mb-2"
            >
                {{ title }}
            </h3>

            <!-- Message -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                {{ message }}
            </p>

            <!-- Actions -->
            <div class="flex justify-center gap-3">
                <Button
                    variant="outline-secondary"
                    @click="emit('cancel')"
                    :disabled="loading"
                >
                    {{ cancelText }}
                </Button>
                <Button
                    :variant="confirmButtonVariants[variant]"
                    @click="emit('confirm')"
                    :loading="loading"
                >
                    {{ confirmText }}
                </Button>
            </div>
        </div>
    </Modal>
</template>
