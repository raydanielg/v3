<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    user: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <DashboardLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 mt-2">System management and analytics</p>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-red-100 border border-red-300 rounded-lg">
                    <span class="material-icons text-red-600">admin_panel_settings</span>
                    <span class="text-sm font-medium text-red-900">Administrator</span>
                </div>
            </div>
        </div>

        <!-- Admin Stats -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">1,234</p>
                        <p class="text-xs text-gray-500 mt-1">+45 this month</p>
                    </div>
                    <div class="rounded-lg bg-blue-100 p-3">
                        <span class="material-icons text-blue-600 text-2xl">people</span>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Schools</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">156</p>
                        <p class="text-xs text-gray-500 mt-1">+12 this month</p>
                    </div>
                    <div class="rounded-lg bg-emerald-100 p-3">
                        <span class="material-icons text-emerald-600 text-2xl">school</span>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Exams</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">5,678</p>
                        <p class="text-xs text-gray-500 mt-1">+234 this month</p>
                    </div>
                    <div class="rounded-lg bg-purple-100 p-3">
                        <span class="material-icons text-purple-600 text-2xl">assignment</span>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">System Health</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">99.8%</p>
                        <p class="text-xs text-gray-500 mt-1">Uptime</p>
                    </div>
                    <div class="rounded-lg bg-emerald-100 p-3">
                        <span class="material-icons text-emerald-600 text-2xl">health_and_safety</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Controls -->
        <div class="grid gap-6 lg:grid-cols-3 mb-8">
            <!-- User Management -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">User Management</h3>
                        <p class="text-sm text-gray-600 mt-1">Manage system users and roles</p>
                    </div>
                    <span class="material-icons text-blue-600 text-2xl">manage_accounts</span>
                </div>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">group_add</span>
                        Add User
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">list</span>
                        View All Users
                    </button>
                </div>
            </div>

            <!-- School Management -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">School Management</h3>
                        <p class="text-sm text-gray-600 mt-1">Manage schools and institutions</p>
                    </div>
                    <span class="material-icons text-emerald-600 text-2xl">domain</span>
                </div>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">add_location</span>
                        Add School
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">list</span>
                        View Schools
                    </button>
                </div>
            </div>

            <!-- System Settings -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">System Settings</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure system parameters</p>
                    </div>
                    <span class="material-icons text-purple-600 text-2xl">settings</span>
                </div>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">tune</span>
                        Settings
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <span class="material-icons text-lg">description</span>
                        Logs
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent System Activity</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-blue-100 p-2">
                            <span class="material-icons text-blue-600">person_add</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">New user registered</p>
                            <p class="text-xs text-gray-600">John Doe registered as teacher</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">2 hours ago</span>
                </div>

                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-emerald-100 p-2">
                            <span class="material-icons text-emerald-600">school</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">School added</p>
                            <p class="text-xs text-gray-600">Dar es Salaam High School registered</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">5 hours ago</span>
                </div>

                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-purple-100 p-2">
                            <span class="material-icons text-purple-600">assignment</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Exam created</p>
                            <p class="text-xs text-gray-600">Mathematics Final Exam created</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">1 day ago</span>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
