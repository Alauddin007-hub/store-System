<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Stock_Detail;
use App\Models\Writer;
use Illuminate\Http\Request;
use WpOrg\Requests\Exception\Http\Status304;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('id', 'DESC' )->get();
        return view('backend.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::orderBy('id', 'DESC' )->get();
        $lekhok = Writer::orderBy('id', 'DESC' )->get();
        return view('backend.book.create', compact('cats','lekhok'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_english_name' => 'required',
            'book_bangla_name' => 'required',
            'category_id' => 'required',
            'writer_id' => 'required',
            'price' => 'required',
            'short_description' => 'required|max:150',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imageName = Null;
        if($request->hasFile('image'))
        {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(('book'), $imageName);
        }
        // dd($imageName);
        
        
        if ($validated) {
            
            $data = [
                'book_english_name' => $request->book_english_name,
                'book_bangla_name' => $request->book_bangla_name,
                'category_id' => $request->category_id,
                'writer_id' => $request->writer_id,
                'price' => $request->price,
                'created_by' => auth()->id(),
                'short_description' => $request->short_description,
                'publising_date' => $request->publising_date,
                'book_of_page' => $request->book_of_page,
                'image' => $imageName,
            ];
            // dd($data);
            Book::create($data);

            // $book->update($data);
            return redirect('/boi')->with('success', "বইটি সফলভাবে যোগ করা হয়েছে");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cats = Category::all();          
        $lekhok = Writer::all();
        $book = Book::find($id);
        return view('backend.book.edit', compact('cats','lekhok','book'));
    }

    /**
     * Update the specified resource in storage.
     */

     //'required|unique:books'
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'book_english_name' => 'required',
            'book_bangla_name' => 'required',
            'category_id' => 'required',
            'writer_id' => 'required',
            'short_description' => 'required|max:150',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imageName = Null;
        if($request->hasFile('image'))
        {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(('book'), $imageName);
        }

        // dd($imageName);


        if ($validated) {

            if(empty($imageName))
            {
                $data = [
                    'book_english_name' => $request->book_english_name,
                    'book_bangla_name' => $request->book_bangla_name,
                    'category_id' => $request->category_id,
                    'writer_id' => $request->writer_id,
                    'short_description' => $request->short_description,
                    'price' => $request->price,
                    'created_by' => auth()->id(),
                    'publising_date' => $request->publising_date,
                    'book_of_page' => $request->book_of_page,
                ];
                // dd($data);
                $book = Book::find($request->id);
    
                $book->update($data);
                return redirect('/boi')->with('success', "বইটি সফলভাবে আপডেট করা হয়েছে");
            }
            else
            {
                $data = [
                    'book_english_name' => $request->book_english_name,
                    'book_bangla_name' => $request->book_bangla_name,
                    'category_id' => $request->category_id,
                    'writer_id' => $request->writer_id,
                    'short_description' => $request->short_description,
                    'price' => $request->price,
                    'publising_date' => $request->publising_date,
                    'book_of_page' => $request->book_of_page,
                    'image' => $imageName,
                ];
                // dd($data);
                $book = Book::find($request->id);
    
                $book->update($data);
                return redirect('/boi')->with('success', "বইটি সফলভাবে আপডেট করা হয়েছে");
            }

            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $book = Book::find($request->id);

        $stockOrder = Stock::where('book_id', $book->id)->first();
        // dd($stockOrder);
        
        if($stockOrder){
            return back()->with('error', "বইটি মুছে ফেলা যাবে না, কারণ এটি ইতিমধ্যে স্টক এ স্থানান্তরিত হয়েছে।");
        }
        
        $book->delete();
        return back()->with('success', "বইটি মুছে ফেলা হয়েছে");
    }
}
