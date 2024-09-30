<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    use HasFactory;

    protected $table = 'sale_details';
    protected $fillable = [
        'book_id',
        'stock_details_id',
        'sales_id',
        'quantity',
        'price',
        'discount',
        'subtotal',
        'status',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function sale(){
        return $this->belongsTo(Sale::class, 'sales_id');
    }
    public function stockDetail(){
        return $this->belongsTo(Stock_Detail::class, 'stock_details_id');
    }

   
}
