<?php

namespace App\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TicketCostFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == 'free') {
            $query->free();
        } elseif ($value == 'paid') {
            $query->paid();
        }
    }
}
