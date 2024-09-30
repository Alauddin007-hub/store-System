<?php

namespace App\Http\Controllers;

use App\Models\Binder_detail;
use App\Models\Book;
use App\Models\press_detail;
use App\Models\press_list;
use App\Models\PrintingPress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrintingPressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $press = press_detail::orderby('id', 'DESC')->get();

        foreach ($press as $item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d/m/Y');
        }

        return view('backend.press.index', compact('press'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $book = Book::orderby('id', 'DESC')->get();
        $press = press_list::orderby('id', 'DESC')->get();
        return view('backend.press.create', compact('book', 'press'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'book_id' => 'required',
            'printing_list_id' => 'required',
            'received_order' => 'required',
        ]);


        $press = PrintingPress::where('book_id', $request->book_id)->where('press_list_id', $request->printing_list_id)->first();

        // dd($press->id);

        if ($press) {
            press_detail::create([
                'printing_list_id' => $request->printing_list_id,
                'book_id' => $request->book_id,
                'printing_press_id' => $press->id,
                'received_order' => $request->received_order,
                'created_by' => auth()->id(),
            ]);
            // Update existing stock record
            $press->total_order += $request->received_order;
            $press->remaining_order += $request->received_order;
            $press->save();
        } else {
            $printingP = PrintingPress::create([
                'book_id' => $request->book_id,
                'press_list_id' => $request->printing_list_id,
                'total_order' => $request->received_order,
                'remaining_order' => $request->received_order,
                'created_by' => auth()->id(),
            ]);

            // dd($printingP->id);

            press_detail::create([
                'printing_list_id' => $request->printing_list_id,
                'book_id' => $request->book_id,
                'printing_press_id' => $printingP->id,
                'received_order' => $request->received_order,
                'created_by' => auth()->id(),
            ]);
        }



        return redirect('/press')->with('success', "প্রেসে অর্ডার সফলভাবে যোগ করা হয়েছে");
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
        $press = press_detail::find($id);

        if (!$press) {
            return redirect('/press')->with(['error' => 'প্রেসের বিস্তারিত পাওয়া যায়নি।']);
        }

        // Check if the book has been sent to the binder
        $binderCheck = Binder_detail::where('book_id', $press->book_id)
            ->where('printing_list_id', $press->printing_list_id)
            ->count();

        if ($binderCheck > 0) {
            return redirect('/press')->with(['error' => 'এই বইটি বাধাইখানায় পাঠানো হয়েছে তাই  এডিট করা যাচ্ছে না']);
        }

        $book = Book::orderby('id', 'DESC')->get();
        $pressL = press_list::orderby('id', 'DESC')->get();

        return view('backend.press.edit', compact('book', 'press', 'pressL'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'book_id' => 'required',
            'printing_list_id' => 'required',
            'received_order' => 'required',
        ]);

        $press = press_detail::find($id);

        if (!$press) {
            return redirect('/press')->with(['error' => 'প্রেসের বিস্তারিত পাওয়া যায়নি।']);
        }

        // Check if the book has been sent to the binder
        $binderCheck = Binder_detail::where('book_id', $press->book_id)
            ->where('printing_list_id', $press->printing_list_id)
            ->count();

        if ($binderCheck > 0) {
            return redirect('/press')->with(['error' => 'এই বইটি বাধাইখানায় পাঠানো হয়েছে তাই এডিট করা যাচ্ছে না']);
        }

        // Continue with the update logic
        $previous = $press->received_order;
        $present = $request->received_order;

        if ($previous < $present) {
            $current_value = $present - $previous;

            $data = [
                'book_id' => $request->book_id,
                'printing_list_id' => $request->printing_list_id,
                'received_order' => $previous + $current_value,
                'created_by' => auth()->id(),
            ];

            $press->update($data);

            $change = PrintingPress::where('book_id', $request->book_id)
                ->where('press_list_id', $request->printing_list_id)
                ->first();

            if ($change) {
                $change->total_order += $current_value;
                $change->remaining_order += $current_value;
                $change->save();
            } else {
                return redirect('/press')->withErrors(['error' => 'প্রিন্টিং প্রেসের রেকর্ড পাওয়া যায়নি।']);
            }
        } else {
            $current_value = $previous - $present;

            $data = [
                'book_id' => $request->book_id,
                'printing_list_id' => $request->printing_list_id,
                'received_order' => $present,
                'created_by' => auth()->id(),
            ];

            $press->update($data);

            $change = PrintingPress::where('book_id', $request->book_id)
                ->where('press_list_id', $request->printing_list_id)
                ->first();

            if ($change) {
                $change->total_order -= $current_value;
                $change->remaining_order -= $current_value;
                $change->save();
            } else {
                return redirect('/press')->withErrors(['error' => 'প্রিন্টিং প্রেসের রেকর্ড পাওয়া যায়নি।']);
            }
        }

        return redirect('/press')->with('success', "প্রেস অর্ডার সফলভাবে আপডেট করা হয়েছে");
    }



    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request, string $id)
    // {
    //     $book = press_detail::find($request->id);
    //     $book->delete();
    //     return back()->with('success', "প্রেস অর্ডার মুছে ফেলা হয়েছে");
    // }

    public function destroy(Request $request, string $id)
    {
        // Find the book order in the printing press
        $book = press_detail::find($request->id);

        // Check if the book has already been transferred to the binder
        $binderOrder = Binder_detail::where('printing_list_id', $book->printing_list_id)->where('book_id', $book->book_id)->first();

        if ($binderOrder) {
            // If the book is in the binder, prevent deletion
            return back()->with('error', "প্রেস অর্ডার মুছে ফেলা যাবে না, কারণ এটি ইতিমধ্যে বাধাইখানায় স্থানান্তরিত হয়েছে।");
        }

        // Proceed to delete the book from the printing press if it's not transferred
        $book->delete();
        return back()->with('success', "প্রেস অর্ডার মুছে ফেলা হয়েছে");
    }
}
