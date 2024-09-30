<?php

namespace App\Http\Controllers;

use App\Models\BackupStockDetail;
use App\Models\Binder;
use App\Models\Binder_list;
use App\Models\Book;
use App\Models\SaleDetails;
use App\Models\Stock;
use App\Models\Stock_Detail;
use App\Models\Supplier;
use App\Models\SupplierDetails;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //

    public function index()
    {
        $stock = Stock::orderBy('id', 'DESC')->get();

        foreach ($stock as $item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d/m/Y');
        }

        return view('backend.stock.total_stock', compact('stock'));
    }

    public function create()
    {
        $binder = Binder_list::orderBy('id', 'DESC')->get();
        $book = Book::orderBy('id', 'DESC')->get();
        return view('backend.stock.restore', compact('book', 'binder'));
    }

    public function restock(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'quantity' => 'required|integer|min:1', // Assuming quantity should be a positive integer
            'price' => 'required|numeric|min:0', // Assuming price should be a non-negative number
        ]);

        $binder = Binder::where('book_id', $request->book_id)->where('binder_list_id', $request->binder_list_id)
            ->first();

        if (!$binder) {
            return redirect()->back()->with([
                'error' => 'বাধাইখানা পাওয়া যায়নি ।',
                'bookid' => $request->book_id,
                'binderid' => $request->binder_list_id,
                'qty' => $request->quantity,
                'price' => $request->price
            ]);
            
        }

        if ($request->quantity > $binder->rest_of_supply) {
            return redirect()->back()->with([
                'error' => 'বাধাইখানার অর্ডারের পরিমাণ ছাড়িয়ে গেছে ' . $binder->rest_of_supply . ' বাইন্ডারের জন্য অবশিষ্ট সরবরাহ ।',
                'bookid' => $request->book_id,
                'binderid' => $request->binder_list_id,
                'qty' => $request->quantity,
                'price' => $request->price
            ]);
        }
        

        // Generate Voucher no for the stock detail
        $uuid = IdGenerator::generate(['table' => 'stock_details', 'field' => 'uni_code', 'length' => 7, 'prefix' => 'IN#']);

        // Create new stock detail
        $stockDetail = Stock_Detail::create([
            'book_id' => $request->book_id,
            'binder_list_id' => $request->binder_list_id,
            'uni_code' => $uuid,
            'quantity' => $request->quantity,
            's_quantity' => $request->quantity,
            'price' => $request->price,
            'created_by' => auth()->id(),
        ]);

        $stock = Stock::where('book_id', $request->book_id)->first();
        // dd($stock);

        if (!$stock) {
            Stock::create([
                'book_id' => $request->book_id,
                'stock_detail_id' => $stockDetail->id,
                'total_quantity' => $request->quantity,
                'total_price' => $request->quantity * $request->price,
            ]);

            $binder = Binder::where('book_id', $request->book_id)->where('binder_list_id', $request->binder_list_id)
                ->first();

            // dd($binder);

            $binder->rest_of_supply -= $request->quantity;
            $binder->save();
        } else {
            // Update existing stock record
            $stock->total_quantity += $request->quantity;
            $stock->total_price += $request->quantity * $request->price;
            $stock->save();

            $binder = Binder::where('book_id', $request->book_id)->where('binder_list_id', $request->binder_list_id)
                ->first();

            if ($binder) {
                $binder->rest_of_supply -= $request->quantity;
                $binder->save();
            } else {
                // Handle the case when no binder is found
                // You can log an error, throw an exception, or provide a user-friendly message
                return redirect()->back()->with('error', 'বাধাইখানার পাওয়া যায়নি ।');
            }
        }

        return redirect()->route('stockDetails')->with('success', 'বই মজুদ করা হয়েছে ।');
    }



    public function in_stock()
    {
        $stock_detail = Stock_Detail::orderBy('id', 'DESC')->get();

        foreach ($stock_detail as $item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d/m/Y');
        }

        return view('backend.stock.in_stock', compact('stock_detail'));
    }

    public function edit($id)
    {
        $stock = Stock_Detail::find($id);

        if (!$stock) {
            return redirect()->back()->with('error', ' স্টক পাওয়া যায়নি । ');
        }

        // Check if the book has been sold
        $salesCount = SaleDetails::where('book_id', $stock->book_id)->where('stock_details_id', $stock->id)->count();

        if ($salesCount > 0) {
            return redirect()->back()->with('error', 'এই বইটি ইতিমধ্যে বিক্রি হয়েছে তাই এডিট করা যাবে না ৷');
        }

        $supply = Binder_list::get();
        $book = Book::all();
        return view('backend.stock.instock_edit', compact('stock', 'book', 'supply'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'quantity' => 'required|integer|min:1', // Assuming quantity should be a positive integer
            'price' => 'required|numeric|min:0', // Assuming price should be a non-negative number
        ]);

        $stockDetail = Stock_Detail::find($request->id);

        if (!$stockDetail) {
            return redirect()->back()->with('error', 'Stock not found.');
        }

        // Check if the book has been sold
        $salesCount = SaleDetails::where('book_id', $stockDetail->book_id)->where('stock_details_id', $stockDetail->id)->count();

        if ($salesCount > 0) {
            return redirect()->back()->with('error', 'এই বইটি ইতিমধ্যে বিক্রি হয়েছে তাই এডিট করা যাবে না ৷');
        }

        $previous = $stockDetail->s_quantity;
        $present = $request->input('quantity');

        $binder = Binder::where('book_id', $request->book_id)->where('binder_list_id', $request->supplier_id)
            ->first();

        if (!$binder) {
            return redirect()->back()->with(['error' => 'বাধাইখানার রেকর্ড পাওয়া যায়নি ।']);
        }

        if ($previous < $present) {
            $current_value = $present - $previous;
            $data = [
                'book_id' => $request->book_id,
                'supplier_id' => $request->supplier_id,
                'price' => $request->price,
                'created_by' => auth()->id(),
                'updated_at' => now(),
            ];

            $stockDetail->quantity += $current_value;
            $stockDetail->s_quantity += $current_value;
            $stockDetail->save();

            // Update stock detail
            $stockDetail->update($data);

            // Adjust stock quantities
            $stock = Stock::where('book_id', $request->book_id)->first();

            if ($stock) {
                $stock->total_quantity += $current_value;
                $stock->total_price += $current_value * $stockDetail->price;
                $stock->save();
            }

            $binder->rest_of_supply -= $current_value;
            $binder->save();
        } else {
            $current_value = $previous - $present;
            $data = [
                'book_id' => $request->book_id,
                'supplier_id' => $request->supplier_id,
                'price' => $request->price,
                'created_by' => auth()->id(),
                'updated_at' => now(),
            ];

            $stockDetail->quantity -= $current_value;
            $stockDetail->s_quantity -= $current_value;
            $stockDetail->save();

            // Update stock detail
            $stockDetail->update($data);

            // Adjust stock quantities
            $stock = Stock::where('book_id', $request->book_id)->first();

            if ($stock) {
                $stock->total_quantity -= $current_value;
                $stock->total_price -= $current_value * $stockDetail->price;
                $stock->save();
            }

            $binder->rest_of_supply += $current_value;
            $binder->save();
        }

        return redirect()->route('stockDetails')->with('success', 'বইয়ের স্টক আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $stock = Stock_Detail::find($id);

        if (!$stock) {
            return redirect()->back()->with('error', 'স্টক পাওয়া যায়নি ।');
        }

        $salesCount = SaleDetails::where('book_id', $stock->book_id)->where('stock_details_id', $stock->id)->count();

        if ($salesCount > 0) {
            return redirect()->back()->with('error', 'এই বইটি ইতিমধ্যে বিক্রি হয়েছে তাই ডিলিট করা যাবে না ৷');
        }

        $stock->delete();

        return redirect()->route('stockDetails')->with('success', 'স্টক সফলভাবে মুছে ফেলা হয়েছে।');
    }



    public function nonbinder()
    {
        $book = Book::orderBy('id', 'DESC')->get();
        return view('backend.stock.nonBinderBookStock', compact('book'));
    }

    public function stockNonbinder(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'book_id' => 'required',
            'quantity' => 'required|integer|min:1', // Assuming quantity should be a positive integer
            'price' => 'required|numeric|min:0', // Assuming price should be a non-negative number
        ]);

        $uuid = IdGenerator::generate(['table' => 'stock_details', 'field' => 'uni_code', 'length' => 7, 'prefix' => 'IN#']);

        // $data = [
        //     'book_id' => $request->book_id,
        //     'binder_list_id' => 4,
        //     'uni_code' => $uuid,
        //     'quantity' => $request->quantity,
        //     's_quantity' => $request->quantity,
        //     'price' => $request->price,
        //     'created_by' => auth()->id(),
        // ];

        // dd($data);

        // Create new stock detail
        $stockDetail = Stock_Detail::create([
            'book_id' => $request->book_id,
            'binder_list_id' => 4,
            'uni_code' => $uuid,
            'quantity' => $request->quantity,
            's_quantity' => $request->quantity,
            'price' => $request->price,
            'created_by' => auth()->id(),
        ]);

        $stock = Stock::where('book_id', $request->book_id)->first();
        // dd($stock);

        if (!$stock) {
            Stock::create([
                'book_id' => $request->book_id,
                'stock_detail_id' => $stockDetail->id,
                'total_quantity' => $request->quantity,
                'total_price' => $request->quantity * $request->price,
            ]);
        } else {
            // Update existing stock record
            $stock->total_quantity += $request->quantity;
            $stock->total_price += $request->quantity * $request->price;
            $stock->save();
        }
        return redirect()->route('stockDetails')->with('success', 'বই মজুদ করা হয়েছে ।');
    }
}
