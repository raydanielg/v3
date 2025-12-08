<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    logs: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="My Activity Logs" />

    <DashboardLayout>
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Activity Logs</h1>
                <p class="text-gray-600 mt-2 text-sm">Recent actions performed with your administrator account.</p>
            </div>
        </div>

        <div class="rounded-lg bg-white shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <span class="material-icons text-gray-500 text-base">history</span>
                    Recent Activity
                </h2>
                <span class="text-xs text-gray-500">Showing latest {{ logs.length }} events</span>
            </div>

            <div v-if="logs.length === 0" class="text-sm text-gray-500">
                No activity logs found for your account yet.
            </div>

            <div v-else class="max-h-[480px] overflow-y-auto divide-y divide-gray-100 text-sm">
                <div
                    v-for="log in logs"
                    :key="log.id"
                    class="flex items-start justify-between py-3"
                >
                    <div class="flex items-start gap-3">
                        <div class="mt-1">
                            <span class="material-icons text-emerald-500 text-base">event_note</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ log.action }}</p>
                            <p class="text-xs text-gray-500" v-if="log.description">{{ log.description }}</p>
                            <p class="text-[11px] text-gray-400 mt-1">
                                <span v-if="log.url">{{ log.url }}</span>
                                <span v-if="log.ip_address"> • IP: {{ log.ip_address }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="text-[11px] text-gray-400 text-right min-w-[120px]">
                        {{ new Date(log.created_at).toLocaleString() }}
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
