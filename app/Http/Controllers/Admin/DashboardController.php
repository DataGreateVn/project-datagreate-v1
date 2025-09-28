<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productCount' => 0,
            'postCount'    => 0,
            'ordersToday'  => 0,
        ]);
    }
}
