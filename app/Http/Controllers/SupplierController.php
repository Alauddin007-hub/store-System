<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Supplier;
use App\Models\SupplierDetails;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = SupplierDetails::all();
        // dd($details);
        // $supply = Supplier::where('book_id', $details->book_id)->first();

        return view('backend.supply.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $book = Book::all();
        return view('backend.supply.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $res = $request->all();
        // dd($res);

        $request->validate([
            'book_id' => 'required',
            'printing_press_name' => 'required',
            // 'order_printing_press' => 'required|integer|min:1', // Assuming quantity should be a positive integer
            'send_to_binder_name' => 'required',
            // 'send_order_quantity' => 'required',
            'supplied_from_Binder' => 'required|numeric|min:0', // Assuming price should be a non-negative number
        ]);

        // $giving_order = $request->send_order_quantity;
        // $got_book = $request->supplied_from_Binder;

        // $restofbook_receiving = $giving_order - $got_book;

        // dd($restofbook_receiving);

        $supp = Supplier::where('book_id',$request->book_id)->first();


        // $data = [
            // 'book_id' => $request->book_id,
            // 'printing_press_name' => $request->printing_press_name,
            // 'order_printing_press' => $request->order_printing_press,
            // 'send_to_binder_name' => $request->send_to_binder_name,
            // 'supplied_from_Binder' => $request->supplied_from_Binder,
            // 'rest_of_supply' => $supp->total_rest_of_supply - $request->supplied_from_Binder,
            // 'created_by' => auth()->id(),
        // ];

        // dd($data);

        $details = SupplierDetails::create([
            'book_id' => $request->book_id,
            'printing_press_name' => $request->printing_press_name,
            'order_printing_press' => $request->order_printing_press,
            'send_to_binder_name' => $request->send_to_binder_name,
            'supplied_from_Binder' => $request->supplied_from_Binder,
            'rest_of_supply' => $supp->total_rest_of_supply - $request->supplied_from_Binder,
            'created_by' => auth()->id(),
        ]);

        // $supply = Supplier::where('book_id', $request->book_id)->where('supplier_detail_id', $details->id)->first();


        $supply = Supplier::where('book_id', $request->book_id)->first();

        if (!$supply) {
            Supplier::create([
                'book_id' => $request->book_id,
                'supplier_detail_id' => $details->id,
                'total_send_order_quantity' => $request->send_order_quantity,
                'total_rest_of_supply'=> $request->send_order_quantity - $request->supplied_from_Binder,
            ]);
        } else {
            $supply->total_send_order_quantity += $request->send_order_quantity;
            $supply->total_rest_of_supply -=  $request->supplied_from_Binder;
            $supply->save();
        }

        return redirect()->route('supplier.index')->with('success', 'received the book from the supplier.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $supply = Supplier::find($id);
        // return view('backend.supply.edit',compact('supply'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::get();
        $supply = SupplierDetails::find($id);
        // dd($supply);
        $supplier = Supplier::where('id',$supply->id)->first();
        return view('backend.supply.edit', compact('supply','supplier','book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    //     $request->validate([
    //         'book_id' => 'required',
    //         'printing_press_name' => 'required',
    //         // 'order_printing_press' => 'required|integer|min:1', // Assuming quantity should be a positive integer
    //         'send_to_binder_name' => 'required',
    //         // 'send_order_quantity' => 'required',
    //         'supplied_from_Binder' => 'required|numeric|min:0', // Assuming price should be a non-negative number
    //     ]);


    //     $supp = Supplier::where('book_id',$request->book_id)->first();

    //     $data = [
    //         'book_id' => $request->book_id,
    //         'printing_press_name' => $request->printing_press_name,
    //         'order_printing_press' => $request->order_printing_press,
    //         'send_to_binder_name' => $request->send_to_binder_name,
    //         'supplied_from_Binder' => $request->supplied_from_Binder,
    //         'rest_of_supply' => $supp->total_rest_of_supply - $request->supplied_from_Binder,
    //         'created_by' => auth()->id(),
    //     ];

    //     // dd($data);

    //    $detail = SupplierDetails::find($request->id);


    //     $supply = Supplier::where('book_id', $request->book_id)->first();

    //     if($supply)
    //     {
    //         $supply->total_send_order_quantity -= $request->send_order_quantity;
    //         $supply->total_rest_of_supply +=  $request->supplied_from_Binder;
    //         $supply->save();
    //     }

    //     $detail->update($data);
    
    //     if ($supply) {
    //         // Update existing stock record
    //         $supply->total_send_order_quantity += $request->send_order_quantity;
    //         $supply->total_rest_of_supply -= $request->supplied_from_Binder;
    //         $supply->save();
    //     }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $book = Supplier::find($request->id);
        $book->delete();
        return back()->with('success', "supplier has been deleted");
    }
}
