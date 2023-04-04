<?php

namespace App\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TeamSearchFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($query) use ($value) {
            $query->where('name', 'LIKE', '%' . $value . '%')
                ->orWhereHas('country', function ($query) use($value) {
                    $query->where('name', 'LIKE', '%'. $value . '%');
                });
        });
    }
}
