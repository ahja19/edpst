<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = max(0, Order::where('payment_status', 'paid')->where('status', '!=', 'cancelled')->sum('total') - (int) Setting::get('revenue_offset', 0));
        $totalUsers = User::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'pendingOrders',
            'recentOrders'
        ));
    }

    public function resetRevenue()
    {
        Setting::set('revenue_offset', (string) Order::where('payment_status', 'paid')->where('status', '!=', 'cancelled')->sum('total'));

        return back()->with('success', 'Pendapatan berhasil direset menjadi Rp 0.');
    }
}