<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait ModelScopeFilterTrait
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filters
     * @return mixed
     */
    public function scopeFilter(Builder $builder, $filters)
    {
        return $filters->apply($builder);
    }
}
