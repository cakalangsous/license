<script setup>
import { ref, onMounted, computed, onUnmounted } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { BellIcon, CheckIcon, TrashIcon } from "@heroicons/vue/24/outline";
import moment from "moment";
import axios from "axios";
import NotificationController from "@/actions/App/Http/Controllers/Core/NotificationController";

const page = usePage();
const isOpen = ref(false);
const loading = ref(false);
const notifications = ref([]);
const unreadCount = ref(0);
const dropdownRef = ref(null);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value && notifications.value.length === 0) {
        fetchNotifications();
    }
};

const fetchNotifications = async () => {
    loading.value = true;
    try {
        const response = await axios.post(
            NotificationController.loadMore.url(),
            { limit: 5 },
        );
        notifications.value = response.data.notifications;
        unreadCount.value = response.data.unread_count;
    } catch (error) {
        console.error("Failed to load notifications", error);
    } finally {
        loading.value = false;
    }
};

const markAsRead = (id) => {
    router.patch(
        NotificationController.markAsRead.url({ id }),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                // Update local state
                const index = notifications.value.findIndex((n) => n.id === id);
                if (index !== -1) {
                    notifications.value[index].read_at =
                        new Date().toISOString();
                    unreadCount.value = Math.max(0, unreadCount.value - 1);
                }
            },
        },
    );
};

const markAllAsRead = () => {
    router.post(
        NotificationController.markAllAsRead.url(),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                notifications.value.forEach(
                    (n) => (n.read_at = new Date().toISOString()),
                );
                unreadCount.value = 0;
                isOpen.value = false;
            },
        },
    );
};

// Polling for new notifications (every 30 seconds)
let interval;
onMounted(() => {
    fetchNotifications();
    interval = setInterval(fetchNotifications, 30000);

    // Click outside to close
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    clearInterval(interval);
    document.removeEventListener("click", handleClickOutside);
});

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        isOpen.value = false;
    }
};

const timeAgo = (date) => {
    return moment(date).fromNow();
};
</script>

<template>
    <div class="relative" ref="dropdownRef">
        <button
            @click="toggleDropdown"
            class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
        >
            <BellIcon class="w-6 h-6" />
            <span
                v-if="unreadCount > 0"
                class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full"
            >
                {{ unreadCount > 9 ? "9+" : unreadCount }}
            </span>
        </button>

        <!-- Dropdown Panel -->
        <div
            v-if="isOpen"
            class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50 origin-top-right transition-all"
        >
            <div
                class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750"
            >
                <h3
                    class="text-sm font-semibold text-gray-700 dark:text-gray-200"
                >
                    Notifications
                </h3>
                <button
                    v-if="unreadCount > 0"
                    @click="markAllAsRead"
                    class="text-xs text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-medium"
                >
                    Mark all read
                </button>
            </div>

            <div
                class="max-h-96 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700"
            >
                <div
                    v-if="loading && notifications.length === 0"
                    class="p-4 text-center text-gray-500"
                >
                    Loading...
                </div>

                <div
                    v-else-if="notifications.length === 0"
                    class="p-8 text-center text-gray-500 dark:text-gray-400"
                >
                    <div class="flex justify-center mb-3">
                        <BellIcon
                            class="w-10 h-10 text-gray-300 dark:text-gray-600"
                        />
                    </div>
                    <p class="text-sm">No notifications yet.</p>
                </div>

                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="block hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors relative group"
                    :class="{
                        'bg-blue-50/50 dark:bg-blue-900/10':
                            !notification.read_at,
                    }"
                >
                    <div class="px-4 py-3 flex gap-3">
                        <div class="shrink-0 mt-1">
                            <div
                                class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400"
                            >
                                <!-- Dynamic icon based on type could go here -->
                                <BellIcon class="w-4 h-4" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p
                                class="text-sm font-medium text-gray-900 dark:text-gray-100"
                            >
                                {{ notification.data.title || "Notification" }}
                            </p>
                            <p
                                class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2"
                            >
                                {{ notification.data.message }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ timeAgo(notification.created_at) }}
                            </p>
                        </div>

                        <button
                            v-if="!notification.read_at"
                            @click.stop="markAsRead(notification.id)"
                            class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity p-1 text-gray-400 hover:text-primary-600"
                            title="Mark as read"
                        >
                            <div
                                class="w-2 h-2 rounded-full bg-primary-500"
                            ></div>
                        </button>
                    </div>

                    <!-- Action Link Overlay if URL exists -->
                    <Link
                        v-if="notification.data.url"
                        :href="notification.data.url"
                        class="absolute inset-0 z-10 focus:outline-none"
                    ></Link>
                </div>
            </div>

            <div
                class="p-3 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700 text-center"
            >
                <Link
                    :href="NotificationController.index.url()"
                    class="text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 block w-full"
                >
                    View all notifications
                </Link>
            </div>
        </div>
    </div>
</template>
