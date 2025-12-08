<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

const page = usePage();
const sidebarOpen = ref(false);
const userMenuOpen = ref(false);
const notificationsOpen = ref(false);
const isAdmin = computed(() => page.props.auth.user?.role === 'admin');

const notifications = ref([
    {
        id: 1,
        type: 'success',
        title: 'Admin signed in',
        message: 'You signed in successfully',
        icon: 'login',
        time: 'Just now',
    },
    {
        id: 2,
        type: 'info',
        title: 'New user created account',
        message: 'A new user has registered in the system',
        icon: 'person_add',
        time: '5 min ago',
    },
    {
        id: 3,
        type: 'warning',
        title: 'Multiple failed logins',
        message: '5 failed login attempts detected',
        icon: 'warning',
        time: '12 min ago',
    },
]);

const unreadCount = ref(notifications.value.length);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value;
};

const toggleNotifications = () => {
    notificationsOpen.value = !notificationsOpen.value;

    if (notificationsOpen.value) {
        unreadCount.value = 0;
    }
};
</script>

<template>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar Component -->
        <Sidebar :open="sidebarOpen" @toggle="toggleSidebar" />

        <!-- Main content -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Header -->
            <header class="border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <!-- Left: Menu button + Title -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="toggleSidebar"
                            class="lg:hidden inline-flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 p-2"
                        >
                            <span class="material-icons text-2xl">menu</span>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-sm text-gray-500">Welcome back, {{ page.props.auth.user.name }}</p>
                        </div>
                    </div>

                    <!-- Right: Search + Notifications + User menu -->
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <input
                                    type="text"
                                    placeholder="Search..."
                                    class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pl-10 text-sm text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                />
                                <span class="material-icons absolute left-3 top-2 text-gray-400 text-xl">search</span>
                            </div>
                        </div>

                        <!-- Notifications (admin only) -->
                        <div v-if="isAdmin" class="relative">
                            <button
                                @click="toggleNotifications"
                                class="relative inline-flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 p-2"
                            >
                                <span class="material-icons text-2xl">notifications</span>
                                <span
                                    v-if="unreadCount > 0"
                                    class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
                                >
                                    {{ unreadCount }}
                                </span>
                            </button>

                            <Transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-if="notificationsOpen"
                                    class="absolute right-0 mt-2 w-80 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-40"
                                >
                                    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                            <p class="text-xs text-gray-500">Latest system activity</p>
                                        </div>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                            <span class="material-icons text-[14px]">notifications_active</span>
                                            Live
                                        </span>
                                    </div>
                                    <div v-if="!notifications.length" class="px-4 py-6 text-xs text-gray-500">
                                        No notifications yet.
                                    </div>
                                    <div v-else class="max-h-72 overflow-y-auto divide-y divide-gray-100 text-sm">
                                        <div
                                            v-for="item in notifications"
                                            :key="item.id"
                                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors"
                                        >
                                            <div class="mt-1">
                                                <span
                                                    class="material-icons text-base"
                                                    :class="{
                                                        'text-emerald-500': item.type === 'success',
                                                        'text-blue-500': item.type === 'info',
                                                        'text-amber-500': item.type === 'warning',
                                                        'text-red-500': item.type === 'error',
                                                    }"
                                                >
                                                    {{ item.icon }}
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-gray-900">{{ item.title }}</p>
                                                <p class="text-[11px] text-gray-500">{{ item.message }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1">{{ item.time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Transition>
                        </div>

                        <!-- User menu -->
                        <div class="relative">
                            <button
                                @click="toggleUserMenu"
                                class="flex items-center gap-2 rounded-lg text-gray-700 hover:bg-gray-100 p-2"
                            >
                                <img
                                    :src="`https://ui-avatars.com/api/?name=${page.props.auth.user.name}&background=10b981&color=fff`"
                                    :alt="page.props.auth.user.name"
                                    class="h-8 w-8 rounded-full"
                                />
                                <span class="hidden sm:block text-sm font-medium">{{ page.props.auth.user.name }}</span>
                                <span class="material-icons text-lg">expand_more</span>
                            </button>

                            <!-- User dropdown menu -->
                            <Transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-if="userMenuOpen"
                                    class="absolute right-0 mt-2 w-48 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                >
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-medium text-gray-900">{{ page.props.auth.user.name }}</p>
                                        <p class="text-xs text-gray-500">{{ page.props.auth.user.email }}</p>
                                        <div class="mt-2 inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 rounded text-xs font-medium text-emerald-800 capitalize">
                                            <span class="material-icons text-sm">verified_user</span>
                                            {{ page.props.auth.user.role === 'school_manager' ? 'Mkuu wa Shule' : page.props.auth.user.role === 'district_manager' ? 'Msimamizi wa Kiti' : page.props.auth.user.role === 'teacher' ? 'Mwalimu' : page.props.auth.user.role === 'student' ? 'Mwanafunzi' : 'Admin' }}
                                        </div>
                                    </div>
                                    <Link
                                        :href="route('profile.show')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        My Profile
                                    </Link>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-200"
                                    >
                                        Logout
                                    </Link>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-auto">
                <div class="px-4 py-8 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>

        <!-- Sidebar overlay (mobile) -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="sidebarOpen"
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
            ></div>
        </Transition>
    </div>
</template>
