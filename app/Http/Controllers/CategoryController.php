<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = Category::orderBy('id', 'DESC' )->get();
        return view('backend.category.index',compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required|max:150',
        ]);

        if ($validated) {

            $data = [
                'name' => $request->name,
                'short_description' => $request->description,
                'created_by' => auth()->id(),
            ];

            // dd($data);
            Category::create($data);
            return redirect('/category')->with('success', "ক্যাটাগরি সফলভাবে যোগ করা হয়েছে");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cat = Category::find($id);
        return view('backend.category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required|max:150',
        ]);

        if ($validated) {

            $data = [
                'name' => $request->name,
                'short_description' => $request->description,
                'created_by' => auth()->id(),
            ];

            // dd($data);
            $cat = Category::find($request->id);
            $cat->update($data);
            return redirect('/category')->with('success', "ক্যাটাগরি সফলভাবে আপডেট করা হয়েছে");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cat = Category::find($request->id);
        $cat->delete();
        return back()->with('success', "ক্যাটাগরি মুছে ফেলা হয়েছে");
    }
}
