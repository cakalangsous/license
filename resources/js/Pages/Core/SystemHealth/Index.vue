<script setup>
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";

const props = defineProps({
    title: { type: String, default: "System Health" },
    health: { type: Object, required: true },
});

const getStatusColor = (passed) => {
    return passed
        ? "text-green-600 dark:text-green-400"
        : "text-red-600 dark:text-red-400";
};

const getStatusBg = (passed) => {
    return passed
        ? "bg-green-100 dark:bg-green-900/30"
        : "bg-red-100 dark:bg-red-900/30";
};

const getStatusIcon = (passed) => {
    return passed ? "✓" : "✗";
};

const overallHealth = () => {
    const checks = [
        props.health.php?.passed,
        props.health.extensions?.passed,
        props.health.directories?.passed,
        props.health.database?.passed,
        props.health.cache?.passed,
        props.health.queue?.passed,
        props.health.mail?.passed,
        props.health.storage?.passed,
    ];
    const passed = checks.filter(Boolean).length;
    return {
        passed,
        total: checks.length,
        percentage: Math.round((passed / checks.length) * 100),
    };
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="space-y-6">
            <!-- Overall Status Card -->
            <Card>
                <div class="flex items-center justify-between">
                    <div>
                        <h2
                            class="text-2xl font-bold text-heading dark:text-white"
                        >
                            System Health Status
                        </h2>
                        <p
                            class="text-secondary-600 dark:text-secondary-400 mt-1"
                        >
                            {{ overallHealth().passed }} of
                            {{ overallHealth().total }} checks passed
                        </p>
                    </div>
                    <div
                        class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold"
                        :class="
                            overallHealth().percentage === 100
                                ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400'
                                : overallHealth().percentage >= 70
                                  ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400'
                                  : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
                        "
                    >
                        {{ overallHealth().percentage }}%
                    </div>
                </div>
            </Card>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- PHP Version -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.php?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.php?.passed),
                                    getStatusColor(health.php?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.php?.passed) }}
                                {{ health.php?.passed ? "Passed" : "Failed" }}
                            </span>
                        </div>
                    </template>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Required:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.php?.required
                            }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Current:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.php?.current
                            }}</span>
                        </div>
                    </div>
                </Card>

                <!-- Database -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.database?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.database?.passed),
                                    getStatusColor(health.database?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.database?.passed) }}
                                {{
                                    health.database?.passed
                                        ? "Connected"
                                        : "Failed"
                                }}
                            </span>
                        </div>
                    </template>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Driver:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.database?.current
                            }}</span>
                        </div>
                        <p class="text-sm text-secondary-500">
                            {{ health.database?.message }}
                        </p>
                    </div>
                </Card>

                <!-- Cache -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.cache?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.cache?.passed),
                                    getStatusColor(health.cache?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.cache?.passed) }}
                                {{
                                    health.cache?.passed ? "Working" : "Failed"
                                }}
                            </span>
                        </div>
                    </template>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Driver:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.cache?.current
                            }}</span>
                        </div>
                        <p class="text-sm text-secondary-500">
                            {{ health.cache?.message }}
                        </p>
                    </div>
                </Card>

                <!-- Queue -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.queue?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.queue?.passed),
                                    getStatusColor(health.queue?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.queue?.passed) }}
                                {{
                                    health.queue?.passed
                                        ? "Configured"
                                        : "Issue"
                                }}
                            </span>
                        </div>
                    </template>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Driver:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.queue?.current
                            }}</span>
                        </div>
                    </div>
                </Card>

                <!-- Mail -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.mail?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.mail?.passed),
                                    getStatusColor(health.mail?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.mail?.passed) }}
                                {{
                                    health.mail?.passed ? "Configured" : "Issue"
                                }}
                            </span>
                        </div>
                    </template>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span
                                class="text-secondary-600 dark:text-secondary-400"
                                >Mailer:</span
                            >
                            <span class="font-medium dark:text-white">{{
                                health.mail?.current
                            }}</span>
                        </div>
                        <p
                            v-if="!health.mail?.passed"
                            class="text-sm text-red-500"
                        >
                            {{ health.mail?.message }}
                        </p>
                    </div>
                </Card>

                <!-- Storage Link -->
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <span class="font-semibold">{{
                                health.storage?.name
                            }}</span>
                            <span
                                :class="[
                                    getStatusBg(health.storage?.passed),
                                    getStatusColor(health.storage?.passed),
                                ]"
                                class="px-2 py-1 rounded text-sm font-medium"
                            >
                                {{ getStatusIcon(health.storage?.passed) }}
                                {{ health.storage?.current }}
                            </span>
                        </div>
                    </template>
                    <p
                        v-if="!health.storage?.passed"
                        class="text-sm text-red-500"
                    >
                        {{ health.storage?.message }}
                    </p>
                    <p v-else class="text-sm text-secondary-500">
                        {{ health.storage?.message }}
                    </p>
                </Card>
            </div>

            <!-- PHP Extensions -->
            <Card>
                <template #header>
                    <div class="flex items-center justify-between w-full">
                        <span class="font-semibold">{{
                            health.extensions?.name
                        }}</span>
                        <span
                            :class="[
                                getStatusBg(health.extensions?.passed),
                                getStatusColor(health.extensions?.passed),
                            ]"
                            class="px-2 py-1 rounded text-sm font-medium"
                        >
                            {{ getStatusIcon(health.extensions?.passed) }}
                            {{
                                health.extensions?.passed
                                    ? "All Installed"
                                    : "Missing Extensions"
                            }}
                        </span>
                    </div>
                </template>
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3"
                >
                    <div
                        v-for="ext in health.extensions?.items"
                        :key="ext.name"
                        :class="[getStatusBg(ext.passed)]"
                        class="px-3 py-2 rounded-lg flex items-center gap-2"
                    >
                        <span
                            :class="getStatusColor(ext.passed)"
                            class="font-bold"
                            >{{ getStatusIcon(ext.passed) }}</span
                        >
                        <span class="text-sm font-medium dark:text-white">{{
                            ext.name
                        }}</span>
                    </div>
                </div>
            </Card>

            <!-- Directory Permissions -->
            <Card>
                <template #header>
                    <div class="flex items-center justify-between w-full">
                        <span class="font-semibold">{{
                            health.directories?.name
                        }}</span>
                        <span
                            :class="[
                                getStatusBg(health.directories?.passed),
                                getStatusColor(health.directories?.passed),
                            ]"
                            class="px-2 py-1 rounded text-sm font-medium"
                        >
                            {{ getStatusIcon(health.directories?.passed) }}
                            {{
                                health.directories?.passed
                                    ? "All Writable"
                                    : "Permission Issues"
                            }}
                        </span>
                    </div>
                </template>
                <div class="space-y-3">
                    <div
                        v-for="dir in health.directories?.items"
                        :key="dir.name"
                        class="flex items-center justify-between p-3 rounded-lg"
                        :class="getStatusBg(dir.passed)"
                    >
                        <div>
                            <span class="font-medium dark:text-white">{{
                                dir.name
                            }}</span>
                            <p class="text-xs text-secondary-500 font-mono">
                                {{ dir.path }}
                            </p>
                        </div>
                        <span
                            :class="getStatusColor(dir.passed)"
                            class="font-medium"
                        >
                            {{ dir.message }}
                        </span>
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
