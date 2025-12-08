<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    regions: {
        type: Array,
        required: true,
    },
});

const showAddModal = ref(false);
const showEditModal = ref(false);
const showImportModal = ref(false);
const selectedRegion = ref(null);
const selectedRegions = ref([]);
const showDeleteModal = ref(false);
const regionToDelete = ref(null);
const isSubmitting = ref(false);

const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const formData = ref({
    name: '',
    code: '',
    description: '',
});

const importFile = ref(null);

const openAddModal = () => {
    formData.value = {
        name: '',
        code: '',
        description: '',
    };
    showAddModal.value = true;
};

const openEditModal = (region) => {
    selectedRegion.value = region;
    formData.value = {
        name: region.name || '',
        code: region.code || '',
        description: region.description || '',
    };
    showEditModal.value = true;
};

const openImportModal = () => {
    importFile.value = null;
    showImportModal.value = true;
};

const openDeleteModal = (region) => {
    regionToDelete.value = region;
    showDeleteModal.value = true;
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    showImportModal.value = false;
    showDeleteModal.value = false;
    selectedRegion.value = null;
    regionToDelete.value = null;
};

const toggleSelectAll = (event) => {
    if (event.target.checked) {
        selectedRegions.value = regions.map(r => r.id);
    } else {
        selectedRegions.value = [];
    }
};

const toggleRegionSelect = (regionId) => {
    const index = selectedRegions.value.indexOf(regionId);
    if (index > -1) {
        selectedRegions.value.splice(index, 1);
    } else {
        selectedRegions.value.push(regionId);
    }
};

const bulkDelete = () => {
    if (selectedRegions.value.length === 0) {
        alert('Please select regions to delete');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selectedRegions.value.length} region(s)?`)) {
        // TODO: Implement bulk delete API call
        console.log('Bulk delete:', selectedRegions.value);
    }
};

const handleImport = () => {
    if (!importFile.value) {
        alert('Please select a file');
        return;
    }
    
    // TODO: Implement bulk import API call
    console.log('Import file:', importFile.value);
    closeModals();
};

const confirmDeleteRegion = () => {
    if (!regionToDelete.value) return;

    router.delete(route('admin.regions.delete', regionToDelete.value.id), {
        onFinish: () => {
            closeModals();
        },
    });
};

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const submitAddRegion = () => {
    if (!formData.value.name || !formData.value.code) {
        showToastMessage('Please fill in region name and code.', 'warning');
        return;
    }

    isSubmitting.value = true;

    router.post(route('admin.regions.store'), formData.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('Region added successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to add region. Please check the details.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="Regions Management" />

    <DashboardLayout>
        <Toast
            v-if="showToast"
            :message="toastMessage"
            :type="toastType"
            :duration="4000"
            @close="showToast = false"
        />
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Regions Management</h1>
                    <p class="text-gray-600 mt-2">Manage all regions in the system</p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        @click="openImportModal"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all"
                    >
                        <span class="material-icons">upload</span>
                        Import
                    </button>
                    <button
                        @click="openAddModal"
                        class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all"
                    >
                        <span class="material-icons">add</span>
                        Add Region
                    </button>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Bar -->
        <div v-if="selectedRegions.length > 0" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-icons text-blue-600">info</span>
                <span class="text-sm font-medium text-blue-900">{{ selectedRegions.length }} region(s) selected</span>
            </div>
            <button
                @click="bulkDelete"
                class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all"
            >
                <span class="material-icons text-sm">delete</span>
                Delete Selected
            </button>
        </div>

        <!-- Regions Table -->
        <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <input
                                    type="checkbox"
                                    @change="toggleSelectAll"
                                    :checked="selectedRegions.length === regions.length && regions.length > 0"
                                    class="rounded border-gray-300"
                                >
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Region Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Districts</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="region in regions" :key="region.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm">
                                <input
                                    type="checkbox"
                                    :checked="selectedRegions.includes(region.id)"
                                    @change="toggleRegionSelect(region.id)"
                                    class="rounded border-gray-300"
                                >
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ region.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ region.code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ region.districts?.length || 0 }} districts
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <button
                                        @click="openEditModal(region)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50/60 hover:bg-blue-100 rounded-full transition-colors"
                                        title="Edit region"
                                    >
                                        <span class="material-icons text-sm">edit_note</span>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        @click="openDeleteModal(region)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50/60 hover:bg-red-100 rounded-full transition-colors"
                                        title="Delete region"
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

        <!-- Add Region Modal -->
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
                    <form @submit.prevent="submitAddRegion">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Add New Region</h3>
                                <p class="text-xs text-gray-500 mt-1">Create a new region with a code and optional description.</p>
                            </div>
                            <button type="button" @click="closeModals" class="text-gray-500 hover:text-gray-700">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Region Name</label>
                                <input
                                    v-model="formData.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="e.g., Dar es Salaam"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                                <input
                                    v-model="formData.code"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent uppercase tracking-wider"
                                    placeholder="e.g., DSM"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea
                                    v-model="formData.description"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="Optional: short description for this region"
                                ></textarea>
                            </div>
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
                                <span>Add Region</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Delete Confirmation Modal -->
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
                            <h3 class="text-base font-semibold text-gray-900">Delete Region</h3>
                            <p class="mt-1 text-sm text-gray-600">Are you sure you want to delete this region? This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 text-sm text-gray-700" v-if="regionToDelete">
                        <p>
                            Region:
                            <span class="font-semibold">{{ regionToDelete.name }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ regionToDelete.code }})</span>
                        </p>
                        <p class="mt-1 text-xs text-gray-500">All related districts will also be removed.</p>
                    </div>
                    <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                        <button
                            @click="closeModals"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmDeleteRegion"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Import Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showImportModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Import Regions</h3>
                        <button @click="closeModals" class="text-gray-500 hover:text-gray-700">
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Upload a CSV or Excel file with region data</p>
                            <label class="block">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition-colors">
                                    <span class="material-icons text-4xl text-gray-400 block mb-2">cloud_upload</span>
                                    <p class="text-sm font-medium text-gray-700">Click to upload or drag and drop</p>
                                    <p class="text-xs text-gray-500">CSV, XLS, XLSX (max 5MB)</p>
                                    <input
                                        type="file"
                                        @change="(e) => importFile = e.target.files?.[0]"
                                        accept=".csv,.xls,.xlsx"
                                        class="hidden"
                                    >
                                </div>
                            </label>
                            <p v-if="importFile" class="text-sm text-emerald-600 mt-2">
                                <span class="material-icons text-sm align-middle">check_circle</span>
                                {{ importFile.name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                        <button @click="closeModals" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button @click="handleImport" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Import
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Edit Region Modal -->
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
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Region</h3>
                        <button @click="closeModals" class="text-gray-500 hover:text-gray-700">
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Region Name</label>
                            <input v-model="formData.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                            <input v-model="formData.code" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea v-model="formData.description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 border-t border-gray-200 px-6 py-4">
                        <button @click="closeModals" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            Update Region
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </DashboardLayout>
</template>
