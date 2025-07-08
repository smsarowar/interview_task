<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('home')" class="flex flex-col items-center gap-2 font-medium">
<!--                        <div class="mb-1 flex h-9 w-20 items-center justify-center rounded-md">-->
                            <img src="assets/image/logo.ico" alt="" class="w-[200px]">
<!--                            <AppLogoIcon class="size-9 fill-current text-[var(&#45;&#45;foreground)] dark:text-white" />-->
<!--                        </div>-->
<!--                        <span class="sr-only">{{ title }}</span>-->
                    </Link>

                </div>
                <div class="space-y-5">
                    <h1 class="text-3xl font-bold font-medium">{{ title }}</h1>
                    <p class="text-sm text-muted-foreground">{{ description }}</p>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
