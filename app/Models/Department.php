<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'initial',
        'line_token'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function receives()
    {
        return $this->hasMany(Receive::class);
    }

    public function presents()
    {
        return $this->hasMany(Present::class);
    }
}