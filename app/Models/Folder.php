<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receives()
    {
        return $this->hasMany(Receive::class);
    }

    public function presents()
    {
        return $this->hasMany(Present::class);
    }

    public function sends()
    {
        return $this->hasMany(Send::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
