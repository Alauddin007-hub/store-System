<?php

namespace App\Http\Controllers;

use App\Models\Binder;
use App\Models\Binder_detail;
use App\Models\Binder_list;
use App\Models\Book;
use App\Models\press_detail;
use App\Models\press_list;
use App\Models\PrintingPress;
use App\Models\Stock;
use App\Models\Stock_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BinderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $binder = Binder_detail::with(['book', 'pressL', 'binderL'])->orderby('id', 'DESC')->get();

        foreach ($binder as $item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d/m/Y');
        }

        return view('backend.binder.index', compact('binder'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $press = press_list::orderby('id', 'DESC')->get();
        $binder = Binder_list::orderBy('id', 'DESC')->get();
        $book = Book::orderby('id', 'DESC')->get();
        return view('backend.binder.create', compact('press', 'book', 'binder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'book_id' => 'required',
            'binder_list_id' => 'required',
            'printing_list_id' => 'required',
            'received_to_press_order' => 'required',
        ]);

        $press = PrintingPress::where('book_id', $request->book_id)->where('press_list_id', $request->printing_list_id)
            ->first();

        if (!$press) {
            // return redirect()->back()->with('error', 'এই প্রেসের কোন অর্ডার নেই।');
            return redirect()->back()->with(['error'=>'এই প্রেসের কোন অর্ডার নেই।', 'bookid'=>$request->book_id, 'pressid'=>$request->printing_list_id, 'bookqty'=>$request->received_to_press_order, 'binderid'=>$request->binder_list_id]);
        }

        if ($request->received_to_press_order > $press->remaining_order) {
            // return redirect()->back()->with('error', 'প্রেস অর্ডারের পরিমাণ প্রেসের জন্য অবশিষ্ট ' . ' ' . $press->remaining_order . ' ' . 'সরবরাহকে ছাড়িয়ে গেছে।');
            return back()->with(['error'=>'প্রেস অর্ডারের পরিমাণ প্রেসের জন্য অবশিষ্ট ' . ' ' . $press->remaining_order . ' ' . 'সরবরাহকে ছাড়িয়ে গেছে।', 'bookid'=>$request->book_id, 'pressid'=>$request->printing_list_id, 'bookqty'=>$request->received_to_press_order, 'binderid'=>$request->binder_list_id]);
        }


        $Binder_detail = Binder_detail::create([
            'book_id' => $request->book_id,
            'binder_list_id' => $request->binder_list_id,
            'printing_list_id' => $request->printing_list_id,
            'received_to_press_order' => $request->received_to_press_order,
            'user_id' => auth()->id(),
        ]);


        $press = Binder::where('book_id', $request->book_id)->where('binder_list_id', $request->binder_list_id)->first();

        if (!$press) {
            Binder::create([
                'book_id' => $request->book_id,
                'binder_list_id' => $request->binder_list_id,
                'binder_detail_id' => $Binder_detail->id,
                'total_received_order' => $request->received_to_press_order,
                'rest_of_supply' => $request->received_to_press_order,
                'user_id' => auth()->id(),
            ]);

            $press = PrintingPress::where('book_id', $request->book_id)->where('press_list_id', $request->printing_list_id)
                ->first();

            // dd($binder);

            $press->remaining_order -= $request->received_to_press_order;
            $press->save();
        } else {
            // Update existing binder stock record
            $press->total_received_order += $request->received_to_press_order;
            $press->rest_of_supply += $request->received_to_press_order;
            $press->save();

            $press = PrintingPress::where('book_id', $request->book_id)->where('press_list_id', $request->printing_list_id)
                ->first();

            if ($press) {
                $press->remaining_order -= $request->received_to_press_order;
                $press->save();
            } else {
                // Handle the case when no binder is found
                // You can log an error, throw an exception, or provide a user-friendly message
                return redirect()->back()->with('error', 'বাধাইখানা পাওয়া যায়নি।');
            }
        }

        return redirect('/binders')->with('success', "বাধাইখানার অর্ডার সফলভাবে যোগ করা হয়েছে");
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
        $binder = Binder_detail::find($id);

        if (!$binder) {
            return redirect('/binders')->with(['error' => 'বাধাইখানার বিস্তারিত পাওয়া যায়নি।']);
        }

        // Check if the book is already stocked
        $stockCount = Stock_Detail::where('book_id', $binder->book_id)
            ->where('binder_list_id', $binder->binder_list_id)
            ->count();

        if ($stockCount > 0) {
            return redirect('/binders')->with(['error' => 'এই বইটি ইতিমধ্যে স্টক করা হয়েছে তাই  এডিট করা যাচ্ছে না']);
        }

        $book = Book::orderby('id', 'DESC')->get();
        $press = press_list::orderby('id', 'DESC')->get();
        $bainderList = Binder_list::orderby('id', 'DESC')->get();

        return view('backend.binder.edit', compact('press', 'book', 'binder', 'bainderList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'book_id' => 'required|integer',
            'binder_list_id' => 'required|integer',
            'printing_list_id' => 'required|integer',
            'received_to_press_order' => 'required',
        ]);

        // Find the binder detail by ID
        $binder_detail = Binder_detail::find($id);

        if (!$binder_detail) {
            return redirect('/binders')->with(['error' => 'বাধাইখানার বিস্তারিত পাওয়া যায়নি।']);
        }

        // Check if the book is already stocked
        $stockCount = Stock_Detail::where('book_id', $binder_detail->book_id)
            ->where('binder_list_id', $binder_detail->binder_list_id)
            ->count();

        if ($stockCount > 0) {
            return redirect('/binders')->with(['error' => 'এই বইটি ইতিমধ্যে স্টক করা হয়েছে তাই  এডিট করা যাচ্ছে না']);
        }

        // Get previous and present received order values
        $previous = $binder_detail->received_to_press_order;
        $present = $request->input('received_to_press_order');

        // Prepare data to be updated
        $data = [
            'book_id' => $request->input('book_id'),
            'binder_list_id' => $request->input('binder_list_id'),
            'printing_list_id' => $request->input('printing_list_id'),
            'received_to_press_order' => $present,
            'created_by' => auth()->id(),
            'updated_at' => now(),
        ];

        // Update binder detail
        $binder_detail->update($data);

        // Find the corresponding binder
        $binder = Binder::where('book_id', $request->input('book_id'))
            ->where('binder_list_id', $request->input('binder_list_id'))
            ->first();

        if (!$binder) {
            return redirect('/binders')->withErrors(['error' => 'বাধাইখানার রেকর্ড পাওয়া যায়নি।']);
        }

        // Update the total received order and rest of supply
        if ($previous < $present) {
            $current_value = $present - $previous;
            $binder->total_received_order += $current_value;
            $binder->rest_of_supply += $current_value;
            $binder->save();

            $press = PrintingPress::where('book_id', $request->input('book_id'))->where('press_list_id', $request->input('printing_list_id'))->first();

            $press->remaining_order -= $current_value;
            $press->save();

        } else {
            $current_value = $previous - $present;
            $binder->total_received_order -= $current_value;
            $binder->rest_of_supply -= $current_value;
            $binder->save();

            $press = PrintingPress::where('book_id', $request->book_id)->where('press_list_id', $request->printing_list_id)->first();

            $press->remaining_order += $current_value;
            $press->save();
        }

        // $binder->save();

        return redirect('/binders')->with('success', "বাধাইখানার অর্ডার সফলভাবে আপডেট করা হয়েছে");
    }



    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request, string $id)
    // {
    //     $book = Binder_detail::find($request->id);
    //     $book->delete();
    //     return back()->with('success', "বাধাইখানার অর্ডার মুছে ফেলা হয়েছে");
    // }

    public function destroy(Request $request, string $id)
    {
        $book = Binder_detail::find($request->id);

        $stockOrder = Stock_Detail::where('binder_list_id', $book->binder_list_id)->where('book_id', $book->book_id)->first();

        if ($stockOrder) {

            return back()->with('error', "বাধাইখানার অর্ডার মুছে ফেলা যাবে না, কারণ এটি ইতিমধ্যে স্টক এ স্থানান্তরিত হয়েছে।");
        }

        $book->delete();
        return back()->with('success', "বাধাইখানার অর্ডার মুছে ফেলা হয়েছে");
    }

}
