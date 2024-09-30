<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binder extends Model
{
    use HasFactory;

    protected $table = "binders";

    protected $fillable = [
        'book_id',
        'binder_list_id',
        'binder_detail_id',
        'total_received_order',
        'rest_of_supply',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function binderList()
    {
        return $this->belongsTo(Binder_list::class, 'binder_list_id');
    }

    public function binderDetail()
    {
        return $this->belongsTo(Binder_detail::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
