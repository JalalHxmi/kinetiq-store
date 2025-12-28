<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'paid')->sum('total');
        $ordersToday = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalSales', 'ordersToday', 'pendingOrders'));
    }
}
