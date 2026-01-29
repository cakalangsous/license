<script setup>
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import Modal from "@/Components/UI/Modal.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import { useToast } from "vue-toastification";
import {
    Cog6ToothIcon,
    SwatchIcon,
    EnvelopeIcon,
    PhotoIcon,
    ArrowPathIcon,
    ComputerDesktopIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: {
        type: String,
        default: "Settings",
    },
    applicationSettings: {
        type: Object,
        default: () => ({}),
    },
    themeSettings: {
        type: Object,
        default: () => ({}),
    },
    emailSettings: {
        type: Object,
        default: () => ({}),
    },
    activeTab: {
        type: String,
        default: "application",
    },
});

const toast = useToast();
const currentTab = ref(props.activeTab);

// Tab configuration
const tabs = [
    { id: "application", label: "Application", icon: "cog" },
    { id: "email", label: "Email", icon: "envelope" },
    { id: "theme", label: "Theme Colors", icon: "palette" },
    { id: "branding", label: "Branding", icon: "image" },
];

// Application form
const appForm = useForm({
    app_name: props.applicationSettings.app_name?.value || "",
    meta_description: props.applicationSettings.meta_description?.value || "",
    meta_keywords: props.applicationSettings.meta_keywords?.value || "",
    site_api_docs_public:
        props.applicationSettings.site_api_docs_public?.value === "1",
});

// Email settings form
const emailForm = useForm({
    mail_mailer: props.emailSettings.mail_mailer || "log",
    mail_host: props.emailSettings.mail_host || "127.0.0.1",
    mail_port: props.emailSettings.mail_port || 2525,
    mail_username: props.emailSettings.mail_username || "",
    mail_password: props.emailSettings.mail_password || "",
    mail_encryption: props.emailSettings.mail_encryption || "",
    mail_from_address:
        props.emailSettings.mail_from_address || "hello@example.com",
    mail_from_name: props.emailSettings.mail_from_name || "",
});

// Color settings form
const colorForm = useForm({
    primary_color: props.themeSettings.primary_color?.value || "#6771cf",
    secondary_color: props.themeSettings.secondary_color?.value || "#6c757d",
    success_color: props.themeSettings.success_color?.value || "#198754",
    danger_color: props.themeSettings.danger_color?.value || "#dc3545",
    warning_color: props.themeSettings.warning_color?.value || "#ffc107",
    info_color: props.themeSettings.info_color?.value || "#0dcaf0",
    light_bg_color: props.themeSettings.light_bg_color?.value || "#f2f7ff",
    dark_bg_color: props.themeSettings.dark_bg_color?.value || "#1a1d21",
    sidebar_bg_light: props.themeSettings.sidebar_bg_light?.value || "#ffffff",
    sidebar_bg_dark: props.themeSettings.sidebar_bg_dark?.value || "#212529",
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
const currentLogo = computed(() => props.themeSettings.app_logo?.value);
const currentLogoDark = computed(
    () => props.themeSettings.app_logo_dark?.value,
);
const currentFavicon = computed(() => props.themeSettings.favicon?.value);

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

// Submit handlers
const submitApplication = () => {
    appForm.put("/admin/settings/application", {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Application settings updated successfully");
        },
        onError: () => {
            toast.error("Failed to update settings");
        },
    });
};

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

const submitEmail = () => {
    emailForm.put("/admin/settings/email", {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Email settings updated successfully");
        },
        onError: () => {
            toast.error("Failed to update email settings");
        },
    });
};

// Test email functionality
const testEmailAddress = ref("");
const testEmailLoading = ref(false);

const sendTestEmail = async () => {
    if (!testEmailAddress.value) {
        toast.error("Please enter an email address");
        return;
    }

    testEmailLoading.value = true;
    try {
        const response = await fetch("/admin/settings/email/test", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            body: JSON.stringify({ email: testEmailAddress.value }),
        });

        const data = await response.json();

        if (data.success) {
            toast.success(data.message);
        } else {
            toast.error(data.message);
        }
    } catch (error) {
        toast.error("Failed to send test email");
    } finally {
        testEmailLoading.value = false;
    }
};

