<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('backend.report.reportSales', ['sales' => []]);
    }

    public function generate(Request $request)
    {
        $query = Sale::query();
    
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
    
        if ($request->filled('book')) {
            $query->whereHas('details.book', function($q) use ($request) {
                $q->where('book_bangla_name', 'like', '%' . $request->book . '%')
                  ->orWhere('book_english_name', 'like', '%' . $request->book . '%');
            });
        }
    
        if ($request->filled('invoice_id')) {
            $query->where('id', $request->invoice_id);
        }
    
        $sales = $query->get();
        
        // Debugging
        // dd($request->all(), $query->toSql(), $sales);
    
        return view('backend.report.salesReportResult', compact('sales'));
    }
    
}

