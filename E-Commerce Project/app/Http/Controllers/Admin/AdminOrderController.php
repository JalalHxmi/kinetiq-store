<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(25);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,shipped,delivered,cancelled']);
        $order->status = $request->status;
        if ($request->status === 'shipped') $order->shipped_at = now();
        if ($request->status === 'delivered') $order->delivered_at = now();
        if ($request->status === 'cancelled') $order->cancelled_at = now();
        $order->save();
        return back();
    }
}
