<script setup>
import { ref, computed, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    columns: {
        type: Array,
        required: true,
        // Each column: { key: string, label: string, sortable?: boolean, searchable?: boolean }
    },
    // Laravel paginated data - expects the standard Laravel pagination object
    paginatedData: {
        type: Object,
        default: () => ({
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 0,
            to: 0,
        }),
    },
    // For backward compatibility - raw array data for client-side pagination
    data: {
        type: Array,
        default: null,
    },
    perPageOptions: {
        type: Array,
        default: () => [10, 25, 50, 100],
    },
    // Base URL for server-side pagination requests
    baseUrl: {
        type: String,
        default: null,
    },
    // Show actions column
    showActions: {
        type: Boolean,
        default: true,
    },
    // Actions column label
    actionsLabel: {
        type: String,
        default: "Actions",
    },
    // Enable row selection
    selectable: {
        type: Boolean,
        default: false,
    },
    // Selected items (v-model)
    modelValue: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["row-click", "action", "update:modelValue"]);

// Determine if using server-side or client-side pagination
const isServerSide = computed(
    () => props.paginatedData && props.paginatedData.data,
);

// Local state for client-side pagination
const search = ref("");
const sortColumn = ref(null);
const sortDirection = ref("asc");
const clientCurrentPage = ref(1);
const clientPerPage = ref(10);

// Debounce search for server-side
let searchTimeout = null;
const handleSearch = (event) => {
    search.value = event.target.value;

    if (isServerSide.value) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchPage(1);
        }, 300);
    }
};

// Selection Logic
const toggleSelection = (id) => {
    const newSelection = [...props.modelValue];
    const index = newSelection.indexOf(id);
    if (index === -1) {
        newSelection.push(id);
    } else {
        newSelection.splice(index, 1);
    }
    emit("update:modelValue", newSelection);
};

const toggleAll = (event) => {
    if (event.target.checked) {
        const allIds = displayData.value.map((item) => item.id);
        const newSelection = [...new Set([...props.modelValue, ...allIds])];
        emit("update:modelValue", newSelection);
    } else {
        const displayedIds = displayData.value.map((item) => item.id);
        const newSelection = props.modelValue.filter(
            (id) => !displayedIds.includes(id),
        );
        emit("update:modelValue", newSelection);
    }
};

const allSelected = computed(() => {
    if (displayData.value.length === 0) return false;
    const displayedIds = displayData.value.map((item) => item.id);
    return (
        displayedIds.length > 0 &&
        displayedIds.every((id) => props.modelValue.includes(id))
    );
});

const indeterminate = computed(() => {
    if (displayData.value.length === 0) return false;
    const displayedIds = displayData.value.map((item) => item.id);
    const selectedCount = displayedIds.filter((id) =>
        props.modelValue.includes(id),
    ).length;
    return selectedCount > 0 && selectedCount < displayedIds.length;
});

