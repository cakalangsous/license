<script setup>
import { watch, computed } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";

const props = defineProps({
    show: Boolean,
    title: String,
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg", "xl"].includes(value),
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    zIndex: {
        type: String,
        default: "z-50",
    },
});

const emit = defineEmits(["close"]);

const sizeClasses = {
    sm: "max-w-md",
    md: "max-w-lg",
    lg: "max-w-2xl",
    xl: "max-w-4xl",
};

const dialogClasses = computed(() => `relative ${props.zIndex}`);

const close = () => {
    if (props.closeable) {
        emit("close");
    }
};

// Handle escape key
watch(
    () => props.show,
    (show) => {
        if (show) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "";
        }
    },
);
</script>

<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" :class="dialogClasses" @close="close">
            <!-- Backdrop -->
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/50" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full transform overflow-hidden rounded-lg bg-white dark:bg-secondary-800 shadow-xl transition-all"
                            :class="sizeClasses[size]"
                        >
                            <!-- Header -->
                            <div
                                v-if="title || $slots.header"
                                class="px-6 py-4 border-b border-secondary-100 dark:border-secondary-700 flex items-center justify-between"
                            >
                                <DialogTitle
                                    class="text-lg font-semibold text-heading dark:text-white"
                                >
                                    <slot name="header">{{ title }}</slot>
                                </DialogTitle>
                                <button
                                    v-if="closeable"
                                    @click="close"
                                    class="p-1 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5 text-secondary-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="p-6">
                                <slot />
                            </div>

                            <!-- Footer -->
                            <div
                                v-if="$slots.footer"
                                class="px-6 py-4 border-t border-secondary-100 dark:border-secondary-700 flex justify-end gap-3"
                            >
                                <slot name="footer" />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
