<script setup>
import { ref, computed, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Button from "@/Components/UI/Button.vue";
import ConfirmationModal from "@/Components/UI/ConfirmationModal.vue";
import SidebarMenuList from "@/Components/SidebarMenuBuilder/SidebarMenuList.vue";
import SidebarMenuFormModal from "@/Components/SidebarMenuBuilder/SidebarMenuFormModal.vue";
import sidebarMenus from "@/routes/admin/sidebar-menus";
import { PlusIcon, Bars3Icon } from "@heroicons/vue/24/outline";

defineOptions({ layout: AdminLayout });

const props = defineProps({
    menusBySection: Object,
    sections: Array,
    allMenus: Array,
});

const toast = useToast();

const showFormModal = ref(false);
const editingMenu = ref(null);
const parentMenuForChild = ref(null);

const showDeleteModal = ref(false);
const menuToDelete = ref(null);
const isDeleting = ref(false);

const openCreateModal = () => {
    editingMenu.value = null;
    parentMenuForChild.value = null;
    showFormModal.value = true;
};

const openEditModal = (menu) => {
    editingMenu.value = menu;
    parentMenuForChild.value = null;
    showFormModal.value = true;
};

const openAddChildModal = (parentMenu) => {
    editingMenu.value = null;
    parentMenuForChild.value = parentMenu;
    showFormModal.value = true;
};

const closeFormModal = () => {
    showFormModal.value = false;
    editingMenu.value = null;
    parentMenuForChild.value = null;
};

const handleFormSubmit = (formData) => {
    if (editingMenu.value) {
        router.put(
            sidebarMenus.update.url({ sidebarMenu: editingMenu.value.id }),
            formData,
            {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Menu updated successfully");
                    closeFormModal();
                },
                onError: (errors) => {
                    toast.error("Failed to update menu");
                },
            },
        );
    } else if (parentMenuForChild.value) {
        router.post(
            sidebarMenus.addChild.url({
                sidebarMenu: parentMenuForChild.value.id,
            }),
            formData,
            {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Child menu added successfully");
                    closeFormModal();
                },
                onError: (errors) => {
                    toast.error("Failed to add child menu");
                },
            },
        );
    } else {
        router.post(sidebarMenus.store.url(), formData, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Menu created successfully");
                closeFormModal();
            },
            onError: (errors) => {
                toast.error("Failed to create menu");
            },
        });
    }
};

const handleDelete = (menu) => {
    menuToDelete.value = menu;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    if (!menuToDelete.value) return;

    isDeleting.value = true;
    router.delete(
        sidebarMenus.destroy.url({ sidebarMenu: menuToDelete.value.id }),
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Menu deleted successfully");
                closeDeleteModal();
            },
            onError: () => {
                toast.error("Failed to delete menu");
                isDeleting.value = false;
            },
        },
    );
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    menuToDelete.value = null;
    isDeleting.value = false;
};

const handleToggleActive = (menu) => {
    router.post(
        sidebarMenus.toggle.url({ sidebarMenu: menu.id }),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success(
                    menu.is_active ? "Menu deactivated" : "Menu activated",
                );
            },
            onError: () => {
                toast.error("Failed to toggle menu status");
            },
        },
    );
};

const handleReorder = (items) => {
    router.post(
        sidebarMenus.reorder.url(),
        { items },
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Menu order updated");
            },
            onError: () => {
                toast.error("Failed to update menu order");
            },
        },
    );
};

const handleDetach = (menu) => {
    // Detach by setting parent_id to null
    router.post(
        sidebarMenus.reorder.url(),
        {
            items: [
                {
                    id: menu.id,
                    parent_id: null,
                    order: 999, // Will be placed at end
                    section: menu.section,
                },
            ],
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Menu detached from parent");
            },
            onError: () => {
                toast.error("Failed to detach menu");
            },
        },
    );
};
</script>

<template>
    <div class="p-6 max-w-6xl mx-auto">
        <div class="bg-primary text-white px-4 py-3 rounded-lg mb-6 shadow-md">
            <div class="font-medium mb-1"># Hints:</div>
            <ul class="text-sm space-y-1 list-disc list-inside">
                <li>Double click menu to activate or deactivate</li>
                <li>Drag up/down to reorder menus</li>
                <li>
                    Drag into the indented area below a menu to make it a child
                </li>
                <li>
                    Drag out of the indented area to the main list to detach
                </li>
            </ul>
        </div>

        <div class="mb-6">
            <Button variant="outline-primary" @click="openCreateModal">
                <PlusIcon class="w-4 h-4 mr-2" />
                Add Menu New
            </Button>
        </div>

        <div class="space-y-8">
            <div
                v-for="section in sections"
                :key="section"
                class="bg-white py-4 dark:bg-secondary-800 rounded-lg shadow-sm border border-secondary-200 dark:border-secondary-700"
            >
                <div
                    class="px-4 py-3 border-b border-secondary-200 dark:border-secondary-700"
                >
                    <h2
                        class="text-sm font-bold text-secondary-700 dark:text-secondary-300 uppercase tracking-wider"
                    >
                        {{ section }}
                    </h2>
                </div>

                <SidebarMenuList
                    :menus="menusBySection[section] || []"
                    :section="section"
                    @edit="openEditModal"
                    @delete="handleDelete"
                    @add-child="openAddChildModal"
                    @toggle-active="handleToggleActive"
                    @update-structure="handleReorder"
                />
            </div>

            <div
                v-if="!sections || sections.length === 0"
                class="bg-white dark:bg-secondary-800 rounded-lg shadow-sm border border-secondary-200 dark:border-secondary-700 p-12 text-center"
            >
                <Bars3Icon class="w-16 h-16 mx-auto text-secondary-400 mb-4" />
                <h3
                    class="text-lg font-medium text-secondary-900 dark:text-white mb-2"
                >
                    No menus yet
                </h3>
                <p class="text-secondary-500 dark:text-secondary-400 mb-4">
                    Get started by creating your first menu item.
                </p>
                <Button variant="primary" @click="openCreateModal">
                    Create First Menu
                </Button>
            </div>
        </div>

        <SidebarMenuFormModal
            :show="showFormModal"
            :menu="editingMenu"
            :parent-menu="parentMenuForChild"
            :all-menus="allMenus"
            :sections="sections"
            @close="closeFormModal"
            @submit="handleFormSubmit"
        />

        <ConfirmationModal
            :show="showDeleteModal"
            title="Delete Menu"
            :message="`Are you sure you want to delete '${menuToDelete?.title}'? This action cannot be undone.`"
            confirm-text="Delete"
            cancel-text="Cancel"
            variant="danger"
            :loading="isDeleting"
            @confirm="confirmDelete"
            @cancel="closeDeleteModal"
        />
    </div>
</template>
