<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

const page = usePage();
const sidebarOpen = ref(false);
const userMenuOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value;
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

                        <!-- Notifications -->
                        <button class="relative inline-flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 p-2">
                            <span class="material-icons text-2xl">notifications</span>
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                        </button>

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
                                    </div>
                                    <Link
                                        :href="route('profile.edit')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Profile Settings
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
