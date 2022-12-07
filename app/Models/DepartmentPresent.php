<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DepartmentPresent extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'present_id',
    ];
}
