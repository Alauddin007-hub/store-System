<?php

namespace App\Http\Controllers;

use App\Models\Binder;
use App\Models\Binder_list;
use Illuminate\Http\Request;

class BinderListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $binder = Binder_list::orderby('id', 'DESC' )->get();
        return view('backend.binder_list.index', compact('binder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.binder_list.create');
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

        Binder_list::create([
            'name' => $request->name,
            'address' => $request->address,
            'created_by' => auth()->id(),
        ]);

        return redirect('/binder_list')->with('success', "বাধাইখানার নাম সফলভাবে যোগ করা হয়েছে");
    }

    /**
     * Display the specified resource.
     */
    public function show(Binder_list $binder_list)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $binder = Binder_list::find($id);
        return view('backend.binder_list.edit', compact('binder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Binder_list $binder_list)
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

        $press = $binder_list::find($request->id);

        $press->update($data);

        return redirect('/binder_list')->with('success', "বাধাইখানার নাম সফলভাবে আপডেট করা হয়েছে");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $binder = Binder_list::find($request->id);

        $binderOrder = Binder::where('binder_list_id', $binder->id)->first();
        // dd($binderOrder);

        if($binderOrder){
            return back()->with('error', "বাধাইখানার নাম মুছে ফেলা যাবে না, কারণ এটি ইতিমধ্যে বাধাইখানায় অর্ডার দেয়া হয়েছে।");
        }

        $binder->delete();
        return back()->with('success', "বাধাইখানার নাম মুছে ফেলা হয়েছে");
    }
}
