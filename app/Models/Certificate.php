<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'date',
        'name',
        'number',
        'file',
        'certificate_type_id',
        'user_id',
        'folder_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificateType()
    {
        return $this->belongsTo(CertificateType::class);
    }
}
