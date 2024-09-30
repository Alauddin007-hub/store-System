<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class press_detail extends Model
{
    use HasFactory;

    protected $table = "printing_press_details";

    protected $fillable = [
        'printing_list_id',
        'book_id',
        'printing_press_id',
        'received_order',
        'created_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function pressL()
    {
        return $this->belongsTo(press_list::class, 'printing_list_id');
    }
    public function printingPress()
    {
        return $this->belongsTo(PrintingPress::class, 'printing_press_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
