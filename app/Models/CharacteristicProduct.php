<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacteristicProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['characteristic_id','product_id','value'];

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class);
    }
}
