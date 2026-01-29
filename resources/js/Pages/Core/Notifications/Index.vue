<script setup>
import { ref, onMounted } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Pagination from "@/Components/Data/Pagination.vue";
import { BellIcon, CheckIcon, TrashIcon } from "@heroicons/vue/24/outline";
import moment from "moment";
import NotificationController from "@/actions/App/Http/Controllers/Core/NotificationController";

const props = defineProps({
    notifications: Object,
});

const markAllAsRead = () => {
    router.post(
        NotificationController.markAllAsRead.url(),
        {},
        {
            preserveScroll: true,
        },
    );
};

const markAsRead = (id) => {
    router.patch(
        NotificationController.markAsRead.url({ id }),
        {},
        {
            preserveScroll: true,
        },
    );
};

const deleteNotification = (id) => {
    if (!confirm("Are you sure?")) return;
    router.delete(NotificationController.destroy.url({ id }), {
        preserveScroll: true,
    });
};

const timeAgo = (date) => {
    return moment(date).fromNow();
};

const formatTime = (date) => {
    return moment(date).format("MMMM Do YYYY, h:mm:ss a");
};
</script>

<template>
    <AdminLayout title="Notifications">
        <Head title="Notifications" />

        <div class="max-w-4xl mx-auto">
            <Card>
                <template #header>
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center gap-2">
                            <BellIcon class="w-5 h-5 text-gray-500" />
                            <span class="font-semibold text-lg"
                                >Notifications</span
                            >
                        </div>
                        <Button
                            v-if="notifications.total > 0"
                            variant="primary"
                            size="sm"
                            @click="markAllAsRead"
                        >
                            Mark all as read
                        </Button>
                    </div>
                </template>

                <div
                    v-if="notifications.data.length === 0"
                    class="text-center py-12 text-gray-500"
                >
                    <div class="flex justify-center mb-4">
                        <div
                            class="bg-gray-100 dark:bg-gray-800 p-4 rounded-full"
                        >
                            <BellIcon class="w-8 h-8 text-gray-400" />
                        </div>
                    </div>
                    <p
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        No notifications
                    </p>
                    <p class="text-sm">
                        You're all caught up! check back later.
                    </p>
                </div>

                <div
                    v-else
                    class="divide-y divide-gray-100 dark:divide-gray-700"
                >
                    <div
                        v-for="notification in notifications.data"
                        :key="notification.id"
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors flex gap-4 items-start group"
                        :class="{
                            'bg-blue-50/30 dark:bg-blue-900/10':
                                !notification.read_at,
                        }"
                    >
                        <div class="shrink-0 mt-1">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center"
                                :class="
                                    !notification.read_at
                                        ? 'bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400'
                                        : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'
                                "
                            >
                                <BellIcon class="w-5 h-5" />
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4
                                    class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                >
                                    {{
                                        notification.data.title ||
                                        "Notification"
                                    }}
                                </h4>
                                <span
                                    class="text-xs text-gray-500 whitespace-nowrap ml-2"
                                    :title="formatTime(notification.created_at)"
                                >
                                    {{ timeAgo(notification.created_at) }}
                                </span>
                            </div>

                            <p
                                class="text-sm text-gray-600 dark:text-gray-300 mt-1"
                            >
                                {{ notification.data.message }}
                            </p>

                            <div class="mt-3 flex items-center gap-3">
                                <a
                                    v-if="notification.data.url"
                                    :href="notification.data.url"
                                    class="text-xs font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300"
                                >
                                    View Details
                                </a>

                                <button
                                    v-if="!notification.read_at"
                                    @click="markAsRead(notification.id)"
                                    class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                >
                                    Mark as read
                                </button>

                                <button
                                    @click="deleteNotification(notification.id)"
                                    class="text-xs font-medium text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 px-4 pb-4">
                    <Pagination :links="notifications.links" />
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
