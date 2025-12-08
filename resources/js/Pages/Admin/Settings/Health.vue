<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    settings: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
    backups: {
        type: Object,
        required: true,
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

const formatBytes = (bytes) => {
    if (!bytes || bytes <= 0) return '0 MB';
    const mb = bytes / (1024 * 1024);
    if (mb < 1024) return mb.toFixed(1) + ' MB';
    const gb = mb / 1024;
    return gb.toFixed(2) + ' GB';
};

const dbSizeHuman = computed(() => formatBytes(props.stats.db_size_bytes));
const backupsSizeHuman = computed(() => formatBytes(props.stats.backups_size_bytes));
const totalSizeHuman = computed(() => formatBytes(props.stats.total_size_bytes));

const monthlyUsage = computed(() => props.stats.monthly_usage || []);

const maxMonthlySize = computed(() => {
    if (!monthlyUsage.value.length) return 1;
    return Math.max(...monthlyUsage.value.map((m) => m.total_size || 0)) || 1;
});

const clearCacheForm = useForm({});

const submitClearCache = () => {
    clearCacheForm.post(route('admin.settings.health.clear-cache'), {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('System cache cleared successfully', 'success');
        },
        onError: () => {
            showToastMessage('Failed to clear cache', 'error');
        },
    });
};
</script>

<template>
    <Head title="System Health" />

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
                <h1 class="text-3xl font-bold text-gray-900">System Health</h1>
                <p class="text-gray-600 mt-2 text-sm">
                    Overview of database size, backups and storage usage for this system.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-xs font-medium">
                <span class="material-icons text-sm">monitor_heart</span>
                <span>Monitoring Active</span>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3 mb-8">
            <!-- DB Size -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-emerald-500 text-2xl">database</span>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Database Size</h2>
                            <p class="text-xs text-gray-500">Main application database</p>
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ dbSizeHuman }}</p>
                <p class="text-[11px] text-gray-500">includes all tables and indexes</p>
            </section>

            <!-- Backups Size -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-indigo-500 text-2xl">backup</span>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Backups Size</h2>
                            <p class="text-xs text-gray-500">All stored backup files</p>
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ backupsSizeHuman }}</p>
                <p class="text-[11px] text-gray-500">from Backup & Restore section</p>
            </section>

            <!-- Total Size + Clear Cache -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-amber-500 text-2xl">storage</span>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Total System Footprint</h2>
                            <p class="text-xs text-gray-500">Database + backups (approx.)</p>
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ totalSizeHuman }}</p>
                <p class="text-[11px] text-gray-500">does not include logs and cache yet</p>

                <div class="mt-2 border-t border-gray-200 pt-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-700 flex items-center gap-1">
                            <span class="material-icons text-xs text-gray-500">cleaning_services</span>
                            Clear Application Cache
                        </span>
                    </div>
                    <button
                        type="button"
                        @click="submitClearCache"
                        :disabled="clearCacheForm.processing"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium bg-rose-600 hover:bg-rose-700 text-white shadow-sm disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span class="material-icons text-xs" v-if="!clearCacheForm.processing">cleaning_services</span>
                        <span class="material-icons text-xs animate-spin" v-else>sync</span>
                        <span>{{ clearCacheForm.processing ? 'Clearing...' : 'Clear Cache' }}</span>
                    </button>
                    <p class="text-[11px] text-gray-400 mt-1">Use this if the system feels slow or after major configuration changes.</p>
                </div>
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Bar Chart -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-blue-500 text-xl">bar_chart</span>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Storage Growth (Backups)</h2>
                            <p class="text-xs text-gray-500">Approximate backup size per month</p>
                        </div>
                    </div>
                </div>

                <div v-if="!monthlyUsage.length" class="text-xs text-gray-500">
                    No backup data available yet to build the chart.
                </div>

                <div v-else class="mt-4 h-64 flex items-end gap-4 border-t border-gray-100 pt-4">
                    <div
                        v-for="month in monthlyUsage"
                        :key="month.month"
                        class="flex-1 flex flex-col items-center gap-2"
                    >
                        <div class="flex flex-col items-center gap-1">
                            <div
                                class="w-10 rounded-t-lg bg-gradient-to-t from-emerald-500 to-emerald-300 shadow-sm"
                                :style="{ height: `${(month.total_size / maxMonthlySize) * 100 || 5}%` }"
                            ></div>
                            <span class="text-[11px] text-gray-500 font-medium">{{ formatBytes(month.total_size) }}</span>
                        </div>
                        <span class="text-[11px] text-gray-400 mt-1">{{ month.month }}</span>
                    </div>
                </div>
            </section>

            <!-- Paginated Backups List -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-gray-500 text-xl">list_alt</span>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Backups (Paginated)</h2>
                            <p class="text-xs text-gray-500">Latest backups with size and date.</p>
                        </div>
                    </div>
                </div>

                <div v-if="!backups.data.length" class="text-xs text-gray-500">
                    No backups found yet.
                </div>

                <div v-else class="space-y-2 text-xs text-gray-700">
                    <div
                        v-for="backup in backups.data"
                        :key="backup.id"
                        class="flex items-center justify-between rounded-lg border border-gray-100 px-3 py-2 hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-900">{{ backup.name }}</span>
                            <span class="text-[11px] text-gray-500">{{ new Date(backup.created_at).toLocaleString() }}</span>
                        </div>
                        <div class="text-right text-[11px] text-gray-500">
                            <div class="font-semibold text-gray-900">{{ formatBytes(backup.size) }}</div>
                            <div class="mt-0.5">Disk: {{ backup.disk }}</div>
                        </div>
                    </div>

                    <!-- Simple pagination -->
                    <div class="flex items-center justify-between pt-3 mt-2 border-t border-gray-100">
                        <button
                            type="button"
                            :disabled="!backups.links?.prev"
                            @click="$inertia.visit(backups.links.prev, { preserveScroll: true })"
                            class="inline-flex items-center gap-1 px-2 py-1.5 rounded-lg text-[11px] font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span class="material-icons text-xs">chevron_left</span>
                            Prev
                        </button>
                        <span class="text-[11px] text-gray-400">
                            Page {{ backups.current_page }} of {{ backups.last_page }}
                        </span>
                        <button
                            type="button"
                            :disabled="!backups.links?.next"
                            @click="$inertia.visit(backups.links.next, { preserveScroll: true })"
                            class="inline-flex items-center gap-1 px-2 py-1.5 rounded-lg text-[11px] font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Next
                            <span class="material-icons text-xs">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </DashboardLayout>
</template>
