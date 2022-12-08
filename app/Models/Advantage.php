<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advantage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'image_url', 'image_alt', 'image_title', 'sort', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getImageFullUrlAttribute()
    {
        if ($this->image_url) {
            return Storage::disk('admin')->url($this->image_url);
        }

        return null;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Advantage $advantage) {
            $storage = Storage::disk('admin');

            if ($storage->exists($advantage->image_url)) {
                $storage->delete($advantage->image_url);
            }
        });
    }
}
