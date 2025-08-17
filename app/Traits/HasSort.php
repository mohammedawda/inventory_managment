<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Apply dynamic sorting on the query.
 *
 * This scope uses one model-defined arrays: `$sortable` for desired sorted column
 *
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @param \Illuminate\Http\Request|null $request
 * @return \Illuminate\Database\Eloquent\Builder
*/

trait HasSort
{
    public function scopeSort(Builder $query, ?Request $request = null): Builder
    {
        $request = $request ?? request();
        
        // Sort by specified field
        if ($request->filled('sort_by')) {
            $query->orderBy(
                $request->sort_by,
                $request->sort_dir ?? 'asc'
            );
        }

        return $query;
    }
}
