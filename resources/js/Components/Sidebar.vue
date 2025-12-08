<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['toggle']);

const page = usePage();
const expandedMenus = ref({});

const isAdmin = computed(() => page.props.auth.user?.role === 'admin');

const navigation = [
    {
        name: 'Dashboard',
        icon: 'dashboard',
        submenu: [
            { name: 'Overview', href: route('dashboard') },
            { name: 'Statistics', href: route('dashboard') },
            { name: 'Recent Activities', href: route('dashboard') },
        ],
    },
    {
        name: 'Students',
        icon: 'groups',
        submenu: [
            { name: 'All Students', href: route('dashboard') },
            { name: 'Add Student', href: route('dashboard') },
            { name: 'Student Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Classes',
        icon: 'class',
        submenu: [
            { name: 'All Classes', href: route('dashboard') },
            { name: 'Create Class', href: route('dashboard') },
            { name: 'Class Schedule', href: route('dashboard') },
        ],
    },
    {
        name: 'Subjects',
        icon: 'subject',
        submenu: [
            { name: 'All Subjects', href: route('dashboard') },
            { name: 'Add Subject', href: route('dashboard') },
            { name: 'Subject Allocation', href: route('dashboard') },
        ],
    },
    {
        name: 'Teachers',
        icon: 'person_4',
        submenu: [
            { name: 'All Teachers', href: route('dashboard') },
            { name: 'Add Teacher', href: route('dashboard') },
            { name: 'Teacher Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Exams',
        icon: 'assignment',
        submenu: [
            { name: 'All Exams', href: route('dashboard') },
            { name: 'Create Exam', href: route('dashboard') },
            { name: 'Exam Schedule', href: route('dashboard') },
        ],
    },
    {
        name: 'Results',
        icon: 'assessment',
        submenu: [
            { name: 'View Results', href: route('dashboard') },
            { name: 'Result Analysis', href: route('dashboard') },
            { name: 'Export Results', href: route('dashboard') },
        ],
    },
    {
        name: 'Reports',
        icon: 'description',
        submenu: [
            { name: 'Academic Reports', href: route('dashboard') },
            { name: 'Performance Reports', href: route('dashboard') },
            { name: 'Attendance Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Notifications',
        icon: 'notifications',
        submenu: [
            { name: 'All Notifications', href: route('dashboard') },
            { name: 'Mark as Read', href: route('dashboard') },
            { name: 'Notification Settings', href: route('dashboard') },
        ],
    },
    {
        name: 'Settings',
        icon: 'settings',
        submenu: [
            { name: 'System Settings', href: route('dashboard') },
            { name: 'User Management', href: route('dashboard') },
            { name: 'Security', href: route('dashboard') },
        ],
    },
    {
        name: 'Profile',
        icon: 'account_circle',
        submenu: [
            { name: 'My Profile', href: route('profile.show') },
            { name: 'Account Settings', href: route('profile.show') },
        ],
    },
];

const adminNavigation = [
    {
        name: 'Admin Dashboard',
        icon: 'admin_panel_settings',
        submenu: [
            { name: 'Overview', href: route('admin.dashboard') },
            { name: 'System Health', href: route('admin.dashboard') },
            { name: 'Activity Log', href: route('admin.dashboard') },
        ],
    },
    {
        name: 'User Management',
        icon: 'manage_accounts',
        submenu: [
            { name: 'All Users', href: route('admin.users.index') },
            { name: 'Add User', href: route('admin.users.index') },
            { name: 'User Roles', href: route('admin.users.index') },
        ],
    },
    {
        name: 'School Management',
        icon: 'domain',
        submenu: [
            { name: 'All Schools', href: route('admin.dashboard') },
            { name: 'Add School', href: route('admin.dashboard') },
            { name: 'School Reports', href: route('admin.dashboard') },
        ],
    },
    {
        name: 'System Settings',
        icon: 'settings',
        submenu: [
            { name: 'General Settings', href: route('admin.dashboard') },
            { name: 'Security', href: route('admin.dashboard') },
            { name: 'Backup & Restore', href: route('admin.dashboard') },
        ],
    },
    {
        name: 'Reports',
        icon: 'description',
        submenu: [
            { name: 'System Reports', href: route('admin.dashboard') },
            { name: 'User Analytics', href: route('admin.dashboard') },
            { name: 'Exam Statistics', href: route('admin.dashboard') },
        ],
    },
    {
        name: 'Geographical',
        icon: 'public',
        submenu: [
            { name: 'All Regions', href: route('admin.regions') },
            { name: 'All Districts', href: route('admin.districts') },
        ],
    },
    {
        name: 'Profile',
        icon: 'account_circle',
        submenu: [
            { name: 'My Profile', href: route('profile.show') },
            { name: 'Account Settings', href: route('profile.show') },
        ],
    },
];

const schoolManagerNavigation = [
    {
        name: 'Dashboard',
        icon: 'dashboard',
        submenu: [
            { name: 'Overview', href: route('dashboard') },
            { name: 'School Statistics', href: route('dashboard') },
            { name: 'Recent Activities', href: route('dashboard') },
        ],
    },
    {
        name: 'Teachers',
        icon: 'person_4',
        submenu: [
            { name: 'All Teachers', href: route('dashboard') },
            { name: 'Add Teacher', href: route('dashboard') },
            { name: 'Teacher Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Students',
        icon: 'groups',
        submenu: [
            { name: 'All Students', href: route('dashboard') },
            { name: 'Add Student', href: route('dashboard') },
            { name: 'Student Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Exams',
        icon: 'assignment',
        submenu: [
            { name: 'All Exams', href: route('dashboard') },
            { name: 'Create Exam', href: route('dashboard') },
            { name: 'Exam Schedule', href: route('dashboard') },
        ],
    },
    {
        name: 'Results',
        icon: 'assessment',
        submenu: [
            { name: 'View Results', href: route('dashboard') },
            { name: 'Result Analysis', href: route('dashboard') },
            { name: 'Export Results', href: route('dashboard') },
        ],
    },
    {
        name: 'Reports',
        icon: 'description',
        submenu: [
            { name: 'Academic Reports', href: route('dashboard') },
            { name: 'Performance Reports', href: route('dashboard') },
            { name: 'Attendance Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Profile',
        icon: 'account_circle',
        submenu: [
            { name: 'My Profile', href: route('profile.show') },
            { name: 'Account Settings', href: route('profile.show') },
        ],
    },
];

const districtManagerNavigation = [
    {
        name: 'Dashboard',
        icon: 'dashboard',
        submenu: [
            { name: 'Overview', href: route('dashboard') },
            { name: 'District Statistics', href: route('dashboard') },
            { name: 'Recent Activities', href: route('dashboard') },
        ],
    },
    {
        name: 'Schools',
        icon: 'domain',
        submenu: [
            { name: 'All Schools', href: route('dashboard') },
            { name: 'School Performance', href: route('dashboard') },
            { name: 'School Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Teachers',
        icon: 'person_4',
        submenu: [
            { name: 'All Teachers', href: route('dashboard') },
            { name: 'Teacher Performance', href: route('dashboard') },
            { name: 'Teacher Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Exams',
        icon: 'assignment',
        submenu: [
            { name: 'All Exams', href: route('dashboard') },
            { name: 'Exam Analysis', href: route('dashboard') },
            { name: 'Exam Reports', href: route('dashboard') },
        ],
    },
    {
        name: 'Reports',
        icon: 'description',
        submenu: [
            { name: 'District Reports', href: route('dashboard') },
            { name: 'Performance Analytics', href: route('dashboard') },
            { name: 'Comparative Analysis', href: route('dashboard') },
        ],
    },
    {
        name: 'Profile',
        icon: 'account_circle',
        submenu: [
            { name: 'My Profile', href: route('profile.show') },
            { name: 'Account Settings', href: route('profile.show') },
        ],
    },
];

const currentNavigation = computed(() => {
    const userRole = page.props.auth.user?.role;
    
    if (userRole === 'admin') {
        return adminNavigation;
    } else if (userRole === 'school_manager') {
        return schoolManagerNavigation;
    } else if (userRole === 'district_manager') {
        return districtManagerNavigation;
    } else {
        // For teacher and student
        return navigation;
    }
});

const toggleMenu = (index) => {
    expandedMenus.value[index] = !expandedMenus.value[index];
};

const closeSidebar = () => {
    emit('toggle');
};
</script>

<template>
    <aside
        :class="[
            'fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-emerald-700 to-emerald-800 text-white shadow-lg transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col',
            open ? 'translate-x-0' : '-translate-x-full'
        ]"
    >
        <!-- Logo Section -->
        <div class="flex items-center justify-between gap-3 border-b border-emerald-600 px-6 py-4 flex-shrink-0">
            <div class="flex items-center gap-3">
                <img 
                    src="/letter-m_9326491.png" 
                    alt="Matokeo Logo" 
                    class="h-10 w-10 rounded-full object-cover"
                >
                <div>
                    <p class="font-bold text-white text-lg">Matokeo</p>
                    <p class="text-xs text-emerald-200">Exam System</p>
                </div>
            </div>
            <button
                @click="closeSidebar"
                class="lg:hidden text-emerald-200 hover:text-white"
            >
                <span class="material-icons">close</span>
            </button>
        </div>

        <!-- Navigation Section - Scrollable -->
        <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto">
            <div class="px-3 py-2 text-xs font-semibold text-emerald-200 uppercase tracking-wider">
                Navigation
            </div>
            <template v-for="(item, index) in currentNavigation" :key="item.name">
                <button
                    @click="toggleMenu(index)"
                    :class="[
                        'w-full flex items-center justify-between gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                        'text-emerald-100 hover:bg-emerald-600 hover:text-white'
                    ]"
                >
                    <div class="flex items-center gap-3">
                        <span class="material-icons text-xl flex-shrink-0">{{ item.icon }}</span>
                        <span>{{ item.name }}</span>
                    </div>
                    <span
                        v-if="item.submenu"
                        :class="[
                            'material-icons text-lg flex-shrink-0 transition-transform',
                            expandedMenus[index] ? 'rotate-180' : ''
                        ]"
                    >
                        expand_more
                    </span>
                </button>

                <!-- Submenu -->
                <Transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="opacity-0 -translate-y-1"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-1"
                >
                    <div v-if="expandedMenus[index] && item.submenu" class="space-y-1 pl-4">
                        <Link
                            v-for="subitem in item.submenu"
                            :key="subitem.name"
                            :href="subitem.href"
                            class="flex items-center gap-3 rounded-lg px-4 py-2 text-xs font-medium text-emerald-100 hover:bg-emerald-600 hover:text-white transition-colors"
                        >
                            <span class="w-1 h-1 rounded-full bg-emerald-300"></span>
                            <span>{{ subitem.name }}</span>
                        </Link>
                    </div>
                </Transition>
            </template>
        </nav>

        <!-- Logout Section - Fixed at bottom -->
        <div class="border-t border-emerald-600 px-3 py-4 flex-shrink-0">
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-emerald-100 hover:bg-emerald-600 hover:text-white transition-colors"
            >
                <span class="material-icons text-xl">logout</span>
                <span>Logout</span>
            </Link>
        </div>
    </aside>

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
            v-if="open"
            @click="closeSidebar"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        ></div>
    </Transition>
</template>

<style scoped>
/* Custom scrollbar for navigation */
nav::-webkit-scrollbar {
    width: 6px;
}

nav::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
}

nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>
