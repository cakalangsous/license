<script setup>
import { Head, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import { ref } from "vue";
import { useToast } from "vue-toastification";
import {
    CircleStackIcon,
    FolderIcon,
    ArchiveBoxIcon,
    ArrowDownTrayIcon,
    TrashIcon,
    ArrowPathIcon,
} from "@heroicons/vue/24/outline";

const toast = useToast();

const props = defineProps({
    title: { type: String, default: "Backup" },
    backups: { type: Array, default: () => [] },
});

const creatingDatabase = ref(false);
const creatingFiles = ref(false);
const deletingBackup = ref(null);

const createDatabaseBackup = async () => {
    creatingDatabase.value = true;
    try {
        const response = await fetch("/admin/backup/database", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        });

        const data = await response.json();

        if (data.success) {
            toast.success(data.message);
            router.reload({ only: ["backups"] });
        } else {
            toast.error(data.message);
        }
    } catch (error) {
        toast.error("Failed to create database backup");
    } finally {
        creatingDatabase.value = false;
    }
};

const createFilesBackup = async () => {
    creatingFiles.value = true;
    try {
        const response = await fetch("/admin/backup/files", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        });

        const data = await response.json();

        if (data.success) {
            toast.success(data.message);
            router.reload({ only: ["backups"] });
        } else {
            toast.error(data.message);
        }
    } catch (error) {
        toast.error("Failed to create files backup");
    } finally {
        creatingFiles.value = false;
    }
};

const downloadBackup = (filename) => {
    window.location.href = `/admin/backup/download/${filename}`;
};

const deleteBackup = async (filename) => {
    if (!confirm("Are you sure you want to delete this backup?")) return;

    deletingBackup.value = filename;
    try {
        const response = await fetch(`/admin/backup/${filename}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        });

        const data = await response.json();

        if (data.success) {
            toast.success(data.message);
            router.reload({ only: ["backups"] });
        } else {
            toast.error(data.message);
        }
    } catch (error) {
        toast.error("Failed to delete backup");
    } finally {
        deletingBackup.value = null;
    }
};

const getTypeLabel = (type) => {
    return type === "database"
        ? "Database"
        : type === "files"
          ? "Files"
          : "Unknown";
};

const getTypeColor = (type) => {
    return type === "database"
        ? "bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"
        : "bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400";
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="space-y-6">
            <!-- Create Backup Card -->
            <Card>
                <template #header>
                    <span class="font-semibold">Create Backup</span>
                </template>
                <div class="flex flex-wrap gap-4">
                    <Button
                        variant="primary"
                        @click="createDatabaseBackup"
                        :disabled="creatingDatabase"
                    >
                        <ArrowPathIcon
                            v-if="creatingDatabase"
                            class="animate-spin -ml-1 mr-2 h-4 w-4"
                        />
                        <CircleStackIcon v-else class="w-4 h-4 mr-2" />
                        {{
                            creatingDatabase ? "Creating..." : "Backup Database"
                        }}
                    </Button>

                    <Button
                        variant="outline-primary"
                        @click="createFilesBackup"
                        :disabled="creatingFiles"
                    >
                        <ArrowPathIcon
                            v-if="creatingFiles"
                            class="animate-spin -ml-1 mr-2 h-4 w-4"
                        />
                        <FolderIcon v-else class="w-4 h-4 mr-2" />
                        {{ creatingFiles ? "Creating..." : "Backup Files" }}
                    </Button>
                </div>
                <p class="mt-4 text-sm text-secondary-500">
                    Database backup creates an SQL dump. Files backup creates a
                    zip of storage/app/public.
                </p>
            </Card>

            <!-- Backups List -->
            <Card>
                <template #header>
                    <div class="flex items-center justify-between w-full">
                        <span class="font-semibold">Existing Backups</span>
                        <span class="text-sm text-secondary-500"
                            >{{ backups.length }} backup(s)</span
                        >
                    </div>
                </template>

                <div
                    v-if="backups.length === 0"
                    class="text-center py-8 text-secondary-500"
                >
                    <ArchiveBoxIcon
                        class="w-12 h-12 mx-auto mb-4 text-secondary-300"
                    />
                    <p>No backups found. Create your first backup above.</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b dark:border-secondary-700">
                                <th
                                    class="text-left py-3 px-4 font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    Filename
                                </th>
                                <th
                                    class="text-left py-3 px-4 font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    Type
                                </th>
                                <th
                                    class="text-left py-3 px-4 font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    Size
                                </th>
                                <th
                                    class="text-left py-3 px-4 font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    Created
                                </th>
                                <th
                                    class="text-right py-3 px-4 font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="backup in backups"
                                :key="backup.filename"
                                class="border-b dark:border-secondary-700 last:border-0 hover:bg-secondary-50 dark:hover:bg-secondary-800/50"
                            >
                                <td
                                    class="py-3 px-4 font-medium dark:text-white"
                                >
                                    <div class="flex items-center gap-2">
                                        <CircleStackIcon
                                            v-if="backup.type === 'database'"
                                            class="w-5 h-5 text-blue-500"
                                        />
                                        <FolderIcon
                                            v-else
                                            class="w-5 h-5 text-purple-500"
                                        />
                                        {{ backup.filename }}
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        :class="getTypeColor(backup.type)"
                                        class="px-2 py-1 rounded text-xs font-medium"
                                    >
                                        {{ getTypeLabel(backup.type) }}
                                    </span>
                                </td>
                                <td
                                    class="py-3 px-4 text-secondary-600 dark:text-secondary-400"
                                >
                                    {{ backup.size }}
                                </td>
                                <td
                                    class="py-3 px-4 text-secondary-600 dark:text-secondary-400"
                                >
                                    {{ backup.created_at }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            @click="
                                                downloadBackup(backup.filename)
                                            "
                                            class="p-2 text-secondary-600 cursor-pointer hover:text-primary dark:text-secondary-400 dark:hover:text-primary transition-colors"
                                            title="Download"
                                        >
                                            <ArrowDownTrayIcon
                                                class="w-5 h-5"
                                            />
                                        </button>
                                        <button
                                            @click="
                                                deleteBackup(backup.filename)
                                            "
                                            :disabled="
                                                deletingBackup ===
                                                backup.filename
                                            "
                                            class="p-2 text-secondary-600 cursor-pointer hover:text-red-500 dark:text-secondary-400 dark:hover:text-red-400 transition-colors disabled:opacity-50"
                                            title="Delete"
                                        >
                                            <ArrowPathIcon
                                                v-if="
                                                    deletingBackup ===
                                                    backup.filename
                                                "
                                                class="animate-spin w-5 h-5"
                                            />
                                            <TrashIcon v-else class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
