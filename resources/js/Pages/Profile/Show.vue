<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const showPasswordModal = ref(false);
const showEditModal = ref(false);

const editForm = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    phone: props.user.phone || '',
    date_of_birth: props.user.date_of_birth || '',
    address: props.user.address || '',
});

const passwordForm = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const deleteForm = ref({
    password: '',
});

const submitEditForm = () => {
    editForm.patch(route('profile.update'), {
        onSuccess: () => {
            showEditModal.value = false;
        },
    });
};
</script>

<template>
    <Head title="My Profile" />

    <DashboardLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-600 mt-2">Manage your account settings and preferences</p>
        </div>

        <!-- Profile Overview Card -->
        <div class="grid gap-6 lg:grid-cols-3 mb-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1 rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="text-center">
                    <img
                        :src="`https://ui-avatars.com/api/?name=${user.name}&background=10b981&color=fff&size=128`"
                        :alt="user.name"
                        class="h-24 w-24 rounded-full mx-auto mb-4"
                    />
                    <h2 class="text-2xl font-bold text-gray-900">{{ user.name }}</h2>
                    <p class="text-gray-600 text-sm mt-1">{{ user.email }}</p>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider">Full Name</label>
                            <p class="text-gray-900 font-medium mt-1">{{ user.name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider">Email Address</label>
                            <p class="text-gray-900 font-medium mt-1">{{ user.email }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider">Phone Number</label>
                            <p class="text-gray-900 font-medium mt-1">{{ user.phone || 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider">Date of Birth</label>
                            <p class="text-gray-900 font-medium mt-1">{{ user.date_of_birth ? new Date(user.date_of_birth).toLocaleDateString() : 'Not provided' }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider">Address</label>
                        <p class="text-gray-900 font-medium mt-1">{{ user.address || 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- School Information -->
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">School Information</h3>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-4 rounded-lg bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200">
                    <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider">School Name</p>
                    <p class="text-lg font-bold text-emerald-900 mt-2">{{ user.school_name || 'Not assigned' }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">School ID</p>
                    <p class="text-lg font-bold text-blue-900 mt-2">{{ user.school_id || 'Not assigned' }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200">
                    <p class="text-xs font-medium text-purple-600 uppercase tracking-wider">Role</p>
                    <p class="text-lg font-bold text-purple-900 mt-2 capitalize">{{ user.role || 'User' }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200">
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wider">Member Since</p>
                    <p class="text-lg font-bold text-amber-900 mt-2">{{ new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short' }) }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <!-- Edit Profile -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Edit Profile</h3>
                        <p class="text-sm text-gray-600 mt-1">Update your personal information</p>
                    </div>
                    <span class="material-icons text-emerald-600 text-2xl">edit</span>
                </div>
                <button
                    @click="showEditModal = true"
                    class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors"
                >
                    <span class="material-icons text-lg">edit_note</span>
                    Edit Information
                </button>
            </div>

            <!-- Change Password -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                        <p class="text-sm text-gray-600 mt-1">Update your password to keep your account secure</p>
                    </div>
                    <span class="material-icons text-blue-600 text-2xl">lock</span>
                </div>
                <button
                    @click="showPasswordModal = true"
                    class="w-full flex items-center justify-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2.5 px-4 rounded-lg transition-colors"
                >
                    <span class="material-icons text-lg">vpn_key</span>
                    Change Password
                </button>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-lg bg-red-50 border border-red-200 p-6 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-red-900">Danger Zone</h3>
                    <p class="text-sm text-red-700 mt-1">Irreversible and destructive actions</p>
                </div>
                <span class="material-icons text-red-600 text-2xl">warning</span>
            </div>
            <div class="space-y-3">
                <button
                    @click="showDeleteModal = true"
                    class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors"
                >
                    <span class="material-icons text-lg">delete_forever</span>
                    Delete Account
                </button>
                <p class="text-xs text-red-700">
                    Once you delete your account, there is no going back. Please be certain.
                </p>
            </div>
        </div>

        <!-- Change Password Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-if="showPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                        <button
                            @click="showPasswordModal = false"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                    <form @submit.prevent="() => {}" class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input
                                v-model="passwordForm.current_password"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                placeholder="Enter current password"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input
                                v-model="passwordForm.password"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                placeholder="Enter new password"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                placeholder="Confirm new password"
                            />
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button
                                type="button"
                                @click="showPasswordModal = false"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors"
                            >
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Delete Account Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-red-900">Delete Account</h3>
                        <button
                            @click="showDeleteModal = false"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3 p-4 bg-red-50 rounded-lg border border-red-200">
                            <span class="material-icons text-red-600 text-2xl">warning</span>
                            <div>
                                <p class="text-sm font-medium text-red-900">This action cannot be undone</p>
                                <p class="text-xs text-red-700 mt-1">All your data will be permanently deleted</p>
                            </div>
                        </div>
                        <form @submit.prevent="() => {}" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input
                                    v-model="deleteForm.password"
                                    type="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Enter your password to confirm"
                                />
                            </div>
                            <div class="flex gap-3 pt-4">
                                <button
                                    type="button"
                                    @click="showDeleteModal = false"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                                >
                                    Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Edit Profile Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Edit Profile Information</h3>
                            <p class="text-xs text-gray-600 mt-1">Update your personal details</p>
                        </div>
                        <button
                            @click="showEditModal = false"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form @submit.prevent="submitEditForm" class="p-6 space-y-4">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-lg text-emerald-600">person</span>
                                    Full Name
                                </span>
                            </label>
                            <input
                                v-model="editForm.name"
                                type="text"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                placeholder="Enter your full name"
                            />
                            <p v-if="editForm.errors.name" class="text-red-600 text-xs mt-1">{{ editForm.errors.name }}</p>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-lg text-emerald-600">email</span>
                                    Email Address
                                </span>
                            </label>
                            <input
                                v-model="editForm.email"
                                type="email"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                placeholder="Enter your email address"
                            />
                            <p v-if="editForm.errors.email" class="text-red-600 text-xs mt-1">{{ editForm.errors.email }}</p>
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-lg text-emerald-600">phone</span>
                                    Phone Number
                                </span>
                            </label>
                            <input
                                v-model="editForm.phone"
                                type="tel"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                placeholder="Enter your phone number"
                            />
                            <p v-if="editForm.errors.phone" class="text-red-600 text-xs mt-1">{{ editForm.errors.phone }}</p>
                        </div>

                        <!-- Date of Birth Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-lg text-emerald-600">cake</span>
                                    Date of Birth
                                </span>
                            </label>
                            <input
                                v-model="editForm.date_of_birth"
                                type="date"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                            />
                            <p v-if="editForm.errors.date_of_birth" class="text-red-600 text-xs mt-1">{{ editForm.errors.date_of_birth }}</p>
                        </div>

                        <!-- Address Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-lg text-emerald-600">location_on</span>
                                    Address
                                </span>
                            </label>
                            <textarea
                                v-model="editForm.address"
                                rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                                placeholder="Enter your address"
                            ></textarea>
                            <p v-if="editForm.errors.address" class="text-red-600 text-xs mt-1">{{ editForm.errors.address }}</p>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button
                                type="button"
                                @click="showEditModal = false"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                            >
                                <span class="material-icons text-lg">close</span>
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="editForm.processing"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                <span v-if="!editForm.processing" class="material-icons text-lg">save</span>
                                <span v-else class="material-icons text-lg animate-spin">sync</span>
                                {{ editForm.processing ? 'Saving...' : 'Save Changes' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </DashboardLayout>
</template>
