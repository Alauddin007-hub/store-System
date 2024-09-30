<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDetails extends Model
{
    use HasFactory;

    
    protected $table = "supplier_details";

    protected $fillable = [
        'book_id',
        'printing_press_name',
        'order_printing_press',
        'send_to_binder_name',
        'supplied_from_Binder',
        'rest_of_supply',
        'created_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
