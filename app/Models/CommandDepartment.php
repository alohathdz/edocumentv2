<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CommandDepartment extends Pivot
{
    protected $fillable = ['department_id', 'command_id'];
}
