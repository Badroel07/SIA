<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCashierController extends Controller
{
    public function index()
    {
        return view('cashier.index');
    }
}
