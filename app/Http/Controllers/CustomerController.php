<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::orderBy('id', 'DESC' )->get();
        return view('backend.customer.index',compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|max:11|unique:customers',
            'address' => 'required|max:100',
        ]);

        if ($validated) {

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'created_by' => auth()->id(),
            ];

            // dd($data);
            Customer::create($data);
            return redirect('/Customer')->with('success', "কাস্টমার সফলভাবে যোগ করা হয়েছে");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('backend.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|max:11',
            'address' => 'required|max:100',
        ]);

        if ($validated) {

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // dd($data);
            $cat = Customer::find($request->id);
            $cat->update($data);
            return redirect('/Customer')->with('success', "কাস্টমার সফলভাবে আপডেট করা হয়েছে");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request)
    // {
    //     $cat = Customer::find($request->id);
    //     $cat->delete();
    //     return back()->with('success', "কাস্টমার মুছে ফেলা হয়েছে");
    // }

    public function destroy(Request $request, string $id)
    {
        // Find the customer by ID
        $customer = Customer::find($id);
    
        // Check if the customer has any associated sales
        $customerSale = Sale::where('customer_id', $customer->id)->first();
        // dd($customerSale);
    
        // If the customer has sales, prevent deletion
        if ($customerSale) {
            return back()->with('error', "কাস্টমার মুছে ফেলা যাবে না, কারণ ইতিমধ্যে এই কাস্টমারের নাম এ লেনদেন হয়েছে।");
        }
    
        // Delete the customer if no sales are found
        $customer->delete();
        return back()->with('success', "কাস্টমার মুছে ফেলা হয়েছে");
    }

}
    
