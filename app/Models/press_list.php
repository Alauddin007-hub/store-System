<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class press_list extends Model
{
    use HasFactory;

    protected $table = "press_lists";

    protected $fillable = [
        'name', 'address', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
