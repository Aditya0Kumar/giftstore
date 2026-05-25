<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $revenue = (float) Order::sum('total_amount');
        $orders = Order::with('user')->latest()->get();
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.dashboard', compact('revenue', 'orders', 'users'));
    }
}
