<script setup lang="ts">
import { ref, watch } from 'vue';
import { use } from 'echarts/core';
import VChart from 'vue-echarts';
import {
    CanvasRenderer
} from 'echarts/renderers';
import {
    MapChart
} from 'echarts/charts';
import {
    TitleComponent,
    TooltipComponent,
    VisualMapComponent
} from 'echarts/components';
import * as echarts from 'echarts';
import worldMap from './echarts/map/json/world.json'

// Register modules
use([
    CanvasRenderer,
    MapChart,
    TitleComponent,
    TooltipComponent,
    VisualMapComponent
]);

echarts.registerMap('world', worldMap);

// props
const props = defineProps<{
    data: { name: string; value: number }[];
}>();

const chartOptions = ref({});

watch(
    () => props.data,
    () => {
        chartOptions.value = {
            title: {
                text: '',
                left: 'center',
                top: '10'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c} Customers'
            },
            visualMap: {
                min: 0,
                max: Math.max(...props.data.map(d => d.value)) || 100,
                left: 'left',
                bottom: '10',
                text: ['High', 'Low'],
                inRange: {
                    color: ['#d1fae5', '#10b981']
                },
                calculable: true
            },
            series: [
                {
                    name: 'Customers',
                    type: 'map',
                    map: 'world',
                    roam: true,
                    emphasis: { label: { show: true } },
                    data: props.data
                }
            ]
        };
    },
    { immediate: true }
);
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Customer Demographics (World Map)</h2>
        <v-chart class="h-[500px] w-full" :option="chartOptions" autoresize />
    </div>
</template>
