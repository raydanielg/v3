<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Toast from '@/Components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs, computed } from 'vue';

const props = defineProps({
    schools: {
        type: Array,
        required: true,
    },
    regions: {
        type: Array,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
});

const { schools, regions, users } = toRefs(props);

const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedSchool = ref(null);
const isSubmitting = ref(false);

const toastMessage = ref('');
const toastType = ref('success');
const showToast = ref(false);

const addForm = ref({
    region_id: '',
    district_id: '',
    name: '',
    code: '',
    headmaster_id: '',
    center_supervisor_id: '',
});

const editForm = ref({
    region_id: '',
    district_id: '',
    name: '',
    code: '',
    headmaster_id: '',
    center_supervisor_id: '',
});

const showToastMessage = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
};

const headmasterOptions = computed(() =>
    users.value.filter((u) => u.role === 'mkuuwashule' || u.role === 'admin')
);

const centerSupervisorOptions = computed(() =>
    users.value.filter((u) => u.role === 'msimamiziwakituo' || u.role === 'admin')
);

const filteredDistrictsForAdd = computed(() => {
    const regionId = addForm.value.region_id;
    const region = regions.value.find((r) => r.id === regionId);
    return region ? region.districts || [] : [];
});

const filteredDistrictsForEdit = computed(() => {
    const regionId = editForm.value.region_id;
    const region = regions.value.find((r) => r.id === regionId);
    return region ? region.districts || [] : [];
});

const openAddModal = () => {
    addForm.value = {
        region_id: '',
        district_id: '',
        name: '',
        code: '',
        headmaster_id: '',
        center_supervisor_id: '',
    };
    showAddModal.value = true;
};

const openEditModal = (school) => {
    selectedSchool.value = school;
    editForm.value = {
        region_id: school.region_id,
        district_id: school.district_id,
        name: school.name,
        code: school.code,
        headmaster_id: school.headmaster_id,
        center_supervisor_id: school.center_supervisor_id,
    };
    showEditModal.value = true;
};

const openDeleteModal = (school) => {
    selectedSchool.value = school;
    showDeleteModal.value = true;
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    showDeleteModal.value = false;
    selectedSchool.value = null;
};

