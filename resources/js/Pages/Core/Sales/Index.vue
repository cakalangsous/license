<script setup>
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import DataTable from "@/Components/Data/DataTable.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        default: "Sales",
    },
    sales: {
        type: Object,
        default: () => ({}),
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
    products: {
        type: Array,
        default: () => [],
    },
    marketplaces: {
        type: Array,
        default: () => [],
    },
});

const columns = [
    { key: "sale_date", label: "Date", sortable: true },
    { key: "product", label: "Product", sortable: false },
    { key: "marketplace", label: "Marketplace", sortable: false },
    { key: "gross_amount", label: "Gross", sortable: true },
    { key: "marketplace_fee", label: "Fee", sortable: false },
    { key: "net_amount", label: "Net", sortable: true },
];

const filters = ref({
    marketplace_id: "",
    product_id: "",
    date_from: "",
    date_to: "",
});

const applyFilters = () => {
    router.get("/admin/sales", filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(value || 0);
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <Card class="bg-linear-to-br from-primary/10 to-primary/5">
                <div class="text-center">
                    <p class="text-2xl font-bold text-primary">
                        {{ formatCurrency(stats.total_revenue) }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Total Revenue
                    </p>
                </div>
            </Card>
            <Card class="bg-linear-to-br from-green-500/10 to-green-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-green-600 dark:text-green-400"
                    >
                        {{ formatCurrency(stats.this_month) }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        This Month
                    </p>
                </div>
            </Card>
            <Card class="bg-linear-to-br from-blue-500/10 to-blue-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-blue-600 dark:text-blue-400"
                    >
                        {{ stats.total_sales }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Total Sales
                    </p>
                </div>
            </Card>
            <Card class="bg-linear-to-br from-orange-500/10 to-orange-500/5">
                <div class="text-center">
                    <p
                        class="text-2xl font-bold text-orange-600 dark:text-orange-400"
                    >
                        {{ formatCurrency(stats.marketplace_fees) }}
                    </p>
                    <p
                        class="text-sm text-secondary-600 dark:text-secondary-400"
                    >
                        Marketplace Fees
                    </p>
                </div>
            </Card>
        </div>

        <Card>
            <template #header>
                <div
                    class="flex items-center justify-between w-full flex-wrap gap-4"
                >
                    <span class="font-semibold">Sales</span>
                    <div class="flex items-center gap-2 flex-wrap">
                        <FormSelect
                            v-model="filters.marketplace_id"
                            class="w-40"
                            @change="applyFilters"
                        >
                            <option value="">All Marketplaces</option>
                            <option
                                v-for="m in marketplaces"
                                :key="m.id"
                                :value="m.id"
                            >
                                {{ m.name }}
                            </option>
                        </FormSelect>
                        <FormSelect
                            v-model="filters.product_id"
                            class="w-40"
                            @change="applyFilters"
                        >
                            <option value="">All Products</option>
                            <option
                                v-for="p in products"
                                :key="p.id"
                                :value="p.id"
                            >
                                {{ p.name }}
                            </option>
                        </FormSelect>
                        <FormInput
                            v-model="filters.date_from"
                            type="date"
                            class="w-40"
                            @change="applyFilters"
                        />
                        <FormInput
                            v-model="filters.date_to"
                            type="date"
                            class="w-40"
                            @change="applyFilters"
                        />
                    </div>
                </div>
            </template>

            <DataTable
                :paginated-data="sales"
                :columns="columns"
                :show-actions="false"
            >
                <template #cell-sale_date="{ row }">
                    {{ formatDate(row.sale_date) }}
                </template>

                <template #cell-product="{ row }">
                    {{ row.product?.name || "-" }}
                </template>

                <template #cell-marketplace="{ row }">
                    {{ row.marketplace?.name || "-" }}
                </template>

                <template #cell-gross_amount="{ row }">
                    {{ formatCurrency(row.gross_amount) }}
                </template>

                <template #cell-marketplace_fee="{ row }">
                    <span class="text-red-500">
                        -{{ formatCurrency(row.marketplace_fee) }}
                    </span>
                </template>

                <template #cell-net_amount="{ row }">
                    <span
                        class="font-semibold text-green-600 dark:text-green-400"
                    >
                        {{ formatCurrency(row.net_amount) }}
                    </span>
                </template>
            </DataTable>
        </Card>
    </AdminLayout>
</template>
