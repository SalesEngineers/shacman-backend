<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['url','name','is_active','sort'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getFullUrlAttribute()
    {
        if ($this->url) {
            return Storage::disk('admin')->url($this->url);
        }

        return null;
    }

    public function attachmentable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Attachment $attachment) {
            $storage = Storage::disk('admin');

            if ($attachment->url && $storage->exists($attachment->url)) {
                $storage->delete($attachment->url);
            }
        });
    }
}
