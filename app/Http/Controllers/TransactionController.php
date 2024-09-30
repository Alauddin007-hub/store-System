<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SaleDetails;
use App\Models\Stock_Detail;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Stock;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Kwn\NumberToWords\NumberToWords;
use NumberToWords\NumberToWords as NumberToWordsNumberToWords;
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('id', 'DESC')->get();

        foreach ($sales as $sale) {
            $sale->created_at_formatted = Carbon::parse($sale->created_at)->format('d/m/Y');
        }

        return view('backend.sale.index', compact('sales'));
    }

    public function todayTransaction()
    {
        $currentDate = now()->toDateString();

        $sales = Sale::whereDate('created_at', $currentDate)
            ->with('customer')
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.sale.todaySale', compact('sales'));
    }


    public function searchBooks(Request $request)
    {
        $query = $request->get('query');
        $stockDetails = Stock_Detail::whereHas('book', function ($q) use ($query) {
            $q->where('book_bangla_name', 'LIKE', "%{$query}%")
                ->orWhere('book_english_name', 'LIKE', "%{$query}%");
        })->with('book')
            ->where('quantity', '>', 0)  // Only get books that are in stock
            ->get();

        return response()->json($stockDetails);
    }

    public function create()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        $books = Book::whereHas('stock_detail', function ($query) {
            $query->where('quantity', '>', 0);
        })->orderBy('id', 'DESC')->get();
        $stockDetails = Stock_Detail::with('book')->where('quantity', '>', 0)->get();

        return view('backend.sale.pos_application', compact('customers', 'stockDetails', 'books'));
    }

    public function store(Request $request)
    {
        $books = $request->input('books');

        $request->validate([
            'books' => 'required|array',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.subtotal' => 'required|numeric|min:0',
            // 'customer_name' => 'required|string|max:255',
        ]);

        $customerId = $request->input('customer_id');
        $check = Customer::where('id', $customerId)->first();

        if (!$check) {
            $request->validate([
                'customerName' => 'required|string|max:255',
                'phone' => 'required|max:11|unique:customers',
            ]);

            $customer = Customer::create([
                'name' => $request->customerName,
                'phone' => $request->phone,
                'address' => $request->address,
                'created_by' => auth()->id(),
            ]);
            
            $customerId = $customer->id;
            // dd($customer);
        }

        // $invoice = IdGenerator::generate(['table' => 'sales', 'field' => 'invoiceID', 'length' => 12, 'prefix' => 'INVO#']);

        // Get the last invoice ID from the database
        $lastInvoice = Sale::latest()->first();

        if ($lastInvoice) {
            // Extract the numeric part from the last invoice (e.g., INVO#00099 -> 99)
            $lastInvoiceNumber = intval(str_replace('INVO#', '', $lastInvoice->invoiceID));

            // Increment the number for the new invoice
            $newInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            // If no invoices exist, start from 1
            $newInvoiceNumber = 1;
        }

        // Construct the new invoice ID (e.g., INVO#00100)
        $invoice = 'INVO#' . $newInvoiceNumber;



        $totalQuantity = 0;
        $totalPrice = 0;
        $availableBooks = [];
        $errors = [];

        // Check stock availability first
        foreach ($books as $book) {
            $totalStock = Stock::where('book_id', $book['book_id'])->sum('total_quantity');
            $totalStockDetails = Stock_Detail::where('book_id', $book['book_id'])->where('id', $book['id'])->sum('quantity');

            if ($totalStock < $book['quantity'] || $totalStockDetails < $book['quantity']) {
                $errors[] = $book['book_name'] . 'এই বইয়ের জন্য পর্যাপ্ত স্টক নেই';
            } else {
                $availableBooks[] = $book;
            }
        }

        // If there are errors, redirect back with error messages
        if (!empty($errors)) {
            return redirect()->back()->withErrors(['message' => $errors]);
        }

        try {
            DB::beginTransaction();

            foreach ($availableBooks as $book) {
                // Deduct from stock_details table
                $stockDetail = Stock_Detail::where('book_id', $book['book_id'])->where('id', $book['id'])->first();
                if ($stockDetail) {
                    $stockDetail->quantity -= $book['quantity'];
                    $stockDetail->save();
                }

                // Update the total stock table
                $stock = Stock::where('book_id', $book['book_id'])->first();
                if ($stock) {
                    $stock->total_quantity -= $book['quantity'];
                    $stock->total_price -= $book['quantity'] * $book['price'];
                    $stock->save();
                }

                $totalQuantity += $book['quantity'];
                $totalPrice += $book['subtotal'];

                // $parcent ='discount' => $request->input('discount', 0);
            }
            if ($request->input('discount', 0) == null && $request->input('discountForAmount') == null) {
            }

            // $data = [
            //     'total_quantity' => $totalQuantity,
            //     'total_price' => $totalPrice,
            //     'invoiceID' => $invoice,
            //     'discount' => $request->input('discount', 0),
            //     'discount_for_amount' => $request->input('discountForAmount', 0),
            //     'otherCost' => $request->input('otherCost', 0),
            //     'customer_id' => $customerId,
            //     'user_id' => auth()->id(),
            // ];

            // dd($data);

            $sale = Sale::create([
                'total_quantity' => $totalQuantity,
                'total_price' => $totalPrice,
                'invoiceID' => $invoice,
                'discount' => $request->input('discount', 0),
                'discount_for_amount' => $request->input('discountForAmount', 0),
                'otherCost' => $request->input('otherCost', 0),
                'customer_id' => $customerId,
                'user_id' => auth()->id(),
            ]);

            foreach ($availableBooks as $book) {
                SaleDetails::create([
                    'stock_details_id' => $book['id'],
                    'book_id' => $book['book_id'],
                    'sales_id' => $sale->id,
                    // 'customer_id' => $customerId,
                    'discount' => $book['discount'],
                    'quantity' => $book['quantity'],
                    'price' => $book['price'],
                    'subtotal' => $book['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.print_show')->with('success', 'বিক্রয় সফল হয়েছে ।');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $sale = Sale::with('customer', 'details.book')->findOrFail($id);
        $customers = Customer::orderBy('id', 'DESC')->get();
        $books = Book::whereHas('stock_detail', function ($query) {
            $query->where('quantity', '>', 0);
        })->orderBy('id', 'DESC')->get();
        $stockDetails = Stock_Detail::with('book')->where('quantity', '>', 0)->get();
        return view('backend.sale.edit_searchDrop_transection', compact('sale', 'customers', 'stockDetails', 'books'));
        // return view('backend.sale.edit_searchDrop_transection', compact('customers', 'stockDetails', 'books', 'salesDetails'));
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // Ensure the request data is correctly validated
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.price' => 'required|numeric|min:0',
            'books.*.discount' => 'required|numeric|min:0|max:100',
        ]);

        $totalQuantity = 0;
        $totalPrice = 0;

        // Update the sale details and stock details
        foreach ($request->books as $book) {
            $stockDetail = Stock_Detail::with('book')->where('quantity', '>', 0)->first();
            dd($stockDetail);
            $saleDetail = SaleDetails::where('book_id', $book['book_id'])->where('id', $book['detail_id'])->first();

            // dd($stockDetail);

            // Ensure the quantities are correctly updated
            if ($book['quantity'] > $saleDetail->quantity) {

                $deduct = $book['quantity'] - $saleDetail->quantity;
                $stockDetail->quantity -= $deduct;
                $stockDetail->save();
                $stock = Stock::where('book_id', $book['book_id'])->first();
                $stock->total_quantity -= $deduct;
                $stock->total_price -= $deduct * $book['price'];
                $stock->save();
            } elseif ($book['quantity'] < $saleDetail->quantity) {
                $deduct = $saleDetail->quantity - $book['quantity'];
                $stockDetail->quantity += $deduct;
                $stockDetail->save();
                $stock = Stock::where('book_id', $book['book_id'])->first();
                $stock->total_quantity += $deduct;
                $stock->total_price += $deduct * $book['price'];
                $stock->save();
            }


            // Update the sale detail
            $saleDetail->update([
                'quantity' => $book['quantity'],
                'price' => $book['price'],
                'discount' => $book['discount'],
                'subtotal' => ($book['quantity'] * $book['price']) * ((100 - $book['discount']) / 100),
            ]);


            $totalQuantity += $book['quantity'];
            $totalPrice += $book['subtotal'];
            // dd($totalQuantity, $totalPrice);
        }

        // Retrieve and update the sale
        $sale = Sale::findOrFail($id);
        $sale->customer_id = $request->customer_id;
        $sale->discount = $request->discount;
        $sale->total_quantity = $totalQuantity;
        $sale->total_price = $totalPrice;
        $sale->save();

        return redirect()->route('transactions.index')->with('success', 'লেনদেন সফলভাবে আপডেট করা হয়েছে ।');
    }



    public function print_show()
    {
        $sale = Sale::orderBy('id', 'DESC')->first();

        if ($sale) {
            $sale_id = $sale->id;
            $details = SaleDetails::where('sales_id', $sale_id)->get(); // Get all sale details
        } else {
            $details = collect(); // Empty collection
        }

        return view('backend.invoice.finished', compact('details', 'sale'));
    }

    public function invoice(Request $request, $id)
    {
        // Get the sale data
        $sale = Sale::where('id', $request->id)->first();

        if ($sale) {
            $sale->created_at_formatted = Carbon::parse($sale->created_at)->format('d/m/Y');
        }

        // Get sale details
        $details = SaleDetails::where('sales_id', $request->id)->get();

        // Calculate the total amount
        $total = $sale->total_price * ((100 - $sale->discount) / 100) - $sale->discount_for_amount + $sale->otherCost;

        $numberToWords = new NumberToWordsNumberToWords();
        // dd($numberToWords);

        // Convert total to words using NumberToWords
        // $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en'); // 'en' for English
        $totalInWords = $numberTransformer->toWords($total);

        // Get customer details
        $customer = Customer::where('id', $sale->customer_id)->first();

        // Get current date
        $currentDate = Carbon::now()->toFormattedDateString();

        return view('backend.invoice.invoice', compact('details', 'currentDate', 'sale', 'customer', 'totalInWords'));
    }





    public function reportPDF(Request $request)
    {
        $result = $request->id;

        // Find the sale by ID
        $sale = Sale::where('id', $result)->first();
        if (!$sale) {
            return redirect()->back()->withErrors(['message' => 'বিক্রয় আইটেম পাওয়া যায়নি.']);
        } else {
            $sale->created_at_formatted = Carbon::parse($sale->created_at)->format('d/m/Y');
        }
        // dd($sale);

        $customer = Customer::where('id', $sale->customer_id)->first();
        // dd($customer);

        $total = $sale->total_price * ((100 - $sale->discount) / 100);

        $numberToWords = new NumberToWordsNumberToWords();
        // dd($numberToWords);

        // Convert total to words using NumberToWords
        // $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en'); // 'en' for English
        $totalInWords = $numberTransformer->toWords($total);

        // Find sale details by sales_id
        $details = SaleDetails::where('sales_id', $result)->get();
        if ($details->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'বিক্রয় বিবরণ পাওয়া যায়নি.']);
        }

        $currentDate = Carbon::now()->toFormattedDateString();

        $pdf = PDF::loadView('backend.invoice.pdf', compact('sale', 'details', 'currentDate', 'customer', 'totalInWords'))->setPaper('a4', 'landscape');
        return $pdf->download('ReportDetailSales' . '.pdf');
    }

    public function print(Request $request)
    {
        $result = $request->id;

        $sale = Sale::where('id', $request->id)->first();

        if ($sale) {
            $sale->created_at_formatted = Carbon::parse($sale->created_at)->format('d/m/Y');
        }
        // dd($sale);

        $details = SaleDetails::where('sales_id', $request->id)->get(); // Get all sale details
        // dd($details);

        $customer = Customer::where('id', $sale->customer_id)->first();
        // dd($customer);

        $total = $sale->total_price * ((100 - $sale->discount) / 100);

        $numberToWords = new NumberToWordsNumberToWords();
        // dd($numberToWords);

        // Convert total to words using NumberToWords
        // $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en'); // 'en' for English
        $totalInWords = $numberTransformer->toWords($total);

        $currentDate = Carbon::now()->toFormattedDateString();

        return view('backend.invoice.print', compact('details', 'currentDate', 'sale', 'customer',  'totalInWords'));
    }
}
