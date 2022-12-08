<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['alt', 'title', 'url', 'sort', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getFullUrlAttribute()
    {
        if ($this->url) {
            return Storage::disk('admin')->url($this->url);
        }

        return null;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Image $image) {
            $storage = Storage::disk('admin');

            if ($image->url && $storage->exists($image->url)) {
                $storage->delete($image->url);
            }
        });
    }
}
