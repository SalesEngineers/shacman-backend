<?php

namespace App\Models;

use App\Casts\JsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'phone', 'email', 'address', 'operating_mode', 'is_active', 'sort', 'coords', 'zoom'];

    protected $casts = [
        'is_active' => 'boolean',
        'operating_mode' => JsonCast::class,
        'coords' => JsonCast::class,
    ];

    public function setOperatingModeAttribute($values)
    {
        if (is_array($values)) {
            $this->attributes['operating_mode'] = json_encode(getOperationMode($values));
        } else {
            $this->attributes['operating_mode'] = null;
        }
    }
}
