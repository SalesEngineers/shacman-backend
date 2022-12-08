<?php

namespace App\Models;

use App\Casts\JsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dimension extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['width', 'height', 'length', 'images'];

    protected $casts = [
        'images' => JsonCast::class
    ];

    public function getImageListAttribute()
    {
        if (is_array($this->images) === false) return null;

        return array_map(function ($image) {
            return Storage::disk('admin')->url($image);
        }, $this->images);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Dimension $dimension) {
            $storage = Storage::disk('admin');

            if (is_array($dimension->images)) {
                foreach ($dimension->images as $image) {
                    if ($storage->exists($image)) {
                        $storage->delete($image);
                    }
                }
            }
        });
    }
}
