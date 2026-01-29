<script setup>
import { ref, computed, watch } from "vue";
import draggable from "vuedraggable";
import SidebarMenuItem from "./SidebarMenuItem.vue";

const props = defineProps({
    menus: {
        type: Array,
        required: true,
    },
    section: {
        type: String,
        required: true,
    },
    depth: {
        type: Number,
        default: 0,
    },
    parentId: {
        type: Number,
        default: null,
    },
});

const emit = defineEmits([
    "edit",
    "delete",
    "add-child",
    "toggle-active",
    "update-structure",
]);

// Local copy of menus for draggable
const localMenus = ref([...props.menus]);

// Sync when props change from server
watch(
    () => props.menus,
    (newMenus) => {
        localMenus.value = [...newMenus];
    },
    { deep: true },
);

// When drag ends (reorder within same list OR move between lists)
const handleChange = (evt) => {
    // Only handle when actually changing something
    if (evt.added || evt.moved || evt.removed) {
        // Build the update payload - this list's current state
        const items = localMenus.value.map((menu, index) => ({
            id: menu.id,
            parent_id: props.parentId,
            order: index,
            section: props.section,
        }));

        emit("update-structure", items);
    }
};

const dragOptions = computed(() => ({
    animation: 200,
    group: "nested-menus", // Same group allows cross-list dragging
    ghostClass: "sortable-ghost",
    chosenClass: "sortable-chosen",
    dragClass: "sortable-drag",
    handle: ".drag-handle",
    fallbackOnBody: true,
    swapThreshold: 0.65,
    emptyInsertThreshold: 10,
}));
</script>

<template>
    <draggable
        v-model="localMenus"
        v-bind="dragOptions"
        item-key="id"
        class="menu-list"
        :class="{
            'ml-6 pl-3 border-l-2 border-primary-300 dark:border-primary-600':
                depth > 0,
        }"
        @change="handleChange"
    >
        <template #item="{ element: menu }">
            <SidebarMenuItem
                :menu="menu"
                :depth="depth"
                :section="section"
                :data-id="menu.id"
                @edit="emit('edit', $event)"
                @delete="emit('delete', $event)"
                @add-child="emit('add-child', $event)"
                @toggle-active="emit('toggle-active', $event)"
                @update-structure="emit('update-structure', $event)"
            />
        </template>
    </draggable>
</template>

<style scoped>
.menu-list {
    min-height: 20px;
}

/* Empty list drop zone indicator */
.menu-list:empty {
    min-height: 40px;
    background: rgba(99, 102, 241, 0.05);
    border: 2px dashed rgba(99, 102, 241, 0.3);
    border-radius: 6px;
    margin: 4px 0;
}

:deep(.sortable-ghost) {
    opacity: 0.4;
    background: linear-gradient(135deg, #dbeafe, #e0e7ff) !important;
    border-radius: 6px;
    border: 2px dashed #6366f1;
}

:deep(.sortable-chosen) {
    background: #f0f9ff !important;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
    border-radius: 6px;
}

:deep(.sortable-drag) {
    background: white !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    opacity: 1 !important;
}
</style>
