<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReceiveUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'receive_id',
        'user_id',
    ];
}