// Server-side pagination: navigate using Inertia
const fetchPage = (page, perPage = null) => {
    if (!isServerSide.value) return;

    const params = {
        page,
        per_page: perPage || props.paginatedData.per_page,
    };

    if (search.value) {
        params.search = search.value;
    }

    if (sortColumn.value) {
        params.sort = sortColumn.value;
        params.direction = sortDirection.value;
    }

    router.get(props.baseUrl || window.location.pathname, params, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Client-side filtering
const filteredData = computed(() => {
    if (isServerSide.value) return props.paginatedData.data;
    if (!props.data) return [];
    if (!search.value) return props.data;

    const searchLower = search.value.toLowerCase();
    return props.data.filter((row) => {
        return props.columns.some((col) => {
            if (col.searchable === false) return false;
            const value = row[col.key];
            return value && String(value).toLowerCase().includes(searchLower);
        });
    });
});

// Client-side sorting
const sortedData = computed(() => {
    if (isServerSide.value) return filteredData.value;
    if (!sortColumn.value) return filteredData.value;

    return [...filteredData.value].sort((a, b) => {
        const aVal = a[sortColumn.value] ?? "";
        const bVal = b[sortColumn.value] ?? "";

        if (typeof aVal === "number" && typeof bVal === "number") {
            return sortDirection.value === "asc" ? aVal - bVal : bVal - aVal;
        }

        const comparison = String(aVal).localeCompare(String(bVal));
        return sortDirection.value === "asc" ? comparison : -comparison;
    });
});

// Client-side pagination
const paginatedClientData = computed(() => {
    if (isServerSide.value) return sortedData.value;
    const start = (clientCurrentPage.value - 1) * clientPerPage.value;
    return sortedData.value.slice(start, start + clientPerPage.value);
});

// Unified computed values
const displayData = computed(() => paginatedClientData.value);
const currentPage = computed(() =>
    isServerSide.value
        ? props.paginatedData.current_page
        : clientCurrentPage.value,
);
const perPage = computed(() =>
    isServerSide.value ? props.paginatedData.per_page : clientPerPage.value,
);
const totalRecords = computed(() =>
    isServerSide.value ? props.paginatedData.total : props.data?.length || 0,
);
const totalFiltered = computed(() =>
    isServerSide.value ? props.paginatedData.total : filteredData.value.length,
);
const totalPages = computed(() =>
    isServerSide.value
        ? props.paginatedData.last_page
        : Math.ceil(totalFiltered.value / clientPerPage.value),
);
const fromRecord = computed(() =>
    isServerSide.value
        ? props.paginatedData.from
        : (clientCurrentPage.value - 1) * clientPerPage.value + 1,
);
const toRecord = computed(() =>
    isServerSide.value
        ? props.paginatedData.to
        : Math.min(
              clientCurrentPage.value * clientPerPage.value,
              totalFiltered.value,
          ),
);

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;
    const delta = 1; // Number of pages valid before/after current page
    const range = [];
    const rangeWithDots = [];

    // If total pages is small, show all
    if (total <= 7) {
        for (let i = 1; i <= total; i++) {
            range.push(i);
        }
        return range;
    }

    let left = current - delta;
    let right = current + delta;

    // Ensure we don't go out of bounds
    if (left < 3) {
        // If near start, show more at start
        left = 1;
        right = 5;
    } else if (right > total - 2) {
        // If near end, show more at end
        left = total - 4;
        right = total;
    }

    // Always include first and last
    for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= left && i <= right)) {
            range.push(i);
        }
    }

    let l = null;
    for (const i of range) {
        if (l) {
            if (i - l === 2) {
                rangeWithDots.push(l + 1);
            } else if (i - l !== 1) {
                rangeWithDots.push("...");
            }
        }
        rangeWithDots.push(i);
        l = i;
    }

    return rangeWithDots;
});

const sort = (column) => {
    if (column.sortable === false) return;

    if (sortColumn.value === column.key) {
        sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
    } else {
        sortColumn.value = column.key;
        sortDirection.value = "asc";
    }

    if (isServerSide.value) {
        fetchPage(1);
    }
};

const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return;

    if (isServerSide.value) {
        fetchPage(page);
    } else {
        clientCurrentPage.value = page;
    }
};

const changePerPage = (newPerPage) => {
    if (isServerSide.value) {
        fetchPage(1, newPerPage);
    } else {
        clientPerPage.value = newPerPage;
        clientCurrentPage.value = 1;
    }
};

// Reset to page 1 when search changes (client-side only)
watch(search, () => {
    if (!isServerSide.value) {
        clientCurrentPage.value = 1;
    }
});

// Expose reload method for compatibility
const reload = () => {
    if (isServerSide.value) {
        fetchPage(currentPage.value);
    }
};

defineExpose({ reload });
</script>

