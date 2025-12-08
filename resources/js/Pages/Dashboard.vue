<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Exams</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
                        <p class="text-xs text-gray-500 mt-1">+2 this month</p>
                    </div>
                    <div class="rounded-lg bg-emerald-100 p-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.596 6.253 2 10.849 2 16.5S6.596 26.75 12 26.75s10-4.596 10-10.25S17.404 6.253 12 6.253Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">18</p>
                        <p class="text-xs text-gray-500 mt-1">75% completion</p>
                    </div>
                    <div class="rounded-lg bg-blue-100 p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">6</p>
                        <p class="text-xs text-gray-500 mt-1">25% remaining</p>
                    </div>
                    <div class="rounded-lg bg-amber-100 p-3">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Score</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">85%</p>
                        <p class="text-xs text-gray-500 mt-1">+5% improvement</p>
                    </div>
                    <div class="rounded-lg bg-purple-100 p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid gap-6 lg:grid-cols-3 mb-8">
            <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Exams</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-emerald-100 p-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Mathematics Final Exam</p>
                                <p class="text-sm text-gray-500">Completed on Dec 5, 2025</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-emerald-600">92%</p>
                            <p class="text-xs text-gray-500">Passed</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-blue-100 p-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">English Literature Test</p>
                                <p class="text-sm text-gray-500">Completed on Dec 3, 2025</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-blue-600">88%</p>
                            <p class="text-xs text-gray-500">Passed</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg bg-amber-100 p-2">
                                <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Physics Midterm Exam</p>
                                <p class="text-sm text-gray-500">In Progress</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-amber-600">45%</p>
                            <p class="text-xs text-gray-500">In progress</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button class="w-full flex items-center gap-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Start New Exam
                    </button>
                    <button class="w-full flex items-center gap-3 rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-3 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0Z" />
                        </svg>
                        View Results
                    </button>
                    <button class="w-full flex items-center gap-3 rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-3 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z" />
                        </svg>
                        Settings
                    </button>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
