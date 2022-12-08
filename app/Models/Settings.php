<?php

namespace App\Models;

use App\Casts\JsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'social_networks' => JsonCast::class,
        'operating_mode' => JsonCast::class
    ];

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }
}
