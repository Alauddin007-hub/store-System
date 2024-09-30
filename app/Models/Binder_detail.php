<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binder_detail extends Model
{
    use HasFactory;

    protected $table = "binder_details";

    protected $fillable = [
        'book_id',
        'binder_list_id',
        'printing_list_id',
        'received_to_press_order',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function binderL()
    {
        return $this->belongsTo(Binder_list::class,'binder_list_id');
    }
    public function pressL()
    {
        return $this->belongsTo(press_list::class,'printing_list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
