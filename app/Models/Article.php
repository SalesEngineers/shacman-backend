<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, SlugTrait;

    public $timestamps = false;

    protected $fillable = ['name','url','content','published_at','is_main'];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    /**
     * Вертикальное изображение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function imageVertical()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_vertical', true);
    }

    /**
     * Горизонтальное изображение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function imageHorizontal()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_horizontal', true);
    }

    /**
     * Сео
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            self::setSlug($model);
        });

        static::updating(function ($model) {
            self::setSlug($model);
        });

        static::deleting(function ($model) {
            if ($model->imageVertical) {
                $model->imageVertical->delete();
            }

            if ($model->imageHorizontal) {
                $model->imageHorizontal->delete();
            }

            if ($model->seo) {
                $model->seo->delete();
            }
        });
    }
}
