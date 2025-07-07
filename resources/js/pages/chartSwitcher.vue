<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="mb-4 flex gap-2">
            <button
                v-for="option in ['overview', 'sales', 'revenue']"
                :key="option"
                @click="selectedView = option"
                :class="[
          'px-4 py-1 text-sm rounded border',
          selectedView === option ? 'bg-blue-600 text-white' : 'bg-white text-gray-600'
        ]"
            >
                {{ option.charAt(0).toUpperCase() + option.slice(1) }}
            </button>
        </div>
        <canvas id="chartSwitcherCanvas"></canvas>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import Chart from 'chart.js/auto';

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
            borderColor: '#34d399',
            backgroundColor: 'rgba(52,211,153,0.2)',
            tension: 0.3,
            fill: true
        });
    }

    if (selectedView.value === 'overview' || selectedView.value === 'revenue') {
        datasets.push({
            label: 'Revenue',
            data: props.revenueData,
            borderColor: '#fbbf24',
            backgroundColor: 'rgba(251,191,36,0.2)',
            tension: 0.3,
            fill: true
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
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: ctx => `৳${ctx.raw}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => `৳${value}`
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
