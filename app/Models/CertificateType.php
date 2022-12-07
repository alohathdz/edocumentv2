<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}