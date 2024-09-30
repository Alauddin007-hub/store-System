<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function category()
    {
    }

    public function writer()
    {
    }

    public function customer(Request $request)
    {
        $data = Customer::where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);

        return $data;
    }

    public function book(Request $request)
    {
        $data = Book::where('book_bangla_name', 'LIKE', '%' . $request->searchItem . '%')
            ->orWhere('book_english_name', 'LIKE', '%' . $request->searchItem . '%')
            ->paginate(10);

        return $data;
    }
}
