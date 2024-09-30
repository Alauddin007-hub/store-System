<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupStockDetail extends Model
{
    use HasFactory;

    protected $table = 'backup_stock_details';

    protected $fillable = [
        'book_id',
        'uni_code',
        'quantity',
        'price',
        'created_by',
        'status',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
