<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Controller থেকে ডাইনামিক ডেটা
        $breadcrumbs = [
            ['title' => 'Dashboard', 'href' => '/dashboard'],
        ];

        $customerMapData = [
            ['name' => 'Bangladesh', 'value' => 500],
            ['name' => 'India', 'value' => 90],
            ['name' => 'United States', 'value' => 65],
            ['name' => 'United Kingdom', 'value' => 35],
            ['name' => 'Canada', 'value' => 20],
            ['name' => 'Australia', 'value' => 10],
            ['name' => 'Germany', 'value' => 15],
            ['name' => 'China', 'value' => 50],
        ];

        $orders = [
            ['id' => 1001, 'customer' => 'Rahim Ali', 'amount' => 5200, 'status' => 'Shipped'],
            ['id' => 1002, 'customer' => 'Ahmad Gato', 'amount' => 3000, 'status' => 'Pending'],
            ['id' => 1003, 'customer' => 'Johan Mizzak', 'amount' => 2200, 'status' => 'Delivered'],
            ['id' => 1004, 'customer' => 'John Cattar', 'amount' => 300, 'status' => 'Delivered'],
        ];

        $chartsData = [
            'gauge' => [82, 18],
            'monthlySales' => [10000, 14000, 17000, 9000, 22000, 19000, 24000,10000, 14000, 17000, 9000, 22000, 19000, 24000],
            'statistics' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','aug','sep','oct','nov','dec'],
                'sales' => [2000, 1800, 2400, 3000, 3200, 2900,2000, 1800, 2400, 3000, 3200, 2900],
                'revenue' => [2500, 2000, 2600, 3500, 4000, 3100,2500, 2000, 2600, 3500, 4000, 3100],
            ],
            'demographics' => [120, 90, 60, 30, 15],
        ];



        return Inertia::render('Dashboard', [
            'breadcrumbs' => $breadcrumbs,
            'customerMapData' => $customerMapData,
            'orders' => $orders,
            'chartsData' => $chartsData,
            'customers'=>100000,
            'customerper'=>100,
            'totalorder'=>82000,
            'orderper'=>82,
            'target'=>100000,
            'today'=>3200,
            'revenue'=>82000
        ]);
    }
}
