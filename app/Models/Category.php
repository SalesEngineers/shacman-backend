<?php

namespace App\Models;

use App\Casts\JsonCast;
use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, SlugTrait;

    protected $fillable = ['name', 'url', 'content', 'is_tag', 'is_active', 'sort', 'video', 'videos'];

    protected $casts = [
        'is_tag' => 'boolean',
        'is_active' => 'boolean',
        'videos' => JsonCast::class,
    ];

    public function scopeOnlyParents(Builder $builder)
    {
        return $builder->where('pid', null);
    }

    public function scopeOnlyActive(Builder $builder)
    {
        return $builder->where('is_active', true);
    }

    /**
     * Получаем список дочерних категорий
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'pid')->orderBy('sort', 'asc');
    }

    /**
     * Получить родителя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'pid');
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

    /**
     * Изображение категории
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Акция
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Товары
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories')->orderBy('sort', 'desc');
    }

    /**
     * Фильтры товаров
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function filters()
    {
        return $this->belongsToMany(Characteristic::class, 'filter_categories');
    }

    /**
     * Характеристики товаров
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'characteristic_categories');
    }

    public function mainCharacteristicIds()
    {
        return $this->characteristics()->select('id');
    }

    public function gallery()
    {
        return $this->belongsToMany(Gallery::class, 'gallery_categories');
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
            // Удаляем изображение
            if ($model->image) {
                $model->image->delete();
            }

            // Удаляем сео
            if ($model->seo) {
                $model->seo->delete();
            }
        });
    }
}