const handleLogoChange = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

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

        <div class="max-w-5xl">
            <!-- Tabs Navigation -->
            <div
                class="mb-6 border-b border-secondary-200 dark:border-secondary-700"
            >
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="currentTab = tab.id"
                        :class="[
                            currentTab === tab.id
                                ? 'border-primary text-primary'
                                : 'border-transparent text-secondary-500 hover:text-secondary-700 hover:border-secondary-300 dark:hover:text-secondary-300',
                            'group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition-colors',
                        ]"
                    >
                        <!-- Cog Icon -->
                        <Cog6ToothIcon
                            v-if="tab.icon === 'cog'"
                            :class="[
                                currentTab === tab.id
                                    ? 'text-primary'
                                    : 'text-secondary-400 group-hover:text-secondary-500',
                                '-ml-0.5 mr-2 h-5 w-5',
                            ]"
                        />
                        <!-- Palette Icon -->
                        <SwatchIcon
                            v-if="tab.icon === 'palette'"
                            :class="[
                                currentTab === tab.id
                                    ? 'text-primary'
                                    : 'text-secondary-400 group-hover:text-secondary-500',
                                '-ml-0.5 mr-2 h-5 w-5',
                            ]"
                        />
                        <!-- Envelope Icon -->
                        <EnvelopeIcon
                            v-if="tab.icon === 'envelope'"
                            :class="[
                                currentTab === tab.id
                                    ? 'text-primary'
                                    : 'text-secondary-400 group-hover:text-secondary-500',
                                '-ml-0.5 mr-2 h-5 w-5',
                            ]"
                        />
                        <!-- Image Icon -->
                        <PhotoIcon
                            v-if="tab.icon === 'image'"
                            :class="[
                                currentTab === tab.id
                                    ? 'text-primary'
                                    : 'text-secondary-400 group-hover:text-secondary-500',
                                '-ml-0.5 mr-2 h-5 w-5',
                            ]"
                        />
                        {{ tab.label }}
                    </button>
                </nav>
            </div>

            <!-- Application Settings Tab -->
            <div v-show="currentTab === 'application'">
                <Card>
                    <template #header>
                        <div class="flex items-center gap-2">
                            <Cog6ToothIcon class="w-5 h-5 text-primary" />
                            <span class="font-semibold"
                                >Application Settings</span
                            >
                        </div>
                    </template>

                    <form @submit.prevent="submitApplication" class="space-y-6">
                        <FormInput
                            v-model="appForm.app_name"
                            label="Application Name"
                            placeholder="Enter application name"
                            :error="appForm.errors.app_name"
                            required
                        />

                        <FormTextarea
                            v-model="appForm.meta_description"
                            label="Meta Description"
                            placeholder="Enter meta description for SEO"
                            :error="appForm.errors.meta_description"
                            :rows="3"
                            help="This description appears in search engine results."
                        />

                        <FormInput
                            v-model="appForm.meta_keywords"
                            label="Meta Keywords"
                            placeholder="keyword1, keyword2, keyword3"
                            :error="appForm.errors.meta_keywords"
                            help="Comma-separated keywords for SEO."
                        />

                        <div class="flex items-center justify-between py-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-secondary-700 dark:text-secondary-300"
                                >
                                    Public API Documentation:
                                    <a
                                        :href="$page.props.domain + '/docs/api'"
                                        target="_blank"
                                        class="underline text-primary"
                                    >
                                        {{ $page.props.domain }}/docs/api
                                    </a>
                                </label>
                                <p class="text-sm text-secondary-500">
                                    If enabled, API documentation will be
                                    accessible to public guests.
                                </p>
                            </div>
                            <div class="flex items-center">
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="appForm.site_api_docs_public"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-11 h-6 bg-secondary-200 dark:bg-secondary-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-secondary-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-secondary-600 peer-checked:bg-primary-600"
                                    ></div>
                                </label>
                            </div>
                        </div>

                        <div
                            class="flex justify-end pt-4 border-t border-secondary-200 dark:border-secondary-700"
                        >
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="appForm.processing"
                            >
                                <span v-if="appForm.processing">Saving...</span>
                                <span v-else>Save Settings</span>
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>

            <!-- Email Settings Tab -->
            <div v-show="currentTab === 'email'">
                <Card>
                    <template #header>
                        <div class="flex items-center gap-2">
                            <EnvelopeIcon class="w-5 h-5 text-primary" />
                            <span class="font-semibold">Email Settings</span>
                        </div>
                    </template>

                    <form @submit.prevent="submitEmail" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Mail Driver -->
                            <div class="space-y-2">
                                <label
                                    class="block text-sm font-medium text-secondary-700 dark:text-secondary-300"
                                >
                                    Mail Driver
                                </label>
                                <select
                                    v-model="emailForm.mail_mailer"
                                    class="w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-800 text-secondary-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                >
                                    <option value="log">
                                        Log (Development)
                                    </option>
                                    <option value="smtp">SMTP</option>
                                    <option value="sendmail">Sendmail</option>
                                    <option value="mailgun">Mailgun</option>
                                    <option value="ses">Amazon SES</option>
                                    <option value="postmark">Postmark</option>
                                </select>
                            </div>

                            <!-- Encryption -->
                            <div class="space-y-2">
                                <label
                                    class="block text-sm font-medium text-secondary-700 dark:text-secondary-300"
                                >
                                    Encryption
                                </label>
                                <select
                                    v-model="emailForm.mail_encryption"
                                    class="w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-800 text-secondary-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                >
                                    <option value="">None</option>
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <FormInput
                                v-model="emailForm.mail_host"
                                label="SMTP Host"
                                placeholder="smtp.example.com"
                                :error="emailForm.errors.mail_host"
                            />

                            <FormInput
                                v-model="emailForm.mail_port"
                                type="number"
                                label="SMTP Port"
                                placeholder="587"
                                :error="emailForm.errors.mail_port"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <FormInput
                                v-model="emailForm.mail_username"
                                label="SMTP Username"
                                placeholder="username@example.com"
                                :error="emailForm.errors.mail_username"
                            />

                            <FormInput
                                v-model="emailForm.mail_password"
                                type="password"
                                label="SMTP Password"
                                placeholder="••••••••"
                                :error="emailForm.errors.mail_password"
                            />
                        </div>

                        <div
                            class="border-t border-secondary-200 dark:border-secondary-700 pt-6"
                        >
                            <h3
                                class="text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-4"
                            >
                                Sender Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <FormInput
                                    v-model="emailForm.mail_from_address"
                                    label="From Address"
                                    placeholder="noreply@example.com"
                                    :error="emailForm.errors.mail_from_address"
                                    required
                                />

                                <FormInput
                                    v-model="emailForm.mail_from_name"
                                    label="From Name"
                                    placeholder="My Application"
                                    :error="emailForm.errors.mail_from_name"
                                    required
                                />
                            </div>
                        </div>

                        <!-- Test Email Section -->
                        <div
                            class="border-t border-secondary-200 dark:border-secondary-700 pt-6"
                        >
                            <h3
                                class="text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-4"
                            >
                                Test Email Configuration
                            </h3>
                            <div class="flex gap-4">
                                <FormInput
                                    v-model="testEmailAddress"
                                    label="Test Email Address"
                                    placeholder="test@example.com"
                                    class="flex-1"
                                />
                                <div class="flex items-end">
                                    <Button
                                        type="button"
                                        variant="outline-primary"
                                        @click="sendTestEmail"
                                        :disabled="testEmailLoading"
                                    >
                                        <ArrowPathIcon
                                            v-if="testEmailLoading"
                                            class="animate-spin -ml-1 mr-2 h-4 w-4"
                                        />
                                        <span v-if="testEmailLoading"
                                            >Sending...</span
                                        >
                                        <span v-else>Send Test Email</span>
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex justify-end pt-4 border-t border-secondary-200 dark:border-secondary-700"
                        >
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="emailForm.processing"
                            >
                                <span v-if="emailForm.processing"
                                    >Saving...</span
                                >
                                <span v-else>Save Email Settings</span>
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>

            <!-- Theme Colors Tab -->
            <div v-show="currentTab === 'theme'">
                <Card>
                    <template #header>
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <SwatchIcon class="w-5 h-5 text-primary" />
                                <span class="font-semibold"
                                    >Color Settings</span
                                >
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
                                        backgroundColor:
                                            colorForm.primary_color,
                                    }"
                                    >Primary</span
                                >
                                <span
                                    class="px-3 py-1 text-white rounded text-sm"
                                    :style="{
                                        backgroundColor:
                                            colorForm.secondary_color,
                                    }"
                                    >Secondary</span
                                >
                                <span
                                    class="px-3 py-1 text-white rounded text-sm"
                                    :style="{
                                        backgroundColor:
                                            colorForm.success_color,
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
                                        backgroundColor:
                                            colorForm.warning_color,
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
                                <span v-if="colorForm.processing"
                                    >Saving...</span
                                >
                                <span v-else>Save Colors</span>
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>

            <!-- Branding Tab -->
            <div v-show="currentTab === 'branding'">
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
                                <div
                                    v-if="logoPreview || currentLogo"
                                    class="mb-4"
                                >
                                    <img
                                        :src="
                                            logoPreview ||
                                            getImageUrl(currentLogo)
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
                                    @change="
                                        handleLogoChange($event, 'app_logo')
                                    "
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
                                        handleLogoChange(
                                            $event,
                                            'app_logo_dark',
                                        )
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
                                        v-if="
                                            currentLogoDark && !logoDarkPreview
                                        "
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
                                    @change="
                                        handleLogoChange($event, 'favicon')
                                    "
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
