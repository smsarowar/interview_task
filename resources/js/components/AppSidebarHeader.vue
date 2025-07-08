<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import AppLogo from '@/components/AppLogo.vue';
import { Link } from '@inertiajs/vue3';
import NavUser from '@/components/NavUser.vue';
import { ref, onMounted } from 'vue';
import New_navbar from '@/components/ui/new_navbar.vue';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

// 🌙 Dark mode toggle
const isDark = ref(false);

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
});

function toggleDark() {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
}
</script>

<template>
    <header class="flex h-16 items-center justify-between border-b border-gray-200 px-4 md:px-6 bg-white dark:bg-gray-900 dark:border-gray-700">
        <!-- Left Section: Sidebar + Breadcrumbs + Search -->
        <div class="flex items-center gap-4 w-full">
            <SidebarTrigger class="-ml-1" />

            <!-- Breadcrumbs -->
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>

            <!-- Search (only on md and above) -->
            <div class="ml-4 w-full max-w-xs hidden md:block relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>

                <input
                    type="text"
                    placeholder="Search for type command"
                    class="w-full pl-10 rounded-md border border-gray-300 px-3 py-1.5 text-sm
               focus:border-blue-500 focus:ring focus:ring-blue-200
               dark:bg-gray-800 dark:text-white dark:border-gray-600
               dark:focus:border-blue-400"
                />
            </div>

            <!-- Mobile Logo (only on mobile) -->
            <div class="ml-4 md:hidden">
                <Link :href="route('dashboard')" class="flex items-center">
                    <AppLogo class="h-8" />
                </Link>
            </div>
        </div>

        <!-- Right Section: Notification + DarkMode + User -->
        <div class="flex items-center gap-6">
            <!-- Dark Mode Toggle -->
            <button @click="toggleDark" class="focus:outline-none ">
                <svg
                    v-if="isDark"
                    class="w-6 h-6 text-gray-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17.293 14.293A8 8 0 019.707 6.707a8.001 8.001 0 107.586 7.586z"
                    />
                </svg>
                <svg
                    v-else
                    class="w-6 h-6 text-gray-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 3v1m0 16v1m8.66-10.66l-.707.707M4.047 19.95l-.707-.707M21 12h-1M4 12H3m16.66 4.66l-.707-.707M4.047 4.05l-.707.707"
                    />
                </svg>
            </button>
            <!-- Notification -->
            <button class="relative focus:outline-none ">
                <svg
                    class="w-6 h-6 text-gray-600 dark:text-gray-300"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    />
                </svg>
                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
            </button>


            <!-- User Avatar + Dropdown -->
            <new_navbar></new_navbar>
        </div>
    </header>
</template>
