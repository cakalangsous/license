<script setup>
import { ref, watch } from "vue";
import Modal from "@/Components/UI/Modal.vue";
import Button from "@/Components/UI/Button.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    multiple: Boolean,
});

const emit = defineEmits(["close", "select"]);

// We need to fetch media logic.
// Since this is a picker, we might need an API endpoint to search/list media
// without full page reload, or we pass media if loaded.
// For simplicity, we assume we fetch via axios or props if available.
// But mostly pickers load via API.
// We can use the already implemented MediaController index but via JSON?
// Or create a new endpoint 'api/media'.
// For now, let's just create the shell and assume it needs data.
// Wait, to make it functional we need data.
// We can use a simple prop or fetch on mount.

const mediaItems = ref([]);
const loading = ref(false);

const fetchMedia = async () => {
    loading.value = true;
    try {
        // Use an API route or inertia partial reload?
        // Let's assume we have an API route or reusing admin search.
        // For MVP, maybe just a placeholder or list latest if passed.
        // But `MediaController` returns Inertia response.
        // We probably need `MediaController::apiIndex` or similar.
    } finally {
        loading.value = false;
    }
};

const selected = ref([]);

const selectItem = (item) => {
    if (props.multiple) {
        if (selected.value.includes(item)) {
            selected.value = selected.value.filter((i) => i !== item);
        } else {
            selected.value.push(item);
        }
    } else {
        selected.value = [item];
    }
};

const confirmSelection = () => {
    emit("select", props.multiple ? selected.value : selected.value[0]);
    emit("close");
};
</script>

<template>
    <Modal :show="show" title="Select Media" @close="$emit('close')">
        <div class="p-4">
            <p class="text-gray-500">
                Media Picker functionality to be implemented with API
                integration.
            </p>
            <!-- Grid would go here -->
        </div>
        <template #footer>
            <Button variant="outline-secondary" @click="$emit('close')"
                >Cancel</Button
            >
            <Button variant="primary" @click="confirmSelection">Select</Button>
        </template>
    </Modal>
</template>
