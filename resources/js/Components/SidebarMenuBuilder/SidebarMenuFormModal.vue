<script setup>
import { ref, watch, computed } from "vue";
import Modal from "@/Components/UI/Modal.vue";
import Button from "@/Components/UI/Button.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import IconPickerModal from "@/Components/UI/IconPickerModal.vue";
import HeroIcon from "@/Components/UI/HeroIcon.vue";

const props = defineProps({
    show: Boolean,
    menu: Object,
    parentMenu: Object,
    allMenus: Array,
    sections: Array,
});

const emit = defineEmits(["close", "submit"]);

const form = ref({
    title: "",
    icon: "database",
    route_name: "",
    section: "MAIN NAVIGATION",
    permission: "",
    parent_id: null,
    is_active: true,
});

const errors = ref({});
const showIconPicker = ref(false);

watch(
    () => props.show,
    (newVal) => {
        if (newVal) {
            errors.value = {};
            showIconPicker.value = false;
            if (props.menu) {
                form.value = {
                    title: props.menu.title || "",
                    icon: props.menu.icon || "database",
                    route_name: props.menu.route_name || "",
                    section: props.menu.section || "MAIN NAVIGATION",
                    permission: props.menu.permission || "",
                    parent_id: props.menu.parent_id || null,
                    is_active: props.menu.is_active ?? true,
                };
            } else if (props.parentMenu) {
                form.value = {
                    title: "",
                    icon: "database",
                    route_name: "",
                    section: props.parentMenu.section,
                    permission: "",
                    parent_id: props.parentMenu.id,
                    is_active: true,
                };
            } else {
                form.value = {
                    title: "",
                    icon: "database",
                    route_name: "",
                    section: props.sections?.[0] || "MAIN NAVIGATION",
                    permission: "",
                    parent_id: null,
                    is_active: true,
                };
            }
        }
    },
);

const modalTitle = computed(() => {
    if (props.menu) return "Edit Menu";
    if (props.parentMenu) return `Add Child to "${props.parentMenu.title}"`;
    return "Add New Menu";
});

const sectionOptions = computed(() => {
    const defaultSections = ["MAIN NAVIGATION", "OTHER"];
    const allSections = [
        ...new Set([...defaultSections, ...(props.sections || [])]),
    ];
    return allSections.map((s) => ({ value: s, label: s }));
});

const parentOptions = computed(() => {
    const options = [{ value: null, label: "None (Root Level)" }];

    if (props.allMenus) {
        props.allMenus.forEach((menu) => {
            if (props.menu && menu.id === props.menu.id) return;

            options.push({
                value: menu.id,
                label: `${menu.section} > ${menu.title}`,
            });
        });
    }

    return options;
});

const handleIconSelect = (icon) => {
    form.value.icon = icon;
};

const validate = () => {
    errors.value = {};

    if (!form.value.title?.trim()) {
        errors.value.title = "Title is required";
    }

    if (!form.value.section?.trim()) {
        errors.value.section = "Section is required";
    }

    return Object.keys(errors.value).length === 0;
};

const handleSubmit = () => {
    if (!validate()) return;

    emit("submit", { ...form.value });
};
</script>

<template>
    <Modal
        :show="show"
        :title="modalTitle"
        size="md"
        :closeable="!showIconPicker"
        @close="emit('close')"
    >
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <FormInput
                v-model="form.title"
                label="Title"
                placeholder="Menu title"
                :error="errors.title"
                required
            />

            <div>
                <label
                    class="block text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-1"
                >
                    Icon
                </label>
                <button
                    type="button"
                    @click="showIconPicker = true"
                    class="flex items-center gap-3 w-full px-4 py-2.5 border border-secondary-300 rounded-lg bg-white dark:bg-secondary-800 dark:border-secondary-600 hover:bg-secondary-50 dark:hover:bg-secondary-700 transition-colors"
                >
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg"
                    >
                        <HeroIcon
                            :name="form.icon || 'database'"
                            class="w-6 h-6 text-primary-600 dark:text-primary-400"
                        />
                    </div>
                    <div class="flex-1 text-left">
                        <p
                            class="text-sm font-medium text-secondary-900 dark:text-white"
                        >
                            {{ form.icon || "database" }}
                        </p>
                        <p
                            class="text-xs text-secondary-500 dark:text-secondary-400"
                        >
                            Click to change icon
                        </p>
                    </div>
                    <HeroIcon
                        name="chevron-right"
                        class="w-5 h-5 text-secondary-400"
                    />
                </button>
            </div>

            <FormInput
                v-model="form.route_name"
                label="Route Name"
                placeholder="e.g., dashboard, users.index"
                :error="errors.route_name"
            />

            <FormInput
                v-model="form.permission"
                label="Permission"
                placeholder="e.g., users_view"
                :error="errors.permission"
            />

            <FormSelect
                v-if="!parentMenu"
                v-model="form.section"
                label="Section"
                :options="sectionOptions"
                :error="errors.section"
                required
            />

            <FormSelect
                v-if="!parentMenu"
                v-model="form.parent_id"
                label="Parent Menu"
                :options="parentOptions"
                :error="errors.parent_id"
            />

            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        v-model="form.is_active"
                        class="sr-only peer"
                    />
                    <div
                        class="w-11 h-6 bg-secondary-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-secondary-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-secondary-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-secondary-600 peer-checked:bg-primary-600"
                    ></div>
                    <span
                        class="ml-3 text-sm font-medium text-secondary-700 dark:text-secondary-300"
                    >
                        Active
                    </span>
                </label>
            </div>
        </form>

        <template #footer>
            <Button variant="secondary" @click="emit('close')">Cancel</Button>
            <Button variant="primary" @click="handleSubmit">
                {{ menu ? "Update" : "Create" }}
            </Button>
        </template>
    </Modal>

    <Teleport to="body">
        <IconPickerModal
            :show="showIconPicker"
            :selected-icon="form.icon"
            @close="showIconPicker = false"
            @select="handleIconSelect"
        />
    </Teleport>
</template>
