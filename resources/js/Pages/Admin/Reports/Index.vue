<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    metrics: {
        type: Object,
        required: false,
        default: () => ({ schools: 0, regions: 0, districts: 0, users: 0 }),
    },
});
</script>

<template>
    <Head title="Reports" />

    <DashboardLayout>
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Reports</h1>
                <p class="text-gray-600 mt-2 text-sm">School ranking, top performers, and detailed analytics will appear here.</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
                <span class="material-icons text-sm">pending</span>
                <span>More reports coming soon</span>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <!-- School Ranking Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">School Ranking</h2>
                        <p class="text-xs text-gray-500 mt-1">Overall ranking of schools based on exam performance.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 uppercase tracking-wide">
                        Coming Soon
                    </span>
                </div>
                <div class="mt-4 flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <span class="material-icons text-5xl text-gray-200 block mb-2">leaderboard</span>
                        <p class="text-xs text-gray-500">Total Schools: <span class="font-semibold text-gray-800">{{ metrics.schools }}</span></p>
                        <p class="text-xs text-gray-500">Regions: <span class="font-semibold text-gray-800">{{ metrics.regions }}</span> • Districts: <span class="font-semibold text-gray-800">{{ metrics.districts }}</span></p>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    This section will show top schools by region, district, and nationally.
                </div>
            </div>

            <!-- Top Performers Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Top Performers</h2>
                        <p class="text-xs text-gray-500 mt-1">Top students and schools per exam and term.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 uppercase tracking-wide">
                        Coming Soon
                    </span>
                </div>
                <div class="mt-4 flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <span class="material-icons text-5xl text-gray-200 block mb-2">emoji_events</span>
                        <p class="text-xs text-gray-500">Total Users: <span class="font-semibold text-gray-800">{{ metrics.users }}</span></p>
                        <p class="text-xs text-gray-500">(Admins, Afisa Elimu, Walimu, n.k.)</p>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    This section will highlight the best performing students, subjects, and schools.
                </div>
            </div>

            <!-- Subject-wise Results Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Subject-wise Results</h2>
                        <p class="text-xs text-gray-500 mt-1">Performance breakdown per subject.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 uppercase tracking-wide">
                        Coming Soon
                    </span>
                </div>
                <div class="mt-4 flex-1 flex items-center justify-center">
                    <span class="material-icons text-5xl text-gray-200">analytics</span>
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    This section will show strengths and weaknesses across different subjects.
                </div>
            </div>

            <!-- Ward-wise Results Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Ward-wise Results</h2>
                        <p class="text-xs text-gray-500 mt-1">Results aggregated per ward / kata.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 uppercase tracking-wide">
                        Coming Soon
                    </span>
                </div>
                <div class="mt-4 flex-1 flex items-center justify-center">
                    <span class="material-icons text-5xl text-gray-200">map</span>
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    This section will allow comparison of wards within a district or region.
                </div>
            </div>

            <!-- DEO / DKE Reports Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">DEO / DKE Reports</h2>
                        <p class="text-xs text-gray-500 mt-1">Special dashboards for education officers.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 uppercase tracking-wide">
                        Coming Soon
                    </span>
                </div>
                <div class="mt-4 flex-1 flex items-center justify-center">
                    <span class="material-icons text-5xl text-gray-200">badge</span>
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    This section will provide detailed views for Afisa Elimu, DEO/DKE and supervisors.
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
