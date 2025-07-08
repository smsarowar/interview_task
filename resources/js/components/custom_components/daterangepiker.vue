<script setup lang="ts">
import { ref } from 'vue';
import Flatpickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const dateRange = ref([]);
</script>

<template>
    <div class="relative w-full max-w-md">
<!--        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">-->
<!--            Select Date Range-->
<!--        </label>-->

        <!-- Calendar Icon (Right Side) -->
        <div class="pointer-events-none absolute inset-y-0 pl-2 flex items-center ">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <Flatpickr
            v-model="dateRange"
            :config="{
        mode: 'range',
        dateFormat: 'M-d'
      }"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-black items-center placeholder:pl-5"
            type="date"
            placeholder="5 mar to 6 jun"


        />
<!--        <div v-if="dateRange.length" class="mt-3 text-sm text-gray-600 dark:text-gray-400">-->
<!--            <strong>From:</strong> {{ dateRange[0] }}<br />-->
<!--            <strong>To:</strong> {{ dateRange[1] || '...' }}-->
<!--        </div>-->
    </div>
</template>
