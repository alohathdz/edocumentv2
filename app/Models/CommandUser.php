<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CommandUser extends Pivot
{
    protected $fillable = [
        'command_id',
        'user_id',
    ];
}
