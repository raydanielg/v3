<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    settings: {
        type: Object,
        required: true,
    },
    metrics: {
        type: Object,
        required: false,
        default: () => ({ online_users: 0, active_sessions: 0, total_users: 0 }),
    },
});

const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('info');

const showToastMessage = (message, type = 'info') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};
</script>

<template>
    <Head title="Security Overview" />

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
                <h1 class="text-3xl font-bold text-gray-900">Security Overview</h1>
                <p class="text-gray-600 mt-2 text-sm">Live-style view of sessions, visitors and security events (visual, data wiring can be added later).</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                <span class="material-icons text-sm">shield</span>
                <span>Monitoring Enabled (UI Preview)</span>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Left column: Live status + visitors -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Live System Status -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-emerald-500 text-xl">wifi_tethering</span>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">Live System Status</h2>
                                <p class="text-xs text-gray-500">Online users, active sessions, and recent activity.</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800 uppercase tracking-wide">
                            Live View
                        </span>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-lg border border-emerald-100 bg-emerald-50 px-4 py-3">
                            <p class="text-xs font-medium text-emerald-700 uppercase tracking-wide">Online Users</p>
                            <p class="mt-1 text-2xl font-bold text-emerald-900">{{ metrics.online_users }}</p>
                            <p class="mt-1 text-[11px] text-emerald-700">Active in the last few minutes</p>
                        </div>
                        <div class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3">
                            <p class="text-xs font-medium text-blue-700 uppercase tracking-wide">Active Sessions</p>
                            <p class="mt-1 text-2xl font-bold text-blue-900">{{ metrics.active_sessions }}</p>
                            <p class="mt-1 text-[11px] text-blue-700">Across all devices</p>
                        </div>
                        <div class="rounded-lg border border-amber-100 bg-amber-50 px-4 py-3">
                            <p class="text-xs font-medium text-amber-700 uppercase tracking-wide">Failed Logins</p>
                            <p class="mt-1 text-2xl font-bold text-amber-900">3</p>
                            <p class="mt-1 text-[11px] text-amber-700">Last 15 minutes</p>
                        </div>
                    </div>
                </section>

                <!-- Recent Security Events -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-red-500 text-xl">security</span>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">Recent Security Events</h2>
                                <p class="text-xs text-gray-500">Login attempts, password changes and permission updates.</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm max-h-64 overflow-y-auto pr-1">
                        <div class="flex items-start justify-between rounded-lg border border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    <span class="material-icons text-emerald-500 text-base">check_circle</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Successful login</p>
                                    <p class="text-xs text-gray-500">Admin user logged in from Dar es Salaam, TZ.</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400">Just now</span>
                        </div>
                        <div class="flex items-start justify-between rounded-lg border border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    <span class="material-icons text-amber-500 text-base">warning</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Multiple failed logins</p>
                                    <p class="text-xs text-gray-500">5 failed attempts for user john@example.com.</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400">5 min ago</span>
                        </div>
                        <div class="flex items-start justify-between rounded-lg border border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    <span class="material-icons text-blue-500 text-base">manage_accounts</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Role updated</p>
                                    <p class="text-xs text-gray-500">User airezra2@gmail.com changed to role Admin.</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400">30 min ago</span>
                        </div>
                    </div>
                </section>

                <!-- Visitor Overview -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-indigo-500 text-xl">public</span>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">Visitors Overview</h2>
                                <p class="text-xs text-gray-500">High level view of visitors and devices (sample data).</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="text-xs text-gray-700">
                            <p class="font-semibold mb-1">Today</p>
                            <p class="text-2xl font-bold text-gray-900">134</p>
                            <p class="mt-1 text-[11px] text-gray-500">Unique visitors</p>
                        </div>
                        <div class="text-xs text-gray-700">
                            <p class="font-semibold mb-1">Devices</p>
                            <p class="mt-1">Desktop: 72%</p>
                            <p>Mobile: 22%</p>
                            <p>Tablet: 6%</p>
                        </div>
                        <div class="text-xs text-gray-700">
                            <p class="font-semibold mb-1">Top Regions</p>
                            <p>Dar es Salaam</p>
                            <p>Dodoma</p>
                            <p>Arusha</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right column: Security controls -->
            <div class="space-y-6">
                <!-- Security Controls -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-icons text-red-500 text-base">lock</span>
                        Security Controls (Preview)
                    </h2>
                    <div class="space-y-3 text-sm">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" checked>
                            <span>Notify admin on multiple failed logins</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span>Force strong passwords for all users</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span>Enable login alerts (email / in-app)</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span>Enable 2FA (coming soon)</span>
                        </label>
                    </div>
                </section>

                <!-- Coming soon card -->
                <section class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-emerald-900 mb-2 flex items-center gap-2">
                        <span class="material-icons text-emerald-600 text-base">auto_awesome</span>
                        Advanced Monitoring (Coming Soon)
                    </h2>
                    <p class="text-xs text-emerald-800 mb-3">
                        Future updates will add live integration with server logs, database audits, and real-time alerts based on your preferences.
                    </p>
                    <button
                        type="button"
                        @click="showToastMessage('Advanced monitoring features will be added in future updates.', 'info')"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium shadow-sm transition-colors"
                    >
                        <span class="material-icons text-xs">notifications_active</span>
                        <span>Notify me when available</span>
                    </button>
                </section>

                <!-- Log Retention -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-icons text-gray-500 text-base">history</span>
                        Log Retention (Preview)
                    </h2>
                    <p class="text-xs text-gray-600 mb-3">Here you will be able to control how long audit logs and access logs are kept.</p>
                    <ul class="space-y-1 text-xs text-gray-700 list-disc list-inside">
                        <li>Login and logout events</li>
                        <li>Password changes and role updates</li>
                        <li>Critical configuration changes</li>
                    </ul>
                </section>
            </div>
        </div>
    </DashboardLayout>
</template>
