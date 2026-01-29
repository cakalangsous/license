<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { XMarkIcon, InformationCircleIcon } from "@heroicons/vue/24/outline";
import { ref } from "vue";

const page = usePage();
const isDismissed = ref(false);

const isDemo = computed(() => page.props.isDemo);

const dismiss = () => {
    isDismissed.value = true;
};
</script>

<template>
    <div
        v-if="isDemo && !isDismissed"
        class="bg-linear-to-r from-amber-500 to-orange-500 text-white px-4 py-2 relative"
    >
        <div
            class="max-w-7xl mx-auto flex items-center justify-center gap-2 text-sm font-medium"
        >
            <InformationCircleIcon class="w-5 h-5 shrink-0" />
            <span>
                This is a demo version. Data resets daily.
                <strong>Demo credentials:</strong> demo@demo.com / demo123
            </span>
            <button
                @click="dismiss"
                class="absolute right-4 top-1/2 -translate-y-1/2 p-1 hover:bg-white/20 rounded-full transition-colors"
                title="Dismiss"
            >
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>
