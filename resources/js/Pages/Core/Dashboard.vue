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
    recentActivations: Array,
    expiringSupport: Array,
    serverInfo: Array,
});

// Map backend stats to StatsCard format (License-focused)
const statsData = computed(() => [
    {
        title: "Total Licenses",
        value: (props.stats?.totalLicenses || 0).toLocaleString(),
        icon: "key",
        color: "blue",
    },
    {
        title: "Active Licenses",
        value: (props.stats?.activeLicenses || 0).toLocaleString(),
        icon: "check-circle",
        color: "green",
    },
    {
        title: "Active Activations",
        value: (props.stats?.totalActivations || 0).toLocaleString(),
        icon: "server",
        color: "purple",
    },
    {
        title: "Expiring Support",
        value: (props.stats?.expiringSupport || 0).toLocaleString(),
        icon: "exclamation",
        color: "orange",
        subtitle: "within 30 days",
    },
    {
        title: "This Month Sales",
        value: (props.stats?.thisMonthSales || 0).toLocaleString(),
        icon: "shopping-cart",
        color: "teal",
    },
    {
        title: "Total Revenue",
        value: `$${(props.stats?.totalRevenue || 0).toLocaleString()}`,
        icon: "currency-dollar",
        color: "emerald",
    },
]);

// Sales Growth Chart Options
const salesGrowthOptions = computed(() => ({
    chart: { type: "area", height: 300, toolbar: { show: false } },
    colors: ["#10b981"],
    dataLabels: { enabled: false },
    stroke: { curve: "smooth", width: 2 },
    fill: {
        type: "gradient",
        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 },
    },
    xaxis: { categories: props.charts?.salesGrowth?.labels || [] },
    tooltip: { x: { format: "MMM yyyy" } },
}));

const salesGrowthSeries = computed(() => [
    { name: "Sales", data: props.charts?.salesGrowth?.data || [] },
]);

// License Distribution (Donut)
const licenseDistOptions = computed(() => ({
    chart: { type: "donut", height: 280 },
    labels: props.charts?.licenseDistribution?.labels || [],
    colors: ["#10b981", "#f59e0b", "#ef4444", "#6b7280"],
    legend: { position: "bottom" },
    dataLabels: { enabled: true, formatter: (val) => `${val.toFixed(0)}%` },
}));
const licenseDistSeries = computed(
    () => props.charts?.licenseDistribution?.data || [],
);

// API Calls Chart (Bar)
const apiCallsOptions = computed(() => ({
    chart: { type: "bar", height: 280, toolbar: { show: false } },
    colors: ["#6366f1"],
    dataLabels: { enabled: false },
    xaxis: { categories: props.charts?.apiCalls?.labels || [] },
    plotOptions: { bar: { borderRadius: 4, columnWidth: "60%" } },
}));
const apiCallsSeries = computed(() => [
    { name: "API Calls", data: props.charts?.apiCalls?.data || [] },
]);
</script>

<template>
    <AdminLayout :title="title">
        <div class="space-y-6">
            <!-- Stats Row -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4"
            >
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
                <!-- Sales Growth -->
                <Card title="Sales Growth (6 Months)" class="lg:col-span-2">
                    <VueApexCharts
                        type="area"
                        height="300"
                        :options="salesGrowthOptions"
                        :series="salesGrowthSeries"
                    />
                </Card>

                <!-- License Status Distribution -->
                <Card title="License Status">
                    <VueApexCharts
                        type="donut"
                        height="280"
                        :options="licenseDistOptions"
                        :series="licenseDistSeries"
                    />
                </Card>
            </div>

            <!-- Second Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- API Calls (7 days) -->
                <Card title="API Activity (7 Days)">
                    <VueApexCharts
                        type="bar"
                        height="280"
                        :options="apiCallsOptions"
                        :series="apiCallsSeries"
                    />
                </Card>

                <!-- Expiring Support Licenses -->
                <Card title="Support Expiring Soon">
                    <div class="space-y-3">
                        <div
                            v-for="license in expiringSupport"
                            :key="license.id"
                            class="flex items-center justify-between py-2 border-b dark:border-secondary-700 last:border-0"
                        >
                            <div>
                                <code
                                    class="text-sm bg-secondary-100 dark:bg-secondary-800 px-2 py-0.5 rounded"
                                >
                                    {{ license.purchase_code }}
                                </code>
                                <p class="text-xs text-secondary-500 mt-1">
                                    {{ license.product }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span
                                    :class="[
                                        'px-2 py-1 rounded-full text-xs font-medium',
                                        license.days_left <= 7
                                            ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                            : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                    ]"
                                >
                                    {{ license.days_left }} days left
                                </span>
                                <p class="text-xs text-secondary-500 mt-1">
                                    {{ license.supported_until }}
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="
                                !expiringSupport || expiringSupport.length === 0
                            "
                            class="text-center text-sm text-secondary-500 py-4"
                        >
                            No licenses expiring within 30 days! 🎉
                        </div>
                    </div>
                </Card>
            </div>

            <!-- Bottom Row: Recent Activations & System Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activations -->
                <Card title="Recent Activations">
                    <div class="space-y-3">
                        <div
                            v-for="activation in recentActivations"
                            :key="activation.id"
                            class="flex items-center gap-3 py-2 border-b dark:border-secondary-700 last:border-0"
                        >
                            <div
                                :class="[
                                    'w-10 h-10 rounded-full flex items-center justify-center text-white',
                                    activation.is_local
                                        ? 'bg-blue-500'
                                        : 'bg-green-500',
                                ]"
                            >
                                <span class="text-xs font-bold">{{
                                    activation.is_local ? "DEV" : "PROD"
                                }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="font-medium text-heading dark:text-white truncate"
                                >
                                    {{ activation.domain }}
                                </p>
                                <p class="text-xs text-secondary-500">
                                    {{ activation.product }}
                                </p>
                            </div>
                            <span class="text-xs text-secondary-500">{{
                                activation.activated_at
                            }}</span>
                        </div>
                        <div
                            v-if="
                                !recentActivations ||
                                recentActivations.length === 0
                            "
                            class="text-center text-sm text-secondary-500 py-4"
                        >
                            No recent activations.
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
