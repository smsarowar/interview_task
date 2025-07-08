<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Chart from 'chart.js/auto';
import chartSwitcher from './chartSwitcher.vue';
import CustomerWorldMap from './CustomerMap.vue';
import type { BreadcrumbItem } from '@/types';

const page = usePage();
const breadcrumbs = computed(() => page.props.breadcrumbs as BreadcrumbItem[]);
const customerMapData = computed(() => page.props.customerMapData);
const customerCountryData = computed(() => page.props.customerCountryData);
const orders = computed(() => page.props.orders);
const chartsData = computed(() => page.props.chartsData);
const totalCustomer = computed(() => page.props.customers);
const totalCustomerper = computed(() => page.props.customerper);
const totalOrder = computed(() => page.props.totalorder);
const totalOrderper = computed(() => page.props.orderper);
const target = computed(() => page.props.target);
const today = computed(() => page.props.today);
const revenue = computed(() => page.props.revenue);

const statusColor = (status: string) => {
    switch (status) {
        case 'Pending':
            return 'text-yellow-500';
        case 'Shipped':
            return 'text-blue-500';
        case 'Delivered':
            return 'text-green-500';
        default:
            return 'text-gray-400';
    }
};

onMounted(() => {
    new Chart(document.getElementById('targetGauge') as HTMLCanvasElement, {
        type: 'doughnut',
        data: {
            labels: ['Achieved', 'Remaining'],
            datasets: [
                {
                    data: chartsData.value.gauge,
                    backgroundColor: ['#3b82f6', '#e5e7eb'],
                    borderWidth: 0,
                    cutout: '90%',
                    borderRadius: 6,
                    circumference: 200,
                    rotation: 260,
                },
            ],
        },
        options: {
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
                centerText: {
                    percentage: `${chartsData.value.gauge[0]}%`,
                    subtitle: `+10%`,
                    label: '',
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
                    // const percent = pluginOpts.percentage || '';
                    const subtitle = chart.options.plugins.centerText.subtitle;
                    ctx.save();
                    ctx.font = 'bold 50px sans-serif';
                    ctx.fillStyle = '#111827';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'top';
                    ctx.fillText(percent, width / 2, height / 2 - 10);

                    // Draw subtitle (below percentage)
                    ctx.font = '20px sans-serif';
                    ctx.fillStyle = '#61c373';

                    ctx.fillText(subtitle, width / 2, height / 2 + 50);

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
                    barThickness: 20,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
    <AppLayout>
        <div class="space-y-6 p-6">
            <!-- Monthly Summary Cards -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="space-y-4 md:col-span-2">
                    <!-- Cards -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Customer -->
                        <div class="relative flex flex-col justify-between rounded-lg bg-white p-4 shadow">
                            <div class="ml-5 flex flex-col justify-center gap-8">
                                <div class="mx-3 mt-10 w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3
                                352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"
                                        />
                                    </svg>
                                </div>
                                <p class="text-md font-bold text-black text-gray-400">Customers</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="ml-5 text-3xl font-bold text-black">{{ totalCustomer }}</p>
                                <p class="absolute right-3 mr-5 text-lg text-gray-500 text-green-500">
                                    <span class="p-1"> <i class="fa-solid fa-arrow-up"></i></span>{{ totalCustomerper }}%
                                </p>
                            </div>
                        </div>

                        <!-- Orders -->
                        <div class="relative flex flex-col justify-between rounded-lg bg-white p-4 shadow">
                            <div class="ml-5 flex flex-col justify-center gap-8">
                                <div class="mx-3 mt-8 w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path
                                            d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32
                                    354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z"
                                        />
                                    </svg>
                                </div>
                                <p class="text-md pb-4 font-bold text-black text-gray-400">Orders</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="ml-5 text-3xl font-bold text-black">{{ totalOrder }}</p>
                                <p class="absolute right-3 mr-5 text-lg text-gray-500 text-red-500">
                                    <span class="p-1"> <i class="fa-solid fa-arrow-down"></i></span>{{ totalOrderper }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Sales Chart -->
                    <div class="h-[40 0px] relative max-h-[350px] w-full rounded-lg bg-white p-6 shadow">
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-black">Monthly Sales</h2>
                            <button class="text-gray-500 hover:text-black focus:outline-none">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"
                                    />
                                </svg>
                            </button>
                        </div>

                        <div class="relative h-[240px] w-full">
                            <canvas id="monthlySalesChart" class="absolute top-0 left-0 h-full w-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gauge Chart -->
                <div class="flex flex-col justify-between rounded-lg bg-white shadow">
                    <div class="flex justify-between px-6 py-4">
                        <div class="">
                            <h2 class="mb-2 pl-0 text-lg font-semibold text-black">Monthly Target</h2>
                            <p class="text-gray-500">Target you've set for each month</p>
                        </div>
                        <button class="text-gray-500 hover:text-black focus:outline-none">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"
                                />
                            </svg>
                        </button>
                    </div>

                    <canvas id="targetGauge" class="mx-auto" width="280" height="180"></canvas>

                    <p class="mb-5 px-6 text-wrap text-gray-500">You earn $3287 today, its higher than last month. Keep up your good work!</p>

                    <div class="flex items-center justify-between rounded-b-md bg-[#F2F4F7] p-6">
                        <div class="flex flex-col">
                            <p class="text-lg text-gray-500">Target</p>
                            <p class="text-2xl font-bold text-gray-800">
                                ৳{{ target }}K <span class="text-red-500"><i class="fa-solid fa-arrow-down"></i></span>
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-lg text-gray-500">Revenue</p>
                            <p class="text-2xl font-bold text-gray-800">
                                ৳{{ revenue }}K <span class="text-green-500"><i class="fa-solid fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-lg text-gray-500">Today</p>
                            <p class="text-2xl font-bold text-gray-800">
                                ৳{{ today }}K <span class="text-green-500"><i class="fa-solid fa-arrow-up"></i></span>
                            </p>
                        </div>
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

            <div class="flex w-full flex-col gap-5 md:flex-row">
                <div class="flex flex-col bg-white p-6 md:w-1/3">
                    <div class="mb-4 flex w-full items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-black">Customer Demographics</h2>
                            <p class="text-gray-500">Number of customer based on country</p>
                        </div>
                        <button class="text-gray-500 hover:text-black focus:outline-none">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 4a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="grid h-[200px] w-full grid-cols-1 rounded-2xl border-2 border-gray-50 bg-red-400 shadow-2xl">
                        <CustomerWorldMap :data="customerMapData" />
                    </div>
                    <div class="mt-4 space-y-4">
                        <!-- Repeat this div for each country -->
                        <div v-for="(country, index) in customerCountryData" :key="index" class="flex items-center justify-between gap-4">
                            <!-- Country Flag (circle) -->
                            <div class="h-10 w-10 overflow-hidden rounded-full border border-gray-300">
                                <img :src="country.flag" alt="Bangladesh" class="h-full w-full object-cover" />
                            </div>

                            <!-- Country Info -->
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-gray-800">{{ country.country }}</h3>
                                <p class="text-xs text-gray-500">{{ country.customers }} customers</p>
                            </div>

                            <!-- Progress Bar -->
                            <div class="w-1/3">
                                <div class="h-2 rounded-full bg-gray-200">
                                    <div class="h-2 rounded-full bg-green-500" style="width: 60%"></div>
                                </div>
                                <p class="mt-1 text-right text-xs text-gray-600">{{ country.percentage }}%</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow md:w-2/3 text-black">
                    <div class="flex justify-between flex-col md:flex-row">
                        <h2 class="mb-4 text-lg font-semibold">Recent Orders</h2>
                        <div class="flex gap-4 ">
                            <button class="rounded-md border-1 border-gray-200 p-3 shadow-md  bg-[#F2F4F7]"><span class="pr-3"><i class="fa-solid fa-filter"></i></span>Filter</button>
                            <button class="rounded-md border-1 border-gray-200 p-3 shadow-md bg-[#F2F4F7]">See All</button>
                        </div>
                    </div>

<!--                    <table class="w-full text-left">-->
<!--                        <thead class="border-b text-sm text-gray-500">-->
<!--                            <tr>-->
<!--                                <th class="py-2">Order ID</th>-->
<!--                                <th class="py-2">Customer</th>-->
<!--                                <th class="py-2">Amount</th>-->
<!--                                <th class="py-2">Status</th>-->
<!--                            </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                            <tr v-for="order in orders" :key="order.id" class="border-b text-sm">-->
<!--                                <td class="py-2">#{{ order.id }}</td>-->
<!--                                <td class="py-2">{{ order.customer }}</td>-->
<!--                                <td class="py-2">৳{{ order.amount }}</td>-->
<!--                                <td class="py-2">-->
<!--                                    <span :class="statusColor(order.status)" class="px-2 py-1 text-xs font-semibold">-->
<!--                                        {{ order.status }}-->
<!--                                    </span>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </tbody>-->
<!--                    </table>-->

                    <table class="w-full text-left mt-5">
                        <thead class="border-b text-sm text-gray-500">
                        <tr>
                            <th class="py-2 hidden md:block ">Order ID</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2 hidden md:block">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orders" :key="order.id" class="border-b text-sm">
                            <td class="py-2 hidden md:block">#{{ order.id }}</td>
                            <td class="py-2">{{ order.customer }}</td>
                            <td class="py-2">৳{{ order.amount }}</td>
                            <td class="py-2 hidden md:block">
                                    <span :class="statusColor(order.status)" class="px-2 py-1 text-xs font-semibold">
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
