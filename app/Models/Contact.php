<?php

namespace App\Models;

use App\Casts\JsonCast;
use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, SlugTrait;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'phone', 'email', 'address', 'addresses', 'operating_mode', 'is_active', 'sort', 'coords', 'zoom'];

    protected $casts = [
        'is_active' => 'boolean',
        'operating_mode' => JsonCast::class,
        'coords' => JsonCast::class,
        'addresses' => JsonCast::class,
    ];

    public function setOperatingModeAttribute($values)
    {
        if (is_array($values)) {
            $this->attributes['operating_mode'] = json_encode(getOperationMode($values));
        } else {
            $this->attributes['operating_mode'] = null;
        }
    }

    /**
     * Сео
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable')->withDefault();
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            self::setSlug($model);
        });

        static::updating(function ($model) {
            self::setSlug($model);
        });

        static::deleting(function (Contact $contact) {
            // Удаляем изображения товара
            $contact->images()->get()->each(function (Image $image) { $image->delete(); });
            // Удаляем SEO
            if ($contact->seo) {
                $contact->seo->delete();
            }
        });
    }
}
