<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $breadcrumbs = [
            ['title' => 'Dashboard', 'href' => '/dashboard'],
        ];
        $customerCountryData = [
            [
            'country'=> 'Bangladesh',
            'customers'=> 2500,
            'percentage'=> 60,
            'flag'=> 'assets/image/flag/bn.webp',
            ],
            [
                'country'=> 'USA',
                'customers'=> 4000,
                'percentage'=> 80,
                'flag'=> 'assets/image/flag/usa.webp',
            ]
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
            ['id' => 1001, 'customer' => 'Rahim Ali', 'amount' => 5200, 'status' => 'Shipped'],
            ['id' => 1002, 'customer' => 'Ahmad Gato', 'amount' => 3000, 'status' => 'Pending'],
            ['id' => 1003, 'customer' => 'Johan Mizzak', 'amount' => 2200, 'status' => 'Delivered'],
            ['id' => 1004, 'customer' => 'John Cattar', 'amount' => 300, 'status' => 'Delivered'],
        ];

        $chartsData = [
            'gauge' => [82, 18],
            'monthlySales' => [200, 400,600,700,200, 400,600,650,200, 400,600,800 ],
            'statistics' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','aug','sep','oct','nov','dec'],
                'sales' => [ 400, 420, 400,430 ,390, 410, 430, 380,420,390, 400,450],
                'revenue' => [600, 630, 590, 610, 580, 610, 570, 600, 590, 650,610, 600],
            ],
            'demographics' => [120, 90, 60, 30, 15],
        ];



        return Inertia::render('Dashboard', [
            'breadcrumbs' => $breadcrumbs,
            'customerMapData' => $customerMapData,
            'customerCountryData' => $customerCountryData,
            'orders' => $orders,
            'chartsData' => $chartsData,
            'customers'=>100000,
            'customerper'=>100,
            'totalorder'=>82000,
            'orderper'=>82,
            'target'=>20,
            'today'=>1.5,
            'revenue'=>16
        ]);
    }
}
