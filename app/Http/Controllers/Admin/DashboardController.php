<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTokens = PersonalAccessToken::count();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalTokens', 'recentUsers'));
    }
}
