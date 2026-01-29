<script setup>
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Modal from "@/Components/UI/Modal.vue";
import { useToast } from "vue-toastification";
import {
    SwatchIcon,
    PhotoIcon,
    ComputerDesktopIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Theme Settings",
    },
    settings: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

// Color settings form
const colorForm = useForm({
    primary_color: props.settings.primary_color?.value || "#6771cf",
    secondary_color: props.settings.secondary_color?.value || "#6c757d",
    success_color: props.settings.success_color?.value || "#198754",
    danger_color: props.settings.danger_color?.value || "#dc3545",
    warning_color: props.settings.warning_color?.value || "#ffc107",
    info_color: props.settings.info_color?.value || "#0dcaf0",
    light_bg_color: props.settings.light_bg_color?.value || "#f2f7ff",
    dark_bg_color: props.settings.dark_bg_color?.value || "#1a1d21",
    sidebar_bg_light: props.settings.sidebar_bg_light?.value || "#ffffff",
    sidebar_bg_dark: props.settings.sidebar_bg_dark?.value || "#212529",
});

// Image upload forms
const logoForm = useForm({
    logo: null,
    type: "app_logo",
});

const logoDarkForm = useForm({
    logo: null,
    type: "app_logo_dark",
});

const faviconForm = useForm({
    logo: null,
    type: "favicon",
});

// Preview URLs
const logoPreview = ref(null);
const logoDarkPreview = ref(null);
const faviconPreview = ref(null);

// Current images
const currentLogo = computed(() => props.settings.app_logo?.value);
const currentLogoDark = computed(() => props.settings.app_logo_dark?.value);
const currentFavicon = computed(() => props.settings.favicon?.value);

// Reset confirmation modal
const showResetModal = ref(false);

// Color inputs configuration
const colorInputs = [
    { key: "primary_color", label: "Primary Color" },
    { key: "secondary_color", label: "Secondary Color" },
    { key: "success_color", label: "Success Color" },
    { key: "danger_color", label: "Danger Color" },
    { key: "warning_color", label: "Warning Color" },
    { key: "info_color", label: "Info Color" },
];

const bgColorInputs = [
    { key: "light_bg_color", label: "Light Theme Background" },
    { key: "dark_bg_color", label: "Dark Theme Background" },
    { key: "sidebar_bg_light", label: "Sidebar Background (Light)" },
    { key: "sidebar_bg_dark", label: "Sidebar Background (Dark)" },
];

const submitColors = () => {
    colorForm.put("/admin/settings/theme", {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Theme colors updated successfully");
        },
        onError: () => {
            toast.error("Failed to update theme colors");
        },
    });
};

const handleLogoChange = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
        if (type === "app_logo") {
            logoPreview.value = e.target.result;
            logoForm.logo = file;
        } else if (type === "app_logo_dark") {
            logoDarkPreview.value = e.target.result;
            logoDarkForm.logo = file;
        } else {
            faviconPreview.value = e.target.result;
            faviconForm.logo = file;
        }
    };
    reader.readAsDataURL(file);
};

const uploadLogo = (type) => {
    const form =
        type === "app_logo"
            ? logoForm
            : type === "app_logo_dark"
              ? logoDarkForm
              : faviconForm;

    form.post("/admin/settings/upload-logo", {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Image uploaded successfully");
            // Clear preview
            if (type === "app_logo") logoPreview.value = null;
            else if (type === "app_logo_dark") logoDarkPreview.value = null;
            else faviconPreview.value = null;
        },
        onError: () => {
            toast.error("Failed to upload image");
        },
    });
};

const removeLogo = (type) => {
    if (!confirm("Are you sure you want to remove this image?")) return;

    router.delete("/admin/settings/remove-logo", {
        data: { type },
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Image removed successfully");
        },
        onError: () => {
            toast.error("Failed to remove image");
        },
    });
};

const resetToDefaults = () => {
    router.post(
        "/admin/settings/theme/reset",
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Theme reset to defaults");
                showResetModal.value = false;
                // Update form values
                colorForm.primary_color = "#6771cf";
                colorForm.secondary_color = "#6c757d";
                colorForm.success_color = "#198754";
                colorForm.danger_color = "#dc3545";
                colorForm.warning_color = "#ffc107";
                colorForm.info_color = "#0dcaf0";
                colorForm.light_bg_color = "#f2f7ff";
                colorForm.dark_bg_color = "#1a1d21";
                colorForm.sidebar_bg_light = "#ffffff";
                colorForm.sidebar_bg_dark = "#212529";
            },
            onError: () => {
                toast.error("Failed to reset theme");
            },
        },
    );
};

const getImageUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `/storage/${path}`;
};
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="space-y-6">
            <!-- Color Settings -->
            <Card>
                <template #header>
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-2">
                            <SwatchIcon class="w-5 h-5 text-primary" />
                            <span class="font-semibold">Color Settings</span>
                        </div>
                        <Button
                            type="button"
                            variant="secondary"
                            size="sm"
                            @click="showResetModal = true"
                        >
                            Reset to Defaults
                        </Button>
                    </div>
                </template>

                <form @submit.prevent="submitColors" class="space-y-6">
                    <!-- Primary Colors -->
                    <div>
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-4"
                        >
                            Theme Colors
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div
                                v-for="input in colorInputs"
                                :key="input.key"
                                class="space-y-2"
                            >
                                <label
                                    class="block text-sm font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    {{ input.label }}
                                </label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="color"
                                        v-model="colorForm[input.key]"
                                        class="w-10 h-10 rounded cursor-pointer border border-secondary-300 dark:border-secondary-600"
                                    />
                                    <input
                                        type="text"
                                        v-model="colorForm[input.key]"
                                        class="flex-1 px-3 py-2 text-sm border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-800 text-secondary-900 dark:text-white"
                                        pattern="^#[a-fA-F0-9]{6}$"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Background Colors -->
                    <div>
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-4"
                        >
                            Background Colors
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="input in bgColorInputs"
                                :key="input.key"
                                class="space-y-2"
                            >
                                <label
                                    class="block text-sm font-medium text-secondary-600 dark:text-secondary-400"
                                >
                                    {{ input.label }}
                                </label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="color"
                                        v-model="colorForm[input.key]"
                                        class="w-10 h-10 rounded cursor-pointer border border-secondary-300 dark:border-secondary-600"
                                    />
                                    <input
                                        type="text"
                                        v-model="colorForm[input.key]"
                                        class="flex-1 px-3 py-2 text-sm border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-800 text-secondary-900 dark:text-white"
                                        pattern="^#[a-fA-F0-9]{6}$"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Color Preview -->
                    <div>
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-4"
                        >
                            Preview
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-3 py-1 text-white rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.primary_color,
                                }"
                                >Primary</span
                            >
                            <span
                                class="px-3 py-1 text-white rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.secondary_color,
                                }"
                                >Secondary</span
                            >
                            <span
                                class="px-3 py-1 text-white rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.success_color,
                                }"
                                >Success</span
                            >
                            <span
                                class="px-3 py-1 text-white rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.danger_color,
                                }"
                                >Danger</span
                            >
                            <span
                                class="px-3 py-1 text-black rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.warning_color,
                                }"
                                >Warning</span
                            >
                            <span
                                class="px-3 py-1 text-black rounded text-sm"
                                :style="{
                                    backgroundColor: colorForm.info_color,
                                }"
                                >Info</span
                            >
                        </div>
                    </div>

                    <div
                        class="flex justify-end pt-4 border-t border-secondary-200 dark:border-secondary-700"
                    >
                        <Button
                            type="submit"
                            variant="primary"
                            :disabled="colorForm.processing"
                        >
                            <span v-if="colorForm.processing">Saving...</span>
                            <span v-else>Save Colors</span>
                        </Button>
                    </div>
                </form>
            </Card>

            <!-- Logo & Favicon Settings -->
            <Card>
                <template #header>
                    <div class="flex items-center gap-2">
                        <PhotoIcon class="w-5 h-5 text-primary" />
                        <span class="font-semibold">Logo & Favicon</span>
                    </div>
                </template>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- App Logo -->
                    <div class="space-y-4">
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300"
                        >
                            Application Logo
                        </h3>
                        <div
                            class="border-2 border-dashed border-secondary-300 dark:border-secondary-600 rounded-lg p-4"
                        >
                            <div v-if="logoPreview || currentLogo" class="mb-4">
                                <img
                                    :src="
                                        logoPreview || getImageUrl(currentLogo)
                                    "
                                    alt="Logo preview"
                                    class="max-h-20 mx-auto"
                                />
                            </div>
                            <div
                                v-else
                                class="text-center py-4 text-secondary-400"
                            >
                                <PhotoIcon class="w-12 h-12 mx-auto mb-2" />
                                <p class="text-sm">No logo uploaded</p>
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                @change="handleLogoChange($event, 'app_logo')"
                                class="hidden"
                                id="logo-input"
                            />
                            <div class="flex gap-2 justify-center">
                                <label
                                    for="logo-input"
                                    class="px-3 py-1.5 text-sm bg-primary text-white rounded cursor-pointer hover:bg-primary-600"
                                >
                                    Choose File
                                </label>
                                <Button
                                    v-if="logoPreview"
                                    type="button"
                                    variant="primary"
                                    size="sm"
                                    @click="uploadLogo('app_logo')"
                                    :disabled="logoForm.processing"
                                >
                                    Upload
                                </Button>
                                <Button
                                    v-if="currentLogo && !logoPreview"
                                    type="button"
                                    variant="danger"
                                    size="sm"
                                    @click="removeLogo('app_logo')"
                                >
                                    Remove
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- App Logo Dark -->
                    <div class="space-y-4">
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300"
                        >
                            Logo (Dark Mode)
                        </h3>
                        <div
                            class="border-2 border-dashed border-secondary-300 dark:border-secondary-600 rounded-lg p-4 bg-secondary-800"
                        >
                            <div
                                v-if="logoDarkPreview || currentLogoDark"
                                class="mb-4"
                            >
                                <img
                                    :src="
                                        logoDarkPreview ||
                                        getImageUrl(currentLogoDark)
                                    "
                                    alt="Logo dark preview"
                                    class="max-h-20 mx-auto"
                                />
                            </div>
                            <div
                                v-else
                                class="text-center py-4 text-secondary-400"
                            >
                                <PhotoIcon class="w-12 h-12 mx-auto mb-2" />
                                <p class="text-sm text-secondary-400">
                                    No logo uploaded
                                </p>
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                @change="
                                    handleLogoChange($event, 'app_logo_dark')
                                "
                                class="hidden"
                                id="logo-dark-input"
                            />
                            <div class="flex gap-2 justify-center">
                                <label
                                    for="logo-dark-input"
                                    class="px-3 py-1.5 text-sm bg-primary text-white rounded cursor-pointer hover:bg-primary-600"
                                >
                                    Choose File
                                </label>
                                <Button
                                    v-if="logoDarkPreview"
                                    type="button"
                                    variant="primary"
                                    size="sm"
                                    @click="uploadLogo('app_logo_dark')"
                                    :disabled="logoDarkForm.processing"
                                >
                                    Upload
                                </Button>
                                <Button
                                    v-if="currentLogoDark && !logoDarkPreview"
                                    type="button"
                                    variant="danger"
                                    size="sm"
                                    @click="removeLogo('app_logo_dark')"
                                >
                                    Remove
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="space-y-4">
                        <h3
                            class="text-sm font-medium text-secondary-700 dark:text-secondary-300"
                        >
                            Favicon
                        </h3>
                        <div
                            class="border-2 border-dashed border-secondary-300 dark:border-secondary-600 rounded-lg p-4"
                        >
                            <div
                                v-if="faviconPreview || currentFavicon"
                                class="mb-4"
                            >
                                <img
                                    :src="
                                        faviconPreview ||
                                        getImageUrl(currentFavicon)
                                    "
                                    alt="Favicon preview"
                                    class="w-16 h-16 mx-auto"
                                />
                            </div>
                            <div
                                v-else
                                class="text-center py-4 text-secondary-400"
                            >
                                <ComputerDesktopIcon
                                    class="w-12 h-12 mx-auto mb-2"
                                />
                                <p class="text-sm">No favicon uploaded</p>
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                @change="handleLogoChange($event, 'favicon')"
                                class="hidden"
                                id="favicon-input"
                            />
                            <div class="flex gap-2 justify-center">
                                <label
                                    for="favicon-input"
                                    class="px-3 py-1.5 text-sm bg-primary text-white rounded cursor-pointer hover:bg-primary-600"
                                >
                                    Choose File
                                </label>
                                <Button
                                    v-if="faviconPreview"
                                    type="button"
                                    variant="primary"
                                    size="sm"
                                    @click="uploadLogo('favicon')"
                                    :disabled="faviconForm.processing"
                                >
                                    Upload
                                </Button>
                                <Button
                                    v-if="currentFavicon && !faviconPreview"
                                    type="button"
                                    variant="danger"
                                    size="sm"
                                    @click="removeLogo('favicon')"
                                >
                                    Remove
                                </Button>
                            </div>
                        </div>
                        <p class="text-xs text-secondary-500">
                            Recommended: 32x32 or 64x64 pixels
                        </p>
                    </div>
                </div>
            </Card>
        </div>

        <!-- Reset Confirmation Modal -->
        <Modal :show="showResetModal" @close="showResetModal = false">
            <div class="p-6">
                <h3
                    class="text-lg font-semibold text-secondary-900 dark:text-white mb-4"
                >
                    Reset Theme Settings
                </h3>
                <p class="text-secondary-600 dark:text-secondary-400 mb-6">
                    Are you sure you want to reset all color settings to their
                    default values? This action cannot be undone.
                </p>
                <div class="flex justify-end gap-3">
                    <Button variant="secondary" @click="showResetModal = false">
                        Cancel
                    </Button>
                    <Button variant="danger" @click="resetToDefaults">
                        Reset to Defaults
                    </Button>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
