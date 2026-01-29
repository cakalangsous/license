<script setup>
import { ref, watch, computed } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import { useToast } from "vue-toastification";
import access from "@/routes/admin/access";

const props = defineProps({
    title: {
        type: String,
        default: "Access",
    },
    roles: Array,
    active_role: Object,
    permissions: Object, // Grouped permissions: { groupName: [perm1, perm2] }
});

const toast = useToast();
const processing = ref(false);

const activeRole = computed(() => props.active_role);

// Form for submitting permissions
// We just submit an array of permission names or IDs.
// Controller expects 'perms' array.
const form = useForm({
    perms: [],
});

// Initialize form perms based on active role
const initPerms = () => {
    if (activeRole.value && activeRole.value.permissions) {
        form.perms = activeRole.value.permissions.map((p) => p.name);
    } else {
        form.perms = [];
    }
};

watch(
    () => props.active_role,
    () => {
        initPerms();
    },
    { immediate: true }
);

const selectRole = (roleId) => {
    router.get(
        access.index.url(),
        { role_id: roleId },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["active_role"],
        }
    );
};

const submit = () => {
    if (!activeRole.value) return;

    form.put(access.update.url({ role: activeRole.value.id }), {
        onSuccess: () => {
            toast.success(`Permissions for ${activeRole.value.name} updated!`);
        },
    });
};

// Checkbox logic
const isPermChecked = (permName) => {
    return form.perms.includes(permName);
};

const togglePerm = (permName) => {
    if (isPermChecked(permName)) {
        form.perms = form.perms.filter((p) => p !== permName);
    } else {
        form.perms.push(permName);
    }
};

const isGroupChecked = (groupName) => {
    const groupPerms = props.permissions[groupName];
    if (!groupPerms) return false;
    return groupPerms.every((p) => isPermChecked(p.name));
};

const isGroupIndeterminate = (groupName) => {
    const groupPerms = props.permissions[groupName];
    if (!groupPerms) return false;
    const checkedCount = groupPerms.filter((p) => isPermChecked(p.name)).length;
    return checkedCount > 0 && checkedCount < groupPerms.length;
};

const toggleGroup = (groupName) => {
    const groupPerms = props.permissions[groupName];
    if (isGroupChecked(groupName)) {
        // Uncheck all
        const groupPermNames = groupPerms.map((p) => p.name);
        form.perms = form.perms.filter((p) => !groupPermNames.includes(p));
    } else {
        // Check all
        const groupPermNames = groupPerms.map((p) => p.name);
        // Add ones not already present
        groupPermNames.forEach((name) => {
            if (!form.perms.includes(name)) {
                form.perms.push(name);
            }
        });
    }
};

// Capitalize helper
const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1);
</script>

<template>
    <AdminLayout :title="title">
        <Head :title="title" />

        <div class="row">
            <div class="col-12">
                <Card title="Roles and Access List">
                    <!-- Tabs -->
                    <div
                        class="border-b border-gray-200 dark:border-secondary-700 mb-6"
                    >
                        <ul
                            class="flex flex-wrap -mb-px text-sm font-medium text-center"
                        >
                            <li
                                v-for="role in roles"
                                :key="role.id"
                                class="mr-2"
                            >
                                <button
                                    @click="selectRole(role.id)"
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 transition-colors"
                                    :class="[
                                        activeRole && activeRole.id === role.id
                                            ? 'text-primary-600 border-primary-600 dark:text-primary-500 dark:border-primary-500'
                                            : 'border-transparent text-gray-500 dark:text-gray-400',
                                    ]"
                                >
                                    {{ role.name }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Permissions Matrix -->
                    <div v-if="activeRole" class="mt-4">
                        <form @submit.prevent="submit">
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                                >
                                    <tbody>
                                        <tr
                                            v-for="(
                                                groupPerms, groupName
                                            ) in permissions"
                                            :key="groupName"
                                            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-secondary-800"
                                        >
                                            <!-- Group Name / Parent Checkbox -->
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white w-1/4 align-top"
                                            >
                                                <div class="flex items-center">
                                                    <input
                                                        type="checkbox"
                                                        class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        :checked="
                                                            isGroupChecked(
                                                                groupName
                                                            )
                                                        "
                                                        :indeterminate="
                                                            isGroupIndeterminate(
                                                                groupName
                                                            )
                                                        "
                                                        @change="
                                                            toggleGroup(
                                                                groupName
                                                            )
                                                        "
                                                    />
                                                    <span
                                                        class="ml-2 font-bold capitalize"
                                                        >{{
                                                            groupName.replace(
                                                                /_/g,
                                                                " "
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                            </td>

                                            <!-- Individual Permissions -->
                                            <td class="px-6 py-4">
                                                <div
                                                    class="flex flex-wrap gap-4"
                                                >
                                                    <div
                                                        v-for="perm in groupPerms"
                                                        :key="perm.id"
                                                        class="flex items-center min-w-[200px]"
                                                    >
                                                        <input
                                                            type="checkbox"
                                                            :value="perm.name"
                                                            class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            :checked="
                                                                isPermChecked(
                                                                    perm.name
                                                                )
                                                            "
                                                            @change="
                                                                togglePerm(
                                                                    perm.name
                                                                )
                                                            "
                                                        />
                                                        <label
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
                                                            @click="
                                                                togglePerm(
                                                                    perm.name
                                                                )
                                                            "
                                                            >{{
                                                                perm.name
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <Button
                                    type="submit"
                                    :loading="form.processing"
                                >
                                    Save Changes for {{ activeRole.name }}
                                </Button>
                            </div>
                        </form>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
