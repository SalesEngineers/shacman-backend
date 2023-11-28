<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'group_characteristic');
    }
}