const submitAddSchool = () => {
    if (!addForm.value.region_id || !addForm.value.district_id || !addForm.value.name || !addForm.value.code) {
        showToastMessage('Please select region, district and fill in school name & code.', 'warning');
        return;
    }

    isSubmitting.value = true;

    router.post(route('admin.schools.store'), addForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('School created successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to create school.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const submitEditSchool = () => {
    if (!selectedSchool.value) return;

    if (!editForm.value.region_id || !editForm.value.district_id || !editForm.value.name || !editForm.value.code) {
        showToastMessage('Please select region, district and fill in school name & code.', 'warning');
        return;
    }

    isSubmitting.value = true;

    router.patch(route('admin.schools.update', selectedSchool.value.id), editForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('School updated successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to update school.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const confirmDeleteSchool = () => {
    if (!selectedSchool.value) return;

    isSubmitting.value = true;

    router.delete(route('admin.schools.destroy', selectedSchool.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showToastMessage('School deleted successfully.', 'success');
            closeModals();
        },
        onError: () => {
            showToastMessage('Failed to delete school.', 'error');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="School Management" />

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
                <h1 class="text-3xl font-bold text-gray-900">School Management</h1>
                <p class="text-gray-600 mt-2 text-sm">Manage schools by region, district, and assign headmaster & center supervisor.</p>
            </div>
            <button
                @click="openAddModal"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all"
            >
                <span class="material-icons text-base">domain_add</span>
                <span>Add School</span>
            </button>
        </div>

        <!-- Schools Table -->
        <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">School Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Region</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">District</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Headmaster</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Center Supervisor</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="school in schools" :key="school.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ school.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ school.code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ school.region?.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ school.district?.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span v-if="school.headmaster">
                                    {{ school.headmaster.name }}
                                    <span class="text-xs text-gray-400">({{ school.headmaster.email }})</span>
                                </span>
                                <span v-else class="text-xs text-gray-400">Not assigned</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span v-if="school.center_supervisor">
                                    {{ school.center_supervisor.name }}
                                    <span class="text-xs text-gray-400">({{ school.center_supervisor.email }})</span>
                                </span>
                                <span v-else class="text-xs text-gray-400">Not assigned</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <button
                                        @click="openEditModal(school)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50/60 hover:bg-blue-100 rounded-full transition-colors"
                                    >
                                        <span class="material-icons text-sm">edit_note</span>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        @click="openDeleteModal(school)"
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

        <!-- Add School Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-xl w-full mx-4">
                    <form @submit.prevent="submitAddSchool">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Add New School</h3>
                                <p class="text-xs text-gray-500 mt-1">Select region & district, then add school details and assign staff.</p>
                            </div>
                            <button type="button" @click="closeModals" class="text-gray-500 hover:text-gray-700">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                                    <select
                                        v-model="addForm.region_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Select region...</option>
                                        <option v-for="region in regions" :key="region.id" :value="region.id">
                                            {{ region.name }} ({{ region.code }})
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                                    <select
                                        v-model="addForm.district_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Select district...</option>
                                        <option v-for="district in filteredDistrictsForAdd" :key="district.id" :value="district.id">
                                            {{ district.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
                                    <input
                                        v-model="addForm.name"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                        placeholder="e.g., Emas Secondary School"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">School Code</label>
                                    <input
                                        v-model="addForm.code"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent uppercase tracking-wider"
                                        placeholder="e.g., SCH-001"
                                    >
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Headmaster (Mkuu wa Shule)</label>
                                    <select
                                        v-model="addForm.headmaster_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Not assigned</option>
                                        <option v-for="user in headmasterOptions" :key="user.id" :value="user.id">
                                            {{ user.name }} ({{ user.email }})
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Center Supervisor (Msimamizi wa Kituo)</label>
                                    <select
                                        v-model="addForm.center_supervisor_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Not assigned</option>
                                        <option v-for="user in centerSupervisorOptions" :key="user.id" :value="user.id">
                                            {{ user.name }} ({{ user.email }})
                                        </option>
                                    </select>
                                </div>
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
                                <span>Add School</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Edit School Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl max-w-xl w-full mx-4">
                    <form @submit.prevent="submitEditSchool">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Edit School</h3>
                                <p class="text-xs text-gray-500 mt-1">Update school location and assignments.</p>
                            </div>
                            <button type="button" @click="closeModals" class="text-gray-500 hover:text-gray-700">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                                    <select
                                        v-model="editForm.region_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Select region...</option>
                                        <option v-for="region in regions" :key="region.id" :value="region.id">
                                            {{ region.name }} ({{ region.code }})
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                                    <select
                                        v-model="editForm.district_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                        <option value="">Select district...</option>
                                        <option v-for="district in filteredDistrictsForEdit" :key="district.id" :value="district.id">
                                            {{ district.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
                                    <input
                                        v-model="editForm.name"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">School Code</label>
                                    <input
                                        v-model="editForm.code"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus-border-transparent uppercase tracking-wider"
                                    >
                                </div>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Headmaster (Mkuu wa Shule)</label>
                                    <select
                                        v-model="editForm.headmaster_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus-border-transparent"
                                    >
                                        <option value="">Not assigned</option>
                                        <option v-for="user in headmasterOptions" :key="user.id" :value="user.id">
                                            {{ user.name }} ({{ user.email }})
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Center Supervisor (Msimamizi wa Kituo)</label>
                                    <select
                                        v-model="editForm.center_supervisor_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus-border-transparent"
                                    >
                                        <option value="">Not assigned</option>
                                        <option v-for="user in centerSupervisorOptions" :key="user.id" :value="user.id">
                                            {{ user.name }} ({{ user.email }})
                                        </option>
                                    </select>
                                </div>
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

        <!-- Delete School Modal -->
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
                            <h3 class="text-base font-semibold text-gray-900">Delete School</h3>
                            <p class="mt-1 text-sm text-gray-600">Are you sure you want to delete this school? This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 text-sm text-gray-700" v-if="selectedSchool">
                        <p>
                            School:
                            <span class="font-semibold">{{ selectedSchool.name }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ selectedSchool.code }})</span>
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
                            @click="confirmDeleteSchool"
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