<template>
    <div class="space-y-4">
        <!-- Controls -->
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-secondary-600 dark:text-secondary-400"
                    >Show</span
                >
                <select
                    :value="perPage"
                    @change="changePerPage(Number($event.target.value))"
                    class="rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500/20 focus:ring-2 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white py-1.5 pl-3 pr-8 text-sm transition-colors duration-200 focus:outline-none"
                >
                    <option
                        v-for="opt in perPageOptions"
                        :key="opt"
                        :value="opt"
                    >
                        {{ opt }}
                    </option>
                </select>
                <span class="text-sm text-secondary-600 dark:text-secondary-400"
                    >entries</span
                >
            </div>
            <div class="relative">
                <input
                    :value="search"
                    @input="handleSearch"
                    type="text"
                    placeholder="Search..."
                    class="rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500/20 focus:ring-2 dark:bg-secondary-800 dark:border-secondary-600 dark:text-white pl-10 py-1.5 text-sm w-full sm:w-64 transition-colors duration-200 focus:outline-none"
                />
                <svg
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                </svg>
            </div>
        </div>

        <!-- Table -->
        <div
            class="overflow-x-auto rounded-lg border border-secondary-200 dark:border-secondary-700"
        >
            <table class="w-full text-sm">
                <thead class="bg-secondary-50 border-b- dark:bg-secondary-800">
                    <tr
                        class="border-b border-secondary-200 dark:border-secondary-700"
                    >
                        <th v-if="selectable" class="px-4 py-3 w-4">
                            <input
                                type="checkbox"
                                :checked="allSelected"
                                :indeterminate="indeterminate"
                                @change="toggleAll"
                                class="h-4 w-4 rounded border-secondary-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition-colors duration-200 dark:border-secondary-600 dark:bg-secondary-800 dark:checked:bg-primary"
                            />
                        </th>
                        <th
                            v-for="col in columns"
                            :key="col.key"
                            @click="sort(col)"
                            class="px-4 py-3 text-left font-medium text-secondary-600 dark:text-secondary-300"
                            :class="{
                                'cursor-pointer hover:bg-secondary-100 dark:hover:bg-secondary-700':
                                    col.sortable !== false,
                            }"
                        >
                            <div class="flex items-center gap-2">
                                {{ col.label }}
                                <span
                                    v-if="
                                        col.sortable !== false &&
                                        sortColumn === col.key
                                    "
                                    class="text-primary"
                                >
                                    <svg
                                        v-if="sortDirection === 'asc'"
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 15l7-7 7 7"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <!-- Actions column header -->
                        <th
                            v-if="showActions"
                            class="px-4 py-3 text-left font-medium text-secondary-600 dark:text-secondary-300"
                        >
                            {{ actionsLabel }}
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="divide-y divide-secondary-200 dark:divide-secondary-700"
                >
                    <!-- Empty -->
                    <tr v-if="displayData.length === 0">
                        <td
                            :colspan="columns.length + (showActions ? 1 : 0)"
                            class="px-4 py-8 text-center text-secondary-500 b"
                        >
                            No data available
                        </td>
                    </tr>

                    <!-- Data rows -->
                    <tr
                        v-else
                        v-for="(row, index) in displayData"
                        :key="row.id || index"
                        class="bg-white dark:bg-secondary-800 hover:bg-secondary-400 hover:text-white dark:hover:bg-secondary-750"
                    >
                        <td v-if="selectable" class="px-4 py-3">
                            <input
                                type="checkbox"
                                :checked="modelValue.includes(row.id)"
                                @change="toggleSelection(row.id)"
                                class="h-4 w-4 rounded border-secondary-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition-colors duration-200 dark:border-secondary-600 dark:bg-secondary-800 dark:checked:bg-primary"
                            />
                        </td>
                        <td
                            v-for="col in columns"
                            :key="col.key"
                            class="px-4 py-3"
                        >
                            <slot
                                :name="`cell-${col.key}`"
                                :row="row"
                                :value="row[col.key]"
                            >
                                <span v-html="row[col.key]"></span>
                            </slot>
                        </td>
                        <!-- Actions column cell -->
                        <td v-if="showActions" class="px-4 py-3">
                            <slot name="actions" :item="row" :row="row"></slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            class="flex flex-col sm:flex-row items-center justify-between gap-4"
        >
            <p class="text-sm text-secondary-600 dark:text-secondary-400">
                Showing {{ fromRecord }} to {{ toRecord }} of
                {{ totalFiltered }} entries
                <span v-if="!isServerSide && totalFiltered !== totalRecords">
                    (filtered from {{ totalRecords }} total entries)
                </span>
            </p>

            <div class="flex items-center gap-1">
                <button
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage <= 1"
                    class="px-3 py-1.5 text-sm rounded border border-secondary-300 dark:border-secondary-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-secondary-100 dark:hover:bg-secondary-700"
                >
                    Previous
                </button>

                <template v-for="(page, index) in visiblePages" :key="index">
                    <button
                        v-if="page !== '...'"
                        @click="goToPage(page)"
                        class="px-3 py-1.5 text-sm rounded border"
                        :class="
                            page === currentPage
                                ? 'bg-primary text-white border-primary'
                                : 'border-secondary-300 dark:border-secondary-600 hover:bg-secondary-100 dark:hover:bg-secondary-700'
                        "
                    >
                        {{ page }}
                    </button>
                    <span v-else class="px-2 text-secondary-400"> ... </span>
                </template>

                <button
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage >= totalPages"
                    class="px-3 py-1.5 text-sm rounded border border-secondary-300 dark:border-secondary-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-secondary-100 dark:hover:bg-secondary-700"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
