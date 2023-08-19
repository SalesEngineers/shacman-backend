<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * Список изображений
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('sort', 'asc');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Gallery $gallery) {
            $gallery->images()->get()->each(function (Image $image) { $image->delete(); });
        });
    }
}
