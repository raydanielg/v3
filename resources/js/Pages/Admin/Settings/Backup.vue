<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';

const props = defineProps({
    backups: {
        type: Array,
        required: true,
    },
});

const { backups } = toRefs(props);

const isCreating = ref(false);
const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const createBackup = () => {
    if (isCreating.value) return;

    isCreating.value = true;

    router.post(route('admin.settings.backup.store'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('Backup created successfully.', 'success');
        },
        onError: () => {
            showToastMessage('Failed to create backup.', 'error');
        },
        onFinish: () => {
            isCreating.value = false;
        },
    });
};
</script>

<template>
    <Head title="Backup & Restore" />

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
                <h1 class="text-3xl font-bold text-gray-900">Backup & Restore</h1>
                <p class="text-gray-600 mt-2 text-sm">Create and download backups of the system database.</p>
            </div>
            <button
                type="button"
                @click="createBackup"
                :disabled="isCreating"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <svg
                    v-if="isCreating"
                    class="animate-spin h-4 w-4 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span v-else class="material-icons text-base">backup</span>
                <span>{{ isCreating ? 'Creating Backup...' : 'Create Backup' }}</span>
            </button>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Info card -->
            <section class="rounded-xl border border-blue-200 bg-blue-50 p-6 shadow-sm lg:col-span-1">
                <h2 class="text-base font-semibold text-blue-900 mb-2 flex items-center gap-2">
                    <span class="material-icons text-blue-500 text-base">info</span>
                    Backup Notes
                </h2>
                <p class="text-xs text-blue-900 mb-2">
                    This tool creates a copy of your SQLite database file and stores it in the server's storage. You can then download the backup file.
                </p>
                <ul class="text-xs text-blue-900 list-disc list-inside space-y-1">
                    <li>Backups are stored under <code>storage/app/backups</code>.</li>
                    <li>Download backups regularly to a safe location.</li>
                    <li>Database restore is sensitive and should be done manually by a system administrator.</li>
                </ul>
            </section>

            <!-- Backups table -->
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <span class="material-icons text-gray-500 text-base">storage</span>
                        Available Backups
                    </h2>
                </div>
                <div v-if="backups.length === 0" class="text-sm text-gray-500">
                    No backups have been created yet. Click "Create Backup" to generate one.
                </div>
                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Size</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Created At</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="backup in backups" :key="backup.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ backup.name }}</td>
                                <td class="px-4 py-2">
                                    <span class="text-xs text-gray-700">{{ (backup.size / 1024).toFixed(1) }} KB</span>
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-600">
                                    {{ new Date(backup.created_at).toLocaleString() }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a
                                        :href="route('admin.settings.backup.download', backup.id)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-full transition-colors"
                                    >
                                        <span class="material-icons text-sm">download</span>
                                        <span>Download</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </DashboardLayout>
</template>
