<?php

namespace App\Http\Controllers;

use App\Models\Binder;

class BindeController extends Controller
{
    public function binder()
    {
        $binder = Binder::with(['book', 'binderList', 'binderDetail'])->orderby('id', 'DESC')->get();
        return view('backend.binder.binder', compact('binder'));
    }
}