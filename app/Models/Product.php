<?php

namespace App\Models;

use App\Traits\ModelScopeFilterTrait;
use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SlugTrait, ModelScopeFilterTrait;
    /**
     * Спецтехника
     */
    const TYPE_SPECIAL_MACHINERY = 0;
    /**
     * Оборудование
     */
    const TYPE_ATTACHED_EQUIPMENT = 1;

    protected $fillable = ['name', 'url', 'type', 'content', 'video'];

    /**
     * Получить товар для категории
     *
     * @param Builder $builder
     * @param $category_id
     *
     * @return Builder
     */
    public function scopeForCategory(Builder $builder, $category_id)
    {
        return $builder->rightJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
                       ->where('product_categories.category_id', $category_id);
    }

    /**
     * SEO
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    /**
     * Список изображений
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('sort', 'asc');
    }

    /**
     * Первое изображение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->orderBy('sort', 'asc');
    }

    /**
     * Категории
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * Лейблы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_products', 'product_id', 'label_id');
    }

    /**
     * Габариты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dimension()
    {
        return $this->hasOne(Dimension::class);
    }

    /**
     * Преимущества
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advantages()
    {
        return $this->hasMany(Advantage::class, 'product_id')->orderBy('sort', 'asc');
    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable')->orderBy('sort', 'asc');
    }

    /**
     * Характеристики
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characteristics()
    {
        return $this->hasMany(CharacteristicProduct::class);
    }

    /**
     * Навесное оборудование
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function equipments()
    {
        return $this->belongsToMany(Product::class, 'product_products', 'object_id', 'product_id');
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

        static::deleting(function (Product $product) {
            // Удаляем изображения товара
            $product->images()->get()->each(function (Image $image) { $image->delete(); });
            // Удаляем файлы товара
            $product->attachments()->get()->each(function (Attachment $attachment) { $attachment->delete(); });
            // Удаляем SEO
            if ($product->seo) {
                $product->seo->delete();
            }
            // Удаляем изображения у габаритов
            event('eloquent.deleting: ' . Dimension::class, $product->dimension);
            // Удалить изображения у преимуществ
            $product->advantages()->get()->each(function (Advantage $advantage) {
                event('eloquent.deleting: ' . Advantage::class, $advantage);
            });
        });
    }
}
