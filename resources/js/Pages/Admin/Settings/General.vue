<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';

const props = defineProps({
    settings: {
        type: Object,
        required: true,
    },
});

const { settings } = toRefs(props);

const form = ref({
    site_name: settings.value.site_name || 'Emas | Electronic Marking System',
    maintenance_mode: !!settings.value.maintenance_mode,
    meta_title: settings.value.meta_title || '',
    meta_description: settings.value.meta_description || '',
    meta_keywords: settings.value.meta_keywords || '',
    notify_email_enabled: settings.value.notify_email_enabled ?? true,
    notify_inapp_enabled: settings.value.notify_inapp_enabled ?? true,
});

const isSubmitting = ref(false);
const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const submitSettings = () => {
    isSubmitting.value = true;

    router.patch(route('admin.settings.general.update'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('Settings updated successfully.', 'success');
        },
        onError: () => {
            showToastMessage('Failed to update settings. Please check the inputs.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="General Settings" />

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
                <h1 class="text-3xl font-bold text-gray-900">General Settings</h1>
                <p class="text-gray-600 mt-2 text-sm">Configure global site options, maintenance mode, SEO and notifications.</p>
            </div>
        </div>

        <form @submit.prevent="submitSettings" class="space-y-6">
            <!-- Site Info -->
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-emerald-500 text-base">settings</span>
                    Site Information
                </h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input
                            v-model="form.site_name"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., Emas | Electronic Marking System"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title (SEO)</label>
                        <input
                            v-model="form.meta_title"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., Best School Exam Management System"
                        >
                    </div>
                </div>
            </section>

            <!-- Maintenance Mode -->
            <section class="rounded-lg border border-amber-200 bg-amber-50 p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-amber-500 text-base">build</span>
                    Maintenance Mode
                </h2>
                <div class="flex items-start gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <span class="relative">
                            <input
                                v-model="form.maintenance_mode"
                                type="checkbox"
                                class="sr-only peer"
                            >
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-amber-500 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-5 transition-transform"></div>
                        </span>
                        <span class="ml-3 text-sm font-medium text-gray-900">Enable maintenance mode</span>
                    </label>
                    <p class="text-xs text-gray-600 max-w-md">
                        When enabled, normal users will see a maintenance page. Admins will still be able to access the system.
                    </p>
                </div>
            </section>

            <!-- SEO Settings -->
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-blue-500 text-base">search</span>
                    SEO Settings
                </h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea
                            v-model="form.meta_description"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            rows="3"
                            placeholder="Short description for search engines..."
                        ></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input
                            v-model="form.meta_keywords"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus-border-transparent"
                            placeholder="e.g., exams, schools, results, Tanzania"
                        >
                        <p class="mt-1 text-xs text-gray-500">Comma-separated keywords (optional).</p>
                    </div>
                </div>
            </section>

            <!-- Notifications -->
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-purple-500 text-base">notifications</span>
                    Notifications
                </h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            v-model="form.notify_email_enabled"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        <span class="text-sm text-gray-800">Enable email notifications (system alerts, important updates)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            v-model="form.notify_inapp_enabled"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        <span class="text-sm text-gray-800">Enable in-app notifications (bell icon in header)</span>
                    </label>
                </div>
            </section>

            <!-- Submit -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
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
                    <span>Save Settings</span>
                </button>
            </div>
        </form>
    </DashboardLayout>
</template>
