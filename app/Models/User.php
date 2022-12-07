<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function receives()
    {
        return $this->hasMany(Receive::class);
    }

    public function sends()
    {
        return $this->hasMany(Send::class);
    }

    public function presents()
    {
        return $this->hasMany(Present::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function receiveview()
    {
        return $this->belongsToMany(Receive::class);
    }
}
