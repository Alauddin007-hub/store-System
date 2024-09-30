<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\press_list;
use App\Models\PrintingPress;
use Illuminate\Http\Request;

class PressListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $press = press_list::orderby('id', 'DESC' )->get();
        return view('backend.press_list.index', compact('press'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.press_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required',
        ]);

        press_list::create([
            'name' => $request->name,
            'address' => $request->address,
            'created_by' => auth()->id(),
        ]);

        return redirect('/press_list')->with('success', "প্রেসের নাম সফলভাবে যোগ করা হয়েছে");
    }

    /**
     * Display the specified resource.
     */
    public function show(press_list $press_list)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::orderby('id', 'DESC' )->get();
        $press = press_list::find($id);
        return view('backend.press_list.edit', compact('book','press'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, press_list $press_list)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'created_by' => auth()->id(),
        ];

        $press = $press_list::find($request->id);

        $press->update($data);

        return redirect('/press_list')->with('success', "প্রেসের নাম সফলভাবে আপডেট করা হয়েছে");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $press = press_list::find($request->id);

        $printingPressOrder = PrintingPress::where('press_list_id', $press->id)->first();
        // dd($printingPressOrder);

        if($printingPressOrder){
            return back()->with('error', "প্রেসের নাম মুছে ফেলা যাবে না, কারণ এটি ইতিমধ্যে প্রেসে অর্ডার দেয়া হয়েছে।");
        }

        $press->delete();
        return back()->with('success', "প্রেসের নাম মুছে ফেলা হয়েছে");
    }
}
