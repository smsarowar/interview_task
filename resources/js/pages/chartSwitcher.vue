<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-10 flex-col md:flex-row gap-2 ">
            <div class="text-black">
                <h3 class="font-bold text-2xl">Statistics</h3>
                <p>Target you've set for each month</p>
            </div>
           <div class="flex gap-1">
               <div class="mb-4 flex gap-2">
                   <button
                       v-for="option in ['overview', 'sales', 'revenue']"
                       :key="option"
                       @click="selectedView = option"
                       :class="[
                  'px-4 py-1 text-sm rounded-md',
                  selectedView === option ? 'bg-white text-black' : 'bg-green-50 text-black'
                ]"
                   >
                       {{ option.charAt(0).toUpperCase() + option.slice(1) }}
                   </button>
               </div>
               <div>
                   <daterangepiker></daterangepiker>
<!--                   <input type="dateRange" class="border-1  rounded-lg text-black p-2">-->
               </div>
           </div>
        </div>
        <canvas id="chartSwitcherCanvas"></canvas>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import Chart from 'chart.js/auto';
import Daterangepiker from '@/components/custom_components/daterangepiker.vue';

const props = defineProps<{
    salesData: number[];
    revenueData: number[];
    labels: string[];
}>();

const selectedView = ref<'overview' | 'sales' | 'revenue'>('overview');
let chartInstance: Chart | null = null;

const renderChart = () => {
    const ctx = document.getElementById('chartSwitcherCanvas') as HTMLCanvasElement;
    if (!ctx) return;
    if (chartInstance) chartInstance.destroy();

    const datasets = [];

    if (selectedView.value === 'overview' || selectedView.value === 'sales') {
        datasets.push({
            label: 'Sales',
            data: props.salesData,
            borderColor: '#c5d4cf',
            tension: 0.3,
            fill: false
        });
    }

    if (selectedView.value === 'overview' || selectedView.value === 'revenue') {
        datasets.push({
            label: 'Revenue',
            data: props.revenueData,
            borderColor: '#3b82f6',
            tension: 0.3,
            fill: false
        });
    }

    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: props.labels,
            datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.raw}`
                    }
                }
            },
            scales: {
                x:{
                  grid:{
                      display:false
                  }
                },
                y: {
                    grid:{
                        display:false
                    },
                    beginAtZero: true,
                    ticks: {
                        callback: value => `${value}`
                    }
                }
            }
        }
    });
};

onMounted(renderChart);
watch(selectedView, renderChart);
onBeforeUnmount(() => {
    if (chartInstance) chartInstance.destroy();
});
</script>

<style scoped>
canvas {
    width: 100% !important;
    height: 350px !important;
}
</style>
