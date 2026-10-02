<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hanya ambil data orders, tanpa eager loading items atau product
        // Ini akan mengambil semua kolom dari tabel orders
        $orders = $user->orders()->latest()->get();

        return view('dashboard', compact('orders'));
    }
}