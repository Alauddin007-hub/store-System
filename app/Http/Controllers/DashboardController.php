<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if(Auth::user()->user_type_id == 1)
        {
             $customer = Customer::count();

            $currentDate = getdate();
            $date = $currentDate['mday'];

            $todaySales = Sale::whereDay('created_at', $date)->get();
            $todaySales = $todaySales->count();

            $totalPrice = 0;

            $Total_Income = Sale::all();

            foreach ($Total_Income as $income) {
                $totalPrice += $income['total_price'];
            }

            $todaySale = Sale::whereDay('created_at', $date)->get();

            $totalEarn = 0;
            foreach ($todaySale as $income) {
                $totalEarn += $income['total_price'];
            }

            $stock = Stock::get();
            $total_stock = 0;
            foreach ($stock as $item) {
                $total_stock += $item['total_quantity'];
            }

        // $TotalSales = Employee::count();
            // dd($request->all());

            return view('backend.dashboard.super_admin', compact('customer', 'todaySales', 'totalPrice', 'totalEarn', 'total_stock'));
        }
        elseif(Auth::user()->user_type_id == 2)
        {
            return view('backend.dashboard.admin');
        }
        elseif(Auth::user()->user_type_id == 3)
        {
            return view('backend.dashboard.normal_user');
        }
    }

    
}
