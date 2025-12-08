<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
});

const { users, roles } = toRefs(props);

const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedUser = ref(null);
const isSubmitting = ref(false);

const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const addForm = ref({
    name: '',
    email: '',
    password: '',
    role: 'admin',
});

const editForm = ref({
    name: '',
    email: '',
    role: 'admin',
});

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const openAddModal = () => {
    addForm.value = {
        name: '',
        email: '',
        password: '',
        role: 'admin',
    };
    showAddModal.value = true;
};

const openEditModal = (user) => {
    selectedUser.value = user;
    editForm.value = {
        name: user.name,
        email: user.email,
        role: user.role || 'admin',
    };
    showEditModal.value = true;
};

const openDeleteModal = (user) => {
    selectedUser.value = user;
    showDeleteModal.value = true;
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    showDeleteModal.value = false;
    selectedUser.value = null;
};

const submitAddUser = () => {
    if (!addForm.value.name || !addForm.value.email || !addForm.value.password) {
        showToastMessage('Please fill in name, email and password.', 'warning');
        return;
    }

    isSubmitting.value = true;

    router.post(route('admin.users.store'), addForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('User created successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to create user. Please check the details.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const submitEditUser = () => {
    if (!selectedUser.value) return;

    if (!editForm.value.name || !editForm.value.email) {
        showToastMessage('Please fill in name and email.', 'warning');
        return;
    }

    isSubmitting.value = true;

    router.patch(route('admin.users.update', selectedUser.value.id), editForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('User updated successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to update user. Please check the details.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const confirmDeleteUser = () => {
    if (!selectedUser.value) return;

    isSubmitting.value = true;

    router.delete(route('admin.users.destroy', selectedUser.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('User deleted successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to delete user.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="User Management" />

    <DashboardLayout>
        <Toast
            v-if="showToast"
            :message="toastMessage"
            :type="toastType"
            :duration="4000"
            @close="showToast = false"
        />

        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="text-gray-600 mt-2 text-sm">Manage system users and their roles.</p>
            </div>
            <button
                @click="openAddModal"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all"
            >
                <span class="material-icons text-base">person_add</span>
                <span>Add User</span>
            </button>
        </div>

        <!-- Users Table -->
        <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ user.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ user.email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="{
                                        'bg-emerald-100 text-emerald-800': user.role === 'admin',
                                        'bg-blue-100 text-blue-800': user.role === 'afisaelimu',
                                        'bg-purple-100 text-purple-800': user.role === 'mkuuwashule',
                                        'bg-amber-100 text-amber-800': user.role === 'enterer',
                                        'bg-pink-100 text-pink-800': user.role === 'msimamiziwakituo',
                                    }"
                                >
                                    {{ user.role || 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ new Date(user.created_at).toLocaleDateString() }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <button
                                        @click="openEditModal(user)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50/60 hover:bg-blue-100 rounded-full transition-colors"
                                    >
                                        <span class="material-icons text-sm">edit_note</span>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        @click="openDeleteModal(user)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50/60 hover:bg-red-100 rounded-full transition-colors"
                                    >
                                        <span class="material-icons text-sm">delete_outline</span>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add User Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <form @submit.prevent="submitAddUser">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Add New User</h3>
                                <p class="text-xs text-gray-500 mt-1">Create a new user and assign a role.</p>
                            </div>
                            <button type="button" @click="closeModals" class="text-gray-500 hover:text-gray-700">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input
                                    v-model="addForm.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="e.g., John Doe"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input
                                    v-model="addForm.email"
                                    type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="e.g., john@example.com"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input
                                    v-model="addForm.password"
                                    type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="Min 8 characters"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select
                                    v-model="addForm.role"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                >
                                    <option v-for="role in roles" :key="role" :value="role">
                                        {{ role }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                            <button type="button" @click="closeModals" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                <svg
                                    v-if="isSubmitting"
                                    class="animate-spin h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span>Add User</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Edit User Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <form @submit.prevent="submitEditUser">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Edit User</h3>
                                <p class="text-xs text-gray-500 mt-1">Update basic details and role.</p>
                            </div>
                            <button type="button" @click="closeModals" class="text-gray-500 hover:text-gray-700">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input
                                    v-model="editForm.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input
                                    v-model="editForm.email"
                                    type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select
                                    v-model="editForm.role"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                >
                                    <option v-for="role in roles" :key="role" :value="role">
                                        {{ role }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                            <button type="button" @click="closeModals" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                <svg
                                    v-if="isSubmitting"
                                    class="animate-spin h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Delete User Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                            <span class="material-icons text-red-600">warning</span>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Delete User</h3>
                            <p class="mt-1 text-sm text-gray-600">Are you sure you want to delete this user? This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 text-sm text-gray-700" v-if="selectedUser">
                        <p>
                            User:
                            <span class="font-semibold">{{ selectedUser.name }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ selectedUser.email }})</span>
                        </p>
                    </div>
                    <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                        <button
                            type="button"
                            @click="closeModals"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            @click="confirmDeleteUser"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </DashboardLayout>
</template>
