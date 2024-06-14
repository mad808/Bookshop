<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public static function withCount($string)
    {
    }


    public function kitaps(): HasMany
    {
        return $this->hasMany(Kitap::class);
    }
}
