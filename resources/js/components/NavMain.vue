<!--<script setup lang="ts">-->
<!--import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';-->
<!--import { type NavItem } from '@/types';-->
<!--import { Link, usePage } from '@inertiajs/vue3';-->

<!--defineProps<{-->
<!--    items: NavItem[];-->
<!--}>();-->

<!--const page = usePage();-->
<!--</script>-->

<!--<template>-->
<!--    <SidebarGroup class="px-2 py-0">-->
<!--        <SidebarGroupLabel>Platform</SidebarGroupLabel>-->
<!--        <SidebarMenu>-->
<!--            <SidebarMenuItem v-for="item in items" :key="item.title">-->
<!--                <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">-->
<!--                    <Link :href="item.href">-->
<!--                        <component :is="item.icon" />-->
<!--                        <span>{{ item.title }}</span>-->
<!--                    </Link>-->
<!--                </SidebarMenuButton>-->
<!--            </SidebarMenuItem>-->
<!--        </SidebarMenu>-->
<!--    </SidebarGroup>-->
<!--</template>-->


<script setup lang="ts">
import { ref } from 'vue';
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{ items: NavItem[] }>();

const page = usePage();
const openMenus = ref<string[]>([]);

const toggleMenu = (title: string) => {
    if (openMenus.value.includes(title)) {
        openMenus.value = openMenus.value.filter(t => t !== title);
    } else {
        openMenus.value.push(title);
    }
};
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <template v-if="item.children && item.children.length">
                    <SidebarMenuButton
                        as-child
                        @click="toggleMenu(item.title)"
                        class="cursor-pointer flex items-center justify-between"
                        :tooltip="item.title"
                    >
                        <div class="flex items-center w-full gap-2">
                            <component :is="item.icon" />
                            <span class="flex-1">{{ item.title }}</span>
                            <svg
                                :class="{ 'rotate-90': openMenus.includes(item.title) }"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </SidebarMenuButton>

                    <SidebarMenu v-show="openMenus.includes(item.title)" class="ml-6 mt-1 space-y-1">
                        <SidebarMenuItem v-for="sub in item.children" :key="sub.title">
                            <SidebarMenuButton as-child :is-active="sub.href === page.url">
                                <Link :href="sub.href">
                                    <span>{{ sub.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </template>

                <template v-else>
                    <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">
                        <Link :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </template>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
