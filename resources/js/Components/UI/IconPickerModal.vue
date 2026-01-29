<script setup>
import { ref, computed, watch } from "vue";
import Modal from "@/Components/UI/Modal.vue";
import HeroIcon from "@/Components/UI/HeroIcon.vue";

const props = defineProps({
    show: Boolean,
    selectedIcon: String,
});

const emit = defineEmits(["close", "select"]);

const searchQuery = ref("");

const heroIcons = [
    "home",
    "home-modern",
    "bars-3",
    "bars-3-bottom-left",
    "bars-3-bottom-right",
    "bars-3-center-left",
    "bars-4",
    "squares-2x2",
    "squares-plus",
    "view-columns",
    "view-finder-circle",
    "x-mark",
    "x-circle",
    "check",
    "check-circle",
    "chevron-down",
    "chevron-up",
    "chevron-left",
    "chevron-right",
    "chevron-double-down",
    "chevron-double-up",
    "chevron-double-left",
    "chevron-double-right",
    "arrow-down",
    "arrow-up",
    "arrow-left",
    "arrow-right",
    "arrow-long-down",
    "arrow-long-up",
    "arrow-long-left",
    "arrow-long-right",
    "arrow-path",
    "arrow-path-rounded-square",
    "arrows-pointing-in",
    "arrows-pointing-out",
    "arrow-top-right-on-square",
    "arrow-down-tray",
    "arrow-up-tray",
    "arrow-uturn-left",
    "arrow-uturn-right",

    "document",
    "document-text",
    "document-duplicate",
    "document-check",
    "document-plus",
    "document-minus",
    "document-arrow-down",
    "document-arrow-up",
    "document-magnifying-glass",
    "folder",
    "folder-open",
    "folder-plus",
    "folder-minus",
    "folder-arrow-down",
    "clipboard",
    "clipboard-document",
    "clipboard-document-check",
    "clipboard-document-list",
    "paper-clip",
    "newspaper",
    "book-open",
    "bookmark",
    "bookmark-square",
    "book-mark-slash",

    "user",
    "user-plus",
    "user-minus",
    "user-circle",
    "user-group",
    "users",
    "identification",
    "finger-print",
    "hand-raised",
    "hand-thumb-up",
    "hand-thumb-down",

    "chat-bubble-left",
    "chat-bubble-left-right",
    "chat-bubble-bottom-center",
    "chat-bubble-bottom-center-text",
    "chat-bubble-oval-left",
    "chat-bubble-oval-left-ellipsis",
    "envelope",
    "envelope-open",
    "inbox",
    "inbox-arrow-down",
    "inbox-stack",
    "phone",
    "phone-arrow-down-left",
    "phone-arrow-up-right",
    "phone-x-mark",
    "megaphone",
    "speaker-wave",
    "speaker-x-mark",
    "bell",
    "bell-alert",
    "bell-slash",
    "bell-snooze",

    "photo",
    "camera",
    "film",
    "video-camera",
    "video-camera-slash",
    "microphone",
    "musical-note",
    "play",
    "pause",
    "stop",
    "forward",
    "backward",
    "play-circle",
    "pause-circle",
    "play-pause",

    "chart-bar",
    "chart-bar-square",
    "chart-pie",
    "presentation-chart-bar",
    "presentation-chart-line",
    "table-cells",
    "rectangle-stack",
    "circle-stack",
    "server",
    "server-stack",
    "database",

    "cog",
    "cog-6-tooth",
    "cog-8-tooth",
    "wrench",
    "wrench-screwdriver",
    "adjustments-horizontal",
    "adjustments-vertical",
    "funnel",
    "paint-brush",
    "pencil",
    "pencil-square",
    "scissors",
    "trash",
    "archive-box",
    "archive-box-arrow-down",
    "archive-box-x-mark",

    "lock-closed",
    "lock-open",
    "key",
    "shield-check",
    "shield-exclamation",
    "eye",
    "eye-slash",
    "eye-dropper",
    "finger-print",

    "shopping-bag",
    "shopping-cart",
    "credit-card",
    "banknotes",
    "currency-dollar",
    "currency-euro",
    "currency-pound",
    "currency-yen",
    "receipt-percent",
    "receipt-refund",
    "ticket",
    "gift",
    "gift-top",

    "exclamation-circle",
    "exclamation-triangle",
    "information-circle",
    "question-mark-circle",
    "check-badge",
    "no-symbol",
    "minus-circle",
    "plus-circle",
    "plus",
    "minus",

    "map",
    "map-pin",
    "globe-alt",
    "globe-americas",
    "globe-asia-australia",
    "globe-europe-africa",
    "building-library",
    "building-office",
    "building-office-2",
    "building-storefront",
    "home-modern",

    "calendar",
    "calendar-days",
    "clock",
    "stopwatch",

    "computer-desktop",
    "device-phone-mobile",
    "device-tablet",
    "tv",
    "cpu-chip",
    "cube",
    "cube-transparent",
    "command-line",
    "code-bracket",
    "code-bracket-square",
    "wifi",
    "signal",
    "signal-slash",
    "rss",
    "qr-code",
    "link",
    "cursor-arrow-rays",
    "cursor-arrow-ripple",

    "sun",
    "moon",
    "cloud",
    "cloud-arrow-down",
    "cloud-arrow-up",
    "bolt",
    "fire",
    "sparkles",
    "star",
    "heart",
    "lifebuoy",
    "light-bulb",
    "beaker",
    "bug-ant",
    "face-smile",
    "face-frown",

    "magnifying-glass",
    "magnifying-glass-circle",
    "magnifying-glass-plus",
    "magnifying-glass-minus",
    "at-symbol",
    "hashtag",
    "tag",
    "ellipsis-horizontal",
    "ellipsis-vertical",
    "ellipsis-horizontal-circle",
    "bars-arrow-down",
    "bars-arrow-up",
    "list-bullet",
    "numbered-list",
    "queue-list",
    "rectangle-group",
    "swatch",
    "puzzle-piece",
    "power",
    "rocket-launch",
    "academic-cap",
    "trophy",
    "flag",
    "cake",
    "language",
    "printer",
    "paper-airplane",
    "calculator",
    "truck",
    "scale",
    "variable",
];

