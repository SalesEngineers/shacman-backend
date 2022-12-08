<?php

namespace App\Models;

use App\Casts\JsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOrder extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $casts = [
        'fields' => JsonCast::class,
        'labels' => JsonCast::class
    ];

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // Удаляем файл
            if ($model->attachment) {
                $model->attachment->delete();
            }
        });
    }
}
