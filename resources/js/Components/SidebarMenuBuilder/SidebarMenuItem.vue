<script setup>
import { ref, computed, watch } from "vue";
import draggable from "vuedraggable";
import SidebarMenuContextMenu from "./SidebarMenuContextMenu.vue";
import { Bars3Icon, Cog6ToothIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    menu: {
        type: Object,
        required: true,
    },
    depth: {
        type: Number,
        default: 0,
    },
    section: {
        type: String,
        required: true,
    },
});

const emit = defineEmits([
    "edit",
    "delete",
    "add-child",
    "toggle-active",
    "update-structure",
]);

// Local children for nested draggable
const localChildren = ref([...(props.menu.all_children || [])]);

watch(
    () => props.menu.all_children,
    (newChildren) => {
        localChildren.value = [...(newChildren || [])];
    },
    { deep: true },
);

const showContextMenu = ref(false);
let hideTimeout = null;

const handleMouseEnter = () => {
    if (hideTimeout) {
        clearTimeout(hideTimeout);
        hideTimeout = null;
    }
    showContextMenu.value = true;
};

const handleMouseLeave = () => {
    hideTimeout = setTimeout(() => {
        showContextMenu.value = false;
    }, 200);
};

const handleDoubleClick = () => {
    emit("toggle-active", props.menu);
};

const handleEdit = () => {
    showContextMenu.value = false;
    emit("edit", props.menu);
};

const handleDelete = () => {
    showContextMenu.value = false;
    emit("delete", props.menu);
};

const handleAddChild = () => {
    showContextMenu.value = false;
    emit("add-child", props.menu);
};

// When children list changes (item added/removed/reordered)
const handleChildrenChange = (evt) => {
    if (evt.added || evt.moved || evt.removed) {
        const items = localChildren.value.map((child, index) => ({
            id: child.id,
            parent_id: props.menu.id, // Children belong to this menu
            order: index,
            section: props.section,
        }));

        emit("update-structure", items);
    }
};

const dragOptions = computed(() => ({
    animation: 200,
    group: "nested-menus",
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
    <div
        class="menu-item-wrapper"
        :data-id="menu.id"
        :data-parent-id="menu.parent_id"
    >
        <!-- Menu Item -->
        <div
            class="menu-item flex items-center gap-3 px-4 py-3 border-b border-secondary-100 dark:border-secondary-700 hover:bg-secondary-50 dark:hover:bg-secondary-700/50 transition-colors"
            :class="{
                'opacity-50': !menu.is_active,
            }"
            @dblclick="handleDoubleClick"
        >
            <!-- Drag Handle -->
            <div
                class="drag-handle shrink-0 w-8 h-8 flex items-center justify-center bg-primary hover:bg-primary/80 text-white rounded cursor-move transition-colors"
            >
                <Bars3Icon class="w-4 h-4" />
            </div>

            <!-- Menu Title -->
            <div class="grow">
                <span
                    class="text-secondary-800 dark:text-white font-medium"
                    :class="{ 'line-through': !menu.is_active }"
                >
                    {{ menu.title }}
                </span>
            </div>

            <!-- Settings Icon with Context Menu -->
            <div
                class="relative shrink-0"
                @mouseenter="handleMouseEnter"
                @mouseleave="handleMouseLeave"
            >
                <button
                    class="w-8 h-8 flex items-center justify-center text-primary hover:text-primary/80 hover:bg-primary/10 dark:hover:bg-primary/20 rounded transition-colors"
                >
                    <Cog6ToothIcon class="w-5 h-5" />
                </button>

                <!-- Context Menu -->
                <SidebarMenuContextMenu
                    v-if="showContextMenu"
                    :has-parent="!!menu.parent_id"
                    @edit="handleEdit"
                    @delete="handleDelete"
                    @add-child="handleAddChild"
                    @mouseenter="handleMouseEnter"
                    @mouseleave="handleMouseLeave"
                />
            </div>
        </div>

        <!-- Children Drop Zone - Always visible for drag-and-drop -->
        <draggable
            v-model="localChildren"
            v-bind="dragOptions"
            item-key="id"
            class="children-dropzone"
            :class="{
                'has-children': localChildren.length > 0,
                'empty-zone': localChildren.length === 0,
            }"
            @change="handleChildrenChange"
        >
            <template #item="{ element: childMenu }">
                <SidebarMenuItem
                    :menu="childMenu"
                    :depth="depth + 1"
                    :section="section"
                    :data-id="childMenu.id"
                    @edit="emit('edit', $event)"
                    @delete="emit('delete', $event)"
                    @add-child="emit('add-child', $event)"
                    @toggle-active="emit('toggle-active', $event)"
                    @update-structure="emit('update-structure', $event)"
                />
            </template>
        </draggable>
    </div>
</template>

<style scoped>
.menu-item-wrapper {
    user-select: none;
}

.children-dropzone {
    min-height: 8px;
    margin-left: 24px;
    padding-left: 12px;
    border-left: 2px solid transparent;
    transition: all 0.2s ease;
}

.children-dropzone.has-children {
    border-left-color: var(--color-primary-300, #a5abde);
    min-height: auto;
}

.children-dropzone.empty-zone {
    min-height: 8px;
    margin: 2px 0 2px 24px;
    border-radius: 4px;
    background: transparent;
}

/* Show drop zone when dragging */
.children-dropzone.empty-zone:has(.sortable-ghost),
.sortable-drag ~ .children-dropzone.empty-zone {
    min-height: 40px;
    background: rgba(99, 102, 241, 0.1);
    border: 2px dashed rgba(99, 102, 241, 0.4);
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
}
</style>
