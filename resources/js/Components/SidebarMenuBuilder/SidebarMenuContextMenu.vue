<script setup>
import {
    TrashIcon,
    PencilSquareIcon,
    ArrowRightIcon,
    ArrowLeftIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    hasParent: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["edit", "delete", "add-child", "detach"]);
</script>

<template>
    <div
        class="absolute right-0 top-full mt-1 z-50 bg-white dark:bg-secondary-800 rounded-lg shadow-lg border border-secondary-200 dark:border-secondary-600 py-1 min-w-[160px]"
        @click.stop
    >
        <!-- Edit -->
        <button
            type="button"
            class="w-full flex items-center gap-2 px-4 py-2 text-left text-secondary-700 dark:text-secondary-300 hover:bg-secondary-50 dark:hover:bg-secondary-700 transition-colors"
            @click.stop="emit('edit')"
        >
            <PencilSquareIcon class="w-4 h-4" />
            Edit
        </button>

        <!-- Add Child -->
        <button
            type="button"
            class="w-full flex items-center gap-2 px-4 py-2 text-left text-secondary-700 dark:text-secondary-300 hover:bg-secondary-50 dark:hover:bg-secondary-700 transition-colors"
            @click.stop="emit('add-child')"
        >
            <ArrowRightIcon class="w-4 h-4" />
            Add child
        </button>

        <!-- Detach from Parent (only show if has parent) -->
        <button
            v-if="hasParent"
            type="button"
            class="w-full flex items-center gap-2 px-4 py-2 text-left text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors"
            @click.stop="emit('detach')"
        >
            <ArrowLeftIcon class="w-4 h-4" />
            Detach from parent
        </button>

        <!-- Delete -->
        <button
            type="button"
            class="w-full flex items-center gap-2 px-4 py-2 text-left text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
            @click.stop="emit('delete')"
        >
            <TrashIcon class="w-4 h-4" />
            Delete
        </button>
    </div>
</template>
