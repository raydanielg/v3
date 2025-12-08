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
    smtp_host: settings.value.smtp_host || '',
    smtp_port: settings.value.smtp_port || '',
    smtp_username: settings.value.smtp_username || '',
    smtp_password: settings.value.smtp_password || '',
    smtp_encryption: settings.value.smtp_encryption || 'tls',
    smtp_from_email: settings.value.smtp_from_email || '',
    smtp_from_name: settings.value.smtp_from_name || (settings.value.site_name || 'Emas'),
    test_email: '',
});

const isSubmitting = ref(false);
const isTesting = ref(false);
const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const submitSmtp = () => {
    isSubmitting.value = true;

    router.patch(route('admin.settings.smtp.update'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('SMTP settings updated successfully.', 'success');
        },
        onError: () => {
            showToastMessage('Failed to update SMTP settings.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const sendTestEmail = () => {
    if (!form.value.test_email) {
        showToastMessage('Please enter a test email address.', 'warning');
        return;
    }

    isTesting.value = true;

    router.post(route('admin.settings.smtp.test'), { test_email: form.value.test_email }, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('Test email sent successfully.', 'success');
        },
        onError: () => {
            showToastMessage('Failed to send test email.', 'error');
        },
        onFinish: () => {
            isTesting.value = false;
        },
    });
};
</script>

<template>
    <Head title="SMTP Settings" />

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
                <h1 class="text-3xl font-bold text-gray-900">SMTP Settings</h1>
                <p class="text-gray-600 mt-2 text-sm">Configure email server for sending system notifications and test emails.</p>
            </div>
        </div>

        <form @submit.prevent="submitSmtp" class="space-y-6">
            <!-- SMTP Server -->
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-blue-500 text-base">alternate_email</span>
                    SMTP Server
                </h2>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                        <input
                            v-model="form.smtp_host"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., smtp.gmail.com"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                        <input
                            v-model="form.smtp_port"
                            type="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., 587"
                        >
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-3 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Encryption</label>
                        <select
                            v-model="form.smtp_encryption"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                        >
                            <option value="">None</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                        <input
                            v-model="form.smtp_username"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., user@example.com"
                        >
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                    <input
                        v-model="form.smtp_password"
                        type="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                    <p class="mt-1 text-xs text-gray-500">Make sure to also configure these values in your environment (e.g., .env) for production.</p>
                </div>
            </section>

            <!-- From Address -->
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-emerald-500 text-base">mail_outline</span>
                    From Address
                </h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Email</label>
                        <input
                            v-model="form.smtp_from_email"
                            type="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., no-reply@example.com"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
                        <input
                            v-model="form.smtp_from_name"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., Emas System"
                        >
                    </div>
                </div>
            </section>

            <!-- Test Email -->
            <section class="rounded-lg border border-blue-200 bg-blue-50 p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-blue-500 text-base">send</span>
                    Send Test Email
                </h2>
                <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Test Email Address</label>
                        <input
                            v-model="form.test_email"
                            type="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="e.g., you@example.com"
                        >
                    </div>
                    <button
                        type="button"
                        @click="sendTestEmail"
                        :disabled="isTesting"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors disabled:opacity-60 disabled:cursor-not-allowed mt-2 sm:mt-6"
                    >
                        <svg
                            v-if="isTesting"
                            class="animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Send Test</span>
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">Use this to quickly verify that your SMTP configuration is working.</p>
            </section>

            <!-- Save Button -->
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
                    <span>Save SMTP Settings</span>
                </button>
            </div>
        </form>
    </DashboardLayout>
</template>
