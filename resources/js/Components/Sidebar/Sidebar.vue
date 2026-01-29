<script setup>
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import SidebarItem from "./SidebarItem.vue";

// Import Hero Icons for static menus
import {
    Bars3Icon,
    WrenchScrewdriverIcon,
    ShieldCheckIcon,
    Cog6ToothIcon,
    KeyIcon,
    ClockIcon,
    PhotoIcon,
    HeartIcon,
    CloudArrowDownIcon,
} from "@heroicons/vue/24/outline";

// Import Wayfinder routes
import SidebarMenuController from "@/actions/App/Http/Controllers/Core/SidebarMenuController";
import CrudController from "@/actions/App/Http/Controllers/Core/Crud/CrudController";
import MediaController from "@/actions/App/Http/Controllers/Core/MediaController";
import UserController from "@/actions/App/Http/Controllers/Core/UserController";
import RoleController from "@/actions/App/Http/Controllers/Core/RoleController";
import PermissionController from "@/actions/App/Http/Controllers/Core/PermissionController";
import AccessController from "@/actions/App/Http/Controllers/Core/AccessController";
import SettingsController from "@/actions/App/Http/Controllers/Core/SettingsController";
import ApiTokenController from "@/actions/App/Http/Controllers/Core/ApiTokenController";
import ActivityLogController from "@/actions/App/Http/Controllers/Core/ActivityLogController";
import SystemHealthController from "@/actions/App/Http/Controllers/Core/SystemHealthController";
import BackupController from "@/actions/App/Http/Controllers/Core/BackupController";