const filteredIcons = computed(() => {
    if (!searchQuery.value.trim()) {
        return heroIcons;
    }
    const query = searchQuery.value.toLowerCase();
    return heroIcons.filter((icon) => icon.toLowerCase().includes(query));
});

const selectIcon = (icon) => {
    emit("select", icon);
    emit("close");
};

watch(
    () => props.show,
    (newVal) => {
        if (newVal) {
            searchQuery.value = "";
        }
    },
);
</script>

<template>
    <Modal
        :show="show"
        title="Select Icon"
        size="xl"
        z-index="z-[60]"
        @close="emit('close')"
    >
        <div class="mb-4">
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                    <HeroIcon
                        name="magnifying-glass"
                        class="w-5 h-5 text-secondary-400"
                    />
                </div>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search icons..."
                    class="block w-full pl-10 pr-4 py-2 border border-secondary-300 rounded-lg bg-white dark:bg-secondary-800 dark:border-secondary-600 text-secondary-900 dark:text-white placeholder-secondary-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
            </div>
        </div>

        <div
            class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-2 max-h-[400px] overflow-y-auto p-1"
        >
            <button
                v-for="icon in filteredIcons"
                :key="icon"
                type="button"
                @click="selectIcon(icon)"
                class="flex flex-col items-center justify-center p-3 rounded-lg border-2 transition-all duration-150 hover:bg-primary-50 dark:hover:bg-primary-900/30"
                :class="
                    selectedIcon === icon
                        ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/30'
                        : 'border-transparent hover:border-primary-300 dark:hover:border-primary-700'
                "
                :title="icon"
            >
                <HeroIcon
                    :name="icon"
                    class="w-6 h-6 text-secondary-700 dark:text-secondary-300"
                />
                <span
                    class="mt-1 text-[10px] text-secondary-500 dark:text-secondary-400 truncate w-full text-center"
                >
                    {{ icon }}
                </span>
            </button>
        </div>

        <div
            v-if="filteredIcons.length === 0"
            class="flex flex-col items-center justify-center py-8 text-secondary-500"
        >
            <HeroIcon name="face-frown" class="w-12 h-12 mb-2" />
            <p>No icons found matching "{{ searchQuery }}"</p>
        </div>

        <template #footer>
            <p
                class="text-sm text-secondary-500 dark:text-secondary-400 mr-auto"
            >
                {{ filteredIcons.length }} icons available
            </p>
            <button
                type="button"
                @click="emit('close')"
                class="px-4 py-2 text-sm font-medium text-secondary-700 bg-white border border-secondary-300 rounded-lg hover:bg-secondary-50 dark:bg-secondary-800 dark:text-secondary-300 dark:border-secondary-600 dark:hover:bg-secondary-700"
            >
                Cancel
            </button>
        </template>
    </Modal>
</template>
