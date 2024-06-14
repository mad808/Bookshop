<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kitap extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function booklang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booklang::class);
    }

    public function image()
    {
        if ($this->image) {
            return Storage::url('public/cars/' . $this->image);
        } else {
            return $this->image ? asset('img/'. $this->image) : asset('img/123.jpg');
        }
    }
}
