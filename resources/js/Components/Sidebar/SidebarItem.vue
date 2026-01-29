<script setup>
import { ref, computed, watch } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { ChevronDownIcon } from "@heroicons/vue/24/outline";
import HeroIcon from "@/Components/UI/HeroIcon.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
});

const page = usePage();

const hasChildren = computed(() => props.item.children?.length > 0);
const visibleChildren = computed(
    () => props.item.children?.filter((child) => child.show !== false) || [],
);

// Check if any child is active (exact match for items with href)
const hasActiveChild = computed(() => {
    return visibleChildren.value.some((child) => {
        return isChildActive(child.href);
    });
});

// Check if the current item itself is active (for items without children)
const isActive = computed(() => {
    if (props.item.href) {
        return isChildActive(props.item.href);
    }
    return hasActiveChild.value;
});

// Check if a specific child is active
const isChildActive = (childHref) => {
    if (page.url === childHref) {
        return true;
    }

    if (page.url.startsWith(childHref + "/")) {
        const hasMoreSpecificMatch = visibleChildren.value.some((sibling) => {
            return (
                sibling.href !== childHref &&
                (page.url === sibling.href ||
                    page.url.startsWith(sibling.href + "/"))
            );
        });
        return !hasMoreSpecificMatch;
    }

    return false;
};

// Initialize expanded state based on whether any child is active
const expanded = ref(hasActiveChild.value);

// Watch for route changes to auto-expand when navigating to a child
watch(
    () => page.url,
    () => {
        if (hasActiveChild.value) {
            expanded.value = true;
        }
    },
);

const toggleExpand = () => {
    if (hasChildren.value) {
        expanded.value = !expanded.value;
    }
};

// Check if icon is a component (function/object) or a string name
const isIconComponent = computed(() => {
    return (
        typeof props.item.icon === "function" ||
        typeof props.item.icon === "object"
    );
});
</script>

<template>
    <li>
        <!-- Item with children (submenu) -->
        <template v-if="hasChildren && visibleChildren.length">
            <button
                @click="toggleExpand"
                class="flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors"
                :class="
                    isActive
                        ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300'
                        : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700'
                "
            >
                <span class="flex items-center">
                    <!-- Component icon (static menus) -->
                    <component
                        v-if="item.icon && isIconComponent"
                        :is="item.icon"
                        class="w-5 h-5 mr-3"
                    />
                    <!-- String icon name (dynamic menus from database) -->
                    <HeroIcon
                        v-else-if="item.icon"
                        :name="item.icon"
                        class="w-5 h-5 mr-3"
                    />
                    {{ item.name }}
                </span>
                <ChevronDownIcon
                    class="w-4 h-4 transition-transform"
                    :class="expanded ? 'rotate-180' : ''"
                />
            </button>

            <!-- Submenu -->
            <ul
                v-show="expanded"
                class="mt-1 ml-6 space-y-1 border-l border-secondary-200 dark:border-secondary-600"
            >
                <li v-for="child in visibleChildren" :key="child.name">
                    <Link
                        :href="child.href"
                        class="block px-3 py-1.5 text-sm rounded-lg transition-colors"
                        :class="
                            isChildActive(child.href)
                                ? 'text-primary-600 dark:text-primary-400 font-medium'
                                : 'text-secondary-500 dark:text-secondary-400 hover:text-secondary-700 dark:hover:text-secondary-200'
                        "
                    >
                        {{ child.name }}
                    </Link>
                </li>
            </ul>
        </template>

        <!-- Single item (no children) -->
        <template v-else>
            <Link
                :href="item.href"
                class="flex items-center px-3 py-2 rounded-lg transition-colors"
                :class="
                    isActive
                        ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300'
                        : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700'
                "
            >
                <!-- Component icon (static menus) -->
                <component
                    v-if="item.icon && isIconComponent"
                    :is="item.icon"
                    class="w-5 h-5 mr-3"
                />
                <!-- String icon name (dynamic menus from database) -->
                <HeroIcon
                    v-else-if="item.icon"
                    :name="item.icon"
                    class="w-5 h-5 mr-3"
                />
                {{ item.name }}
            </Link>
        </template>
    </li>
</template>
