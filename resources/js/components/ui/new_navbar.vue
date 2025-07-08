<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { LogOut, Settings } from 'lucide-vue-next';
import UserInfo from '@/components/UserInfo.vue';

const showDropdown = ref(false);

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

function logout() {

    window.location.href = route('logout');
}
</script>

<template>
    <div class="relative">
        <!-- Avatar Button -->
        <button @click="toggleDropdown" class="focus:outline-none rounded-full  dark:border-gray-600 ">
            <div class="flex w-full gap-2 justify-between items-center pr-10 ">
                <img
                    src="/assets/image/icon/user.png"
                    alt="img"
                    class="w-10 h-10 rounded-full object-cover"
                />
                <p>User</p>
            </div>
        </button>

        <!-- Dropdown -->
        <div
            v-if="showDropdown"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-lg z-50"
        >
            <ul class="py-1">
                <li>
                    <Link
                        :href="route('profile.edit')"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        Profile
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('profile.edit')"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        Setting
                    </Link>
                </li>
                <li>
                    <Link class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                          method="post"
                          :href="route('logout')" @click="handleLogout" as="button">
                        Log out
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>
