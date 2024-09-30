<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = "suppliers";

    protected $fillable = [
        'book_id',
        'supplier_detail_id',
        'total_send_order_quantity',
        'total_rest_of_supply',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function details()
    {
        return $this->belongsTo(SupplierDetails::class);
    }
    
}