const props = defineProps({
    open: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["toggle"]);

const page = usePage();
const roles = computed(() => page.props.auth?.roles || []);
const permissions = computed(() => page.props.auth?.permissions || []);
const appName = computed(() => page.props.appName || "Laravel");
const appLogo = computed(() => page.props.appLogo);
const appLogoDark = computed(() => page.props.appLogoDark);
const currentUrl = computed(() => page.url);
const dynamicMenus = computed(() => page.props.dynamicMenus || []);

// Get the appropriate logo based on dark mode
const currentLogo = computed(() => {
    // Check if dark mode is active by checking the html class
    const isDark =
        typeof document !== "undefined" &&
        document.documentElement.classList.contains("dark");
    if (isDark && appLogoDark.value) {
        return appLogoDark.value;
    }
    return appLogo.value;
});

// Check if current URL matches or starts with given path
const isActive = (path) =>
    currentUrl.value === path || currentUrl.value.startsWith(path + "/");

// Menu items configuration - use functions that are called during render
const menuItems = computed(() => {
    const perms = permissions.value;

    const can = (permission) => perms.includes(permission);
    const canAny = (permList) => permList.some((p) => perms.includes(p));

    // Static menu items (Dashboard & Posts now come from database)
    const staticMenus = [
        {
            title: "Menu",
            items: [],
        },
        {
            title: "Super Admin",
            show: canAny([
                "sidebar_menu_view",
                "crud_builder_view",
                "api_tokens_view",
                "media_view",
                "users_view",
                "roles_view",
                "permissions_view",
                "access_view",
                "activity_log_view",
                "settings_view",
            ]),
            items: [
                {
                    name: "Sidebar Menu",
                    href: SidebarMenuController.index.url(),
                    icon: Bars3Icon,
                    show: can("sidebar_menu_view"),
                },
                {
                    name: "CRUD Builder",
                    href: CrudController.index.url(),
                    icon: WrenchScrewdriverIcon,
                    show: can("crud_builder_view"),
                },
                {
                    name: "API Tokens",
                    href: ApiTokenController.index.url(),
                    icon: KeyIcon,
                    show: can("api_tokens_view"),
                },
                {
                    name: "Media",
                    href: MediaController.index.url(),
                    icon: PhotoIcon,
                    show: can("media_view"),
                },
                {
                    name: "Auth",
                    icon: ShieldCheckIcon,
                    show: canAny([
                        "users_view",
                        "roles_view",
                        "permissions_view",
                        "access_view",
                    ]),
                    children: [
                        {
                            name: "Users",
                            href: UserController.index.url(),
                            show: can("users_view"),
                        },
                        {
                            name: "Roles",
                            href: RoleController.index.url(),
                            show: can("roles_view"),
                        },
                        {
                            name: "Permissions",
                            href: PermissionController.index.url(),
                            show: can("permissions_view"),
                        },
                        {
                            name: "Access",
                            href: AccessController.index.url(),
                            show: can("access_view"),
                        },
                    ],
                },
                {
                    name: "Activity Log",
                    href: ActivityLogController.index.url(),
                    icon: ClockIcon,
                    show: can("activity_log_view"),
                },
                {
                    name: "System Health",
                    href: SystemHealthController.index.url(),
                    icon: HeartIcon,
                    show: can("settings_view"),
                },
                {
                    name: "Backup",
                    href: BackupController.index.url(),
                    icon: CloudArrowDownIcon,
                    show: can("settings_edit"),
                },
            ],
        },
    ];

    // Transform dynamic menus from backend and add permission checks
    // Items from 'Menu' section will be merged into existing Menu section
    const menuDynamicItems = [];
    const otherDynamicSections = [];

    dynamicMenus.value.forEach((section) => {
        const transformedItems = section.items.map((item) => ({
            ...item,
            show: !item.permission || can(item.permission),
            active: isActive(item.href),
            children: item.children?.map((child) => ({
                ...child,
                show: !child.permission || can(child.permission),
            })),
        }));

        if (section.title === "Menu") {
            // Merge into existing Menu section
            menuDynamicItems.push(...transformedItems);
        } else {
            // Keep as separate section
            otherDynamicSections.push({
                title: section.title,
                show: transformedItems.some((item) => item.show),
                items: transformedItems,
            });
        }
    });

    // Merge menuDynamicItems into the Menu section of staticMenus
    const mergedMenus = staticMenus.map((section) => {
        if (section.title === "Menu" && menuDynamicItems.length > 0) {
            return {
                ...section,
                items: [...section.items, ...menuDynamicItems],
            };
        }
        return section;
    });

    return [...mergedMenus, ...otherDynamicSections];
});
</script>

<template>
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 shadow-lg transform transition-transform duration-300 lg:translate-x-0"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        style="background-color: var(--color-sidebar-bg)"
    >
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div
                class="h-16 px-4 flex items-center border-b border-secondary-100 dark:border-secondary-700"
            >
                <div class="flex items-center justify-between w-full">
                    <Link href="/admin/dashboard" class="flex items-center">
                        <img
                            v-if="appLogo"
                            :src="appLogo"
                            :alt="appName"
                            class="h-8 max-w-[160px] object-contain dark:hidden"
                        />
                        <img
                            v-if="appLogoDark || appLogo"
                            :src="appLogoDark || appLogo"
                            :alt="appName"
                            class="h-8 max-w-[160px] object-contain hidden dark:block"
                        />
                        <span
                            v-if="!appLogo"
                            class="text-xl font-bold text-heading dark:text-white"
                        >
                            {{ appName }}
                        </span>
                    </Link>
                    <div class="flex items-center gap-2">
                        <button
                            @click="emit('toggle')"
                            class="lg:hidden p-1.5 rounded hover:bg-secondary-100 dark:hover:bg-secondary-700"
                        >
                            <svg
                                class="w-5 h-5"
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
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4">
                <template v-for="section in menuItems" :key="section.title">
                    <div v-if="section.show !== false" class="mb-4">
                        <p
                            class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-secondary-400"
                        >
                            {{ section.title }}
                        </p>
                        <ul class="space-y-1">
                            <SidebarItem
                                v-for="item in section.items.filter(
                                    (i) => i.show !== false,
                                )"
                                :key="item.name"
                                :item="item"
                            />
                        </ul>
                    </div>
                </template>
            </nav>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div
        v-if="open"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        @click="emit('toggle')"
    />
</template>
