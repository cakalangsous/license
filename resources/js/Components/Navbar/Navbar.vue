<script setup>
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { Bars3Icon, ChevronDownIcon } from "@heroicons/vue/24/outline";
import ThemeToggle from "@/Components/Sidebar/ThemeToggle.vue";
import NotificationDropdown from "@/Components/Layout/Header/NotificationDropdown.vue";
import SettingsController from "@/actions/App/Http/Controllers/Core/SettingsController";

const emit = defineEmits(["toggle-sidebar"]);
const page = usePage();
const user = computed(() => page.props.auth?.user);

const permissions = computed(() => page.props.auth?.permissions || []);
const can = (permission) => permissions.value.includes(permission);
const canAny = (permList) =>
    permList.some((p) => permissions.value.includes(p));

const avatarUrl = computed(() => {
    if (user.value?.avatar) {
        return user.value.avatar.startsWith("http")
            ? user.value.avatar
            : `/${user.value.avatar}`;
    }
    return "/assets/images/faces/2.jpg";
});

const updateInfo = computed(() => page.props.updateInfo);
const hasUpdate = computed(() => updateInfo.value?.update_available === true);
</script>

<template>
    <nav
        class="bg-white dark:bg-secondary-800 border-b border-secondary-200 dark:border-secondary-700 h-16 px-4 flex items-center fixed left-0 right-0 top-0 z-50 transition-all duration-300 lg:pl-64"
        :class="{
            'lg:pl-64': $attrs.sidebarOpen,
            'lg:pl-0': !$attrs.sidebarOpen,
        }"
    >
        <div class="flex flex-wrap justify-between items-center w-full">
            <div class="flex justify-start items-center">
                <button
                    @click="$emit('toggle-sidebar')"
                    class="p-2 mr-2 text-secondary-600 rounded-lg cursor-pointer hover:text-secondary-900 hover:bg-secondary-100 focus:bg-secondary-100 dark:focus:bg-secondary-700 focus:ring-2 focus:ring-secondary-100 dark:focus:ring-secondary-700 dark:text-secondary-400 dark:hover:bg-secondary-700 dark:hover:text-white lg:hidden"
                >
                    <Bars3Icon class="w-6 h-6" />
                </button>
            </div>
            <div class="flex items-center lg:order-2">
                <!-- Update Available Badge -->
                <Link
                    v-if="
                        hasUpdate && canAny(['settings_view', 'settings_edit'])
                    "
                    href="/admin/system-health"
                    class="mr-2 flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-orange-500 to-amber-500 rounded-full hover:from-orange-600 hover:to-amber-600 transition-all shadow-sm"
                    title="Update available"
                >
                    <svg
                        class="w-3.5 h-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                        />
                    </svg>
                    <span class="hidden sm:inline"
                        >v{{ updateInfo?.latest_version }}</span
                    >
                </Link>

                <NotificationDropdown class="mr-2" />
                <ThemeToggle class="mr-2 cursor-pointer" />

                <!-- User Dropdown -->
                <Menu as="div" class="relative ml-2">
                    <div>
                        <MenuButton
                            class="flex items-center gap-2 rounded-full cursor-pointer focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img
                                class="w-8 h-8 rounded-full object-cover"
                                :src="avatarUrl"
                                :alt="user?.name || 'User avatar'"
                            />
                            <span
                                class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-200"
                                >{{ user?.name }}</span
                            >
                            <ChevronDownIcon
                                class="w-4 h-4 text-gray-500 hidden md:block"
                            />
                        </MenuButton>
                    </div>
                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-secondary-700 border border-secondary-200 dark:border-secondary-600"
                        >
                            <div
                                class="px-4 py-3 border-b border-secondary-100 dark:border-secondary-600"
                            >
                                <p
                                    class="text-sm text-gray-900 dark:text-white truncate"
                                >
                                    {{ user?.name }}
                                </p>
                                <p
                                    class="text-xs font-medium text-gray-500 truncate dark:text-gray-400"
                                >
                                    {{ user?.email }}
                                </p>
                            </div>
                            <MenuItem v-slot="{ active }">
                                <Link
                                    href="/admin/profile"
                                    :class="[
                                        active
                                            ? 'bg-secondary-100 dark:bg-secondary-600'
                                            : '',
                                        'block px-4 py-2 text-sm text-gray-700 dark:text-gray-200',
                                    ]"
                                >
                                    Profile
                                </Link>
                            </MenuItem>

                            <MenuItem
                                v-if="
                                    canAny(['settings_view', 'settings_edit'])
                                "
                                v-slot="{ active }"
                            >
                                <Link
                                    :href="SettingsController.index.url()"
                                    :class="[
                                        active
                                            ? 'bg-secondary-100 dark:bg-secondary-600'
                                            : '',
                                        'block px-4 py-2 text-sm text-gray-700 dark:text-gray-200',
                                    ]"
                                >
                                    Settings
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Link
                                    href="/admin/logout"
                                    method="post"
                                    as="button"
                                    :class="[
                                        active
                                            ? 'bg-secondary-100 dark:bg-secondary-600'
                                            : '',
                                        'block cursor-pointer w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200',
                                    ]"
                                >
                                    Sign out
                                </Link>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </nav>
</template>
