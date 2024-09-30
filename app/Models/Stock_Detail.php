<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Detail extends Model
{
    use HasFactory;

    protected $table = "stock_details";

    protected $fillable = [
        'book_id',
        'binder_list_id',
        'uni_code',
        'quantity',
        's_quantity',
        'created_by',
        'price',
        'status',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function binder(){
        return $this->belongsTo(Binder_list::class,'binder_list_id');
    }
}
