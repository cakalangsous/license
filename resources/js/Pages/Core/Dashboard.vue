<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import StatsCard from "@/Components/Data/StatsCard.vue";
import { computed } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
    title: { type: String, default: "Dashboard" },
    stats: Object,
    charts: Object,
    recentUsers: Array,
    serverInfo: Array,
});

// Map backend stats to StatsCard format
const statsData = computed(() => [
    {
        title: "Total Users",
        value: props.stats.totalUsers.toLocaleString(),
        icon: "users",
        color: "blue",
    },
    {
        title: "Total Roles",
        value: props.stats.totalRoles.toLocaleString(),
        icon: "shield",
        color: "purple",
    },
    {
        title: "Total CRUD Generated",
        value: props.stats.totalCruds.toLocaleString(),
        icon: "database", // Assuming 'database' icon exists or similar
        color: "red",
    },
    {
        title: "Total API Token",
        value: props.stats.totalApiTokens.toLocaleString(),
        icon: "key", // Assuming 'key' icon exists
        color: "green",
    },
]);

// Chart Options & Series
const userGrowthOptions = computed(() => ({
    chart: { type: "area", height: 300, toolbar: { show: false } },
    colors: ["#435ebe"],
    dataLabels: { enabled: false },
    stroke: { curve: "smooth" },
    xaxis: { categories: props.charts.userGrowth.labels },
    tooltip: { x: { format: "MMM yyyy" } },
}));

const userGrowthSeries = computed(() => [
    { name: "New Users", data: props.charts.userGrowth.data },
]);

const roleDistOptions = computed(() => ({
    chart: { type: "donut", height: 300 },
    labels: props.charts.roleDistribution.labels,
    colors: ["#435ebe", "#55c6e8", "#ffc107", "#dc3545", "#198754"], // Default palette
    legend: { position: "bottom" },
    dataLabels: { enabled: true, formatter: (val) => `${val.toFixed(1)}%` },
}));

const roleDistSeries = computed(() => props.charts.roleDistribution.data);
</script>

<template>
    <AdminLayout :title="title">
        <div class="space-y-6">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatsCard
                    v-for="stat in statsData"
                    :key="stat.title"
                    :title="stat.title"
                    :value="stat.value"
                    :icon="stat.icon"
                    :color="stat.color"
                />
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Growth -->
                <Card title="User Growth" class="lg:col-span-2">
                    <VueApexCharts
                        type="area"
                        height="300"
                        :options="userGrowthOptions"
                        :series="userGrowthSeries"
                    />
                </Card>

                <!-- Role Distribution -->
                <Card title="Role Distribution">
                    <VueApexCharts
                        type="donut"
                        height="300"
                        :options="roleDistOptions"
                        :series="roleDistSeries"
                    />
                </Card>
            </div>

            <!-- Bottom Row: Recent Users & System Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <Card title="Newest Members">
                    <div class="space-y-4">
                        <div
                            v-for="user in recentUsers"
                            :key="user.id"
                            class="flex items-center gap-3"
                        >
                            <img
                                :src="
                                    user.avatar ||
                                    `https://ui-avatars.com/api/?name=${user.name}&background=random`
                                "
                                class="w-10 h-10 rounded-full object-cover"
                                :alt="user.name"
                            />
                            <div>
                                <p
                                    class="font-semibold text-heading dark:text-white"
                                >
                                    {{ user.name }}
                                </p>
                                <p class="text-xs text-secondary-500">
                                    Joined
                                    {{
                                        new Date(
                                            user.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="recentUsers.length === 0"
                            class="text-center text-sm text-secondary-500 py-4"
                        >
                            No users found.
                        </div>
                    </div>
                </Card>

                <!-- System Info -->
                <Card title="System Environment">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <tbody>
                                <tr
                                    v-for="(info, index) in serverInfo"
                                    :key="index"
                                    class="border-b dark:border-secondary-700 last:border-0"
                                >
                                    <td
                                        class="py-3 font-medium text-secondary-600 dark:text-secondary-400"
                                    >
                                        {{ info.label }}
                                    </td>
                                    <td
                                        class="py-3 text-heading dark:text-white font-semibold text-right"
                                    >
                                        {{ info.value }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
