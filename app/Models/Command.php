<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'date',
        'topic',
        'number',
        'file',
        'user_id',
        'folder_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
