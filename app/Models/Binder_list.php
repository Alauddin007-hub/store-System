<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binder_list extends Model
{
    use HasFactory;

    protected $table = "binder_lists";

    protected $fillable = [
        'name',
        'address',
        'user_id',
    ];
}
