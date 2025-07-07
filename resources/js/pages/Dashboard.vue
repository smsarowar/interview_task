<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Chart from 'chart.js/auto';
import chartSwitcher from './chartSwitcher.vue';
import CustomerWorldMap from './CustomerMap.vue';
import type { BreadcrumbItem } from '@/types';

// Inertia থেকে ডেটা আনছি
const page = usePage();
const breadcrumbs = computed(() => page.props.breadcrumbs as BreadcrumbItem[]);
const customerMapData = computed(() => page.props.customerMapData);
const orders = computed(() => page.props.orders);
const chartsData = computed(() => page.props.chartsData);
const totalCustomer = computed(() => page.props.customers);
const totalCustomerper = computed(() => page.props.customerper);
const totalOrder = computed(() => page.props.totalorder);
const totalOrderper = computed(() => page.props.orderper);
const target = computed(() => page.props.target);
const today = computed(() => page.props.today);
const revenue = computed(() => page.props.revenue);

// অর্ডার স্ট্যাটাস অনুযায়ী কালার
const statusColor = (status: string) => {
    switch (status) {
        case 'Pending':
            return 'bg-yellow-500';
        case 'Shipped':
            return 'bg-blue-500';
        case 'Delivered':
            return 'bg-green-500';
        default:
            return 'bg-gray-400';
    }
};

// চার্ট ড্র করবো
onMounted(() => {
    new Chart(document.getElementById('targetGauge') as HTMLCanvasElement, {
        type: 'doughnut',
        data: {
            labels: ['Achieved', 'Remaining'],
            datasets: [
                {
                    data: chartsData.value.gauge,
                    backgroundColor: ['#10b981', '#e5e7eb'],
                    borderWidth: 0,
                    cutout: '85%',
                    circumference: 180,
                    rotation: 270,
                },
            ],
        },
        options: {
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
                centerText: {
                    percentage: `${chartsData.value.gauge[0]}%`,
                    label: [
                    ]
                },
            },
        },
        plugins: [
            {
                id: 'centerText',
                beforeDraw(chart) {
                    const { width, height } = chart;
                    const ctx = chart.ctx!;
                    const percent = chart.options.plugins.centerText.percentage;
                    ctx.save();
                    ctx.font = 'bold 22px sans-serif';
                    ctx.fillStyle = '#111827';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'top';
                    ctx.fillText(percent, width / 2, height / 2 - 10);
                    ctx.restore();
                },
                afterDraw(chart) {
                    const { width, height } = chart;
                    const ctx = chart.ctx!;
                    const label = chart.options.plugins.centerText.label;
                    ctx.save();
                    ctx.font = '14px sans-serif';
                    ctx.fillStyle = '#6b7280';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'top';
                    ctx.fillText(label, width / 2, height - 20);
                    ctx.restore();
                },
            },
        ],
    });

    new Chart(document.getElementById('monthlySalesChart') as HTMLCanvasElement, {
        type: 'bar',
        data: {
            labels: chartsData.value.statistics.labels,
            datasets: [
                {
                    label: 'Sales',
                    data: chartsData.value.monthlySales,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6,
                    barThickness: 30,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => `৳${value}`,
                    },
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `৳${context.raw}`,
                    },
                },
            },
        },
    });
});
</script>

<template>
<!--    <Head title="Dashboard" />-->
    <AppLayout >
        <div class="space-y-6 p-6">

            <!-- Monthly Summary Cards -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="space-y-4 md:col-span-2">
                    <!-- Cards -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Customer -->
                        <div class="relative flex h-32 flex-col justify-between rounded-lg bg-white p-4 shadow">
                            <div>
                                <svg class="mb-2 h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z"
                                    />
                                </svg>
                                <p class="text-2xl font-bold text-black">Customer</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xl font-bold text-blue-600">৳{{ totalCustomer }}</p>
                                <p class="absolute right-3 text-lg text-gray-500">{{ totalCustomerper }}%</p>
                            </div>
                        </div>

                        <!-- Orders -->
                        <div class="relative flex h-32 flex-col justify-between rounded-lg bg-white p-4 shadow">
                            <div>
                                <svg class="mb-2 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
                                </svg>
                                <p class="text-2xl font-bold text-black">Orders</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xl text-green-600">৳{{ totalOrder }}</p>
                                <p class="absolute right-3 text-lg text-gray-500">{{ totalOrderper }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Sales Chart -->
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h2 class="mb-4 text-lg font-semibold">Monthly Sales</h2>
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>

                <!-- Gauge Chart -->
                <div class="rounded-lg bg-white p-6 text-center shadow">
                    <h2 class="mb-4 text-lg font-semibold text-black">Monthly Target</h2>
                    <p class="text-gray-500">Target you've set for each month</p>
                    <canvas id="targetGauge" class="mx-auto" width="280" height="180"></canvas>
                    <p class="text-gray-500 text-wrap mb-10">You earn $3287 today, its higher than last month. Keep up your good work!</p>
                    <div class="mt-4 flex justify-between text-sm text-gray-600 ">
                        <p>
                            🎯 Target: <span class="font-bold text-gray-800">৳{{ target }}</span>
                        </p>
                        <p>
                            💰 Revenue: <span class="font-bold text-green-600">৳{{ revenue }}</span>
                        </p>
                        <p>📅 Today: <span class="font-bold text-indigo-600">৳{{ today }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Statistics Line Chart -->
            <chartSwitcher
                :sales-data="chartsData.statistics.sales"
                :revenue-data="chartsData.statistics.revenue"
                :labels="chartsData.statistics.labels"
            />

            <!-- World Map & Orders -->
            <div class="grid grid-cols-1 gap-6 text-black md:grid-cols-2">
                <CustomerWorldMap :data="customerMapData" />

                <div class="rounded-lg bg-white p-6 shadow">
                    <div class="flex justify-between items-center">
                        <h2 class="mb-4 text-lg font-semibold">Recent Orders</h2>
                        <div class="flex gap-4 ">
                            <button class=" p-3 border-2 rounded-md">Filter</button>
                            <button class=" p-3 border-2 rounded-md">See All</button>
                        </div>
                    </div>

                    <table class="w-full text-left">
                        <thead class="border-b text-sm text-gray-500">
                            <tr>
                                <th class="py-2">Order ID</th>
                                <th class="py-2">Customer</th>
                                <th class="py-2">Amount</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id" class="border-b text-sm">
                                <td class="py-2">#{{ order.id }}</td>
                                <td class="py-2">{{ order.customer }}</td>
                                <td class="py-2">৳{{ order.amount }}</td>
                                <td class="py-2">
                                    <span :class="statusColor(order.status)" class="rounded-full px-2 py-1 text-xs text-white">
                                        {{ order.status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
