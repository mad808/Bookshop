<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'admin',
        'name',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'admin',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public $timestamps = false;

    public function getImage()
    {
        return $this->image ? Storage::url('img/' . $this->image) : asset('img/1.jpg');
    }
}
