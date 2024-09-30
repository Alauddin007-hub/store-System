<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintingPress extends Model
{
    use HasFactory;

    protected $table = "printing_presses";

    protected $fillable = [
        'book_id',
        'press_list_id',
        'total_order',
        'remaining_order',
        'created_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function pressL()
    {
        return $this->belongsTo(press_list::class,'press_list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
