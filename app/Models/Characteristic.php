<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name','is_active','is_main','is_product_card','sort'];

    protected $casts = [
        'is_product_card' => 'boolean',
        'is_main' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function options()
    {
        return $this->hasMany(CharacteristicProduct::class)
            ->leftJoin("product_categories", "product_categories.product_id", "=", "characteristic_products.product_id")
            ->where("product_categories.category_id", $this->pivot->category_id);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_characteristic');
    }
}
