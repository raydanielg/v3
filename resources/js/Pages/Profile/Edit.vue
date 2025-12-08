<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    date_of_birth: '',
    address: '',
});

const isSaving = ref(false);

const submitForm = () => {
    isSaving.value = true;
    form.patch(route('profile.update'), {
        onFinish: () => {
            isSaving.value = false;
        },
    });
};
</script>

<template>
    <Head title="Edit Profile" />

    <DashboardLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-2">Update your personal information</p>
        </div>

        <!-- Edit Profile Form -->
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 max-w-2xl">
            <form @submit.prevent="submitForm" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <span class="material-icons text-lg text-emerald-600">person</span>
                            Full Name
                        </span>
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                        placeholder="Enter your full name"
                    />
                    <p v-if="form.errors.name" class="text-red-600 text-xs mt-1">{{ form.errors.name }}</p>
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
                        v-model="form.email"
                        type="email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                        placeholder="Enter your email address"
                    />
                    <p v-if="form.errors.email" class="text-red-600 text-xs mt-1">{{ form.errors.email }}</p>
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
                        v-model="form.phone"
                        type="tel"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                        placeholder="Enter your phone number"
                    />
                    <p v-if="form.errors.phone" class="text-red-600 text-xs mt-1">{{ form.errors.phone }}</p>
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
                        v-model="form.date_of_birth"
                        type="date"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                    />
                    <p v-if="form.errors.date_of_birth" class="text-red-600 text-xs mt-1">{{ form.errors.date_of_birth }}</p>
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
                        v-model="form.address"
                        rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                        placeholder="Enter your address"
                    ></textarea>
                    <p v-if="form.errors.address" class="text-red-600 text-xs mt-1">{{ form.errors.address }}</p>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <button
                        type="button"
                        @click="$router.back()"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                    >
                        <span class="material-icons text-lg">close</span>
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing || isSaving"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span v-if="!form.processing" class="material-icons text-lg">save</span>
                        <span v-else class="material-icons text-lg animate-spin">sync</span>
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </div>

                <!-- Success Message -->
                <div v-if="status" class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <p class="text-sm text-emerald-800 flex items-center gap-2">
                        <span class="material-icons text-lg">check_circle</span>
                        {{ status }}
                    </p>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
