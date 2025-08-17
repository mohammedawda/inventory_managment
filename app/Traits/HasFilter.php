<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Apply dynamic filtering and searching on the query.
 *
 * This scope uses three model-defined arrays: `$filterable` for exact match filters
 * and `$searchable` for general LIKE-based search
 * and `$filterRange` for get matched rows on range.
 *
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @param \Illuminate\Http\Request|null $request
 * @return \Illuminate\Database\Eloquent\Builder
*/

trait HasFilter
{
    public function scopeFilter(Builder $query, ?Request $request = null): Builder
    {
        $request = $request ?? request();
        
        // Apply column-wise exact filters
        if(property_exists($this, 'filterable') && !empty($this->filterable)) {
            foreach ($this->filterable ?? [] as $column) {
                if ($request->filled($column))
                    $query->where($column, $request->$column);
            }
        }

        // Apply LIKE-based search on all searchable fields
        if ($request->filled('search') && property_exists($this, 'searchable')) {
            $query->where(function ($q) use ($request) {
                foreach ($this->searchable as $column)
                    $q->orWhere($column, 'like', '%' . $request->search . '%');
            });
        }

        // Apply filter range on all filterRange fields
        if (property_exists($this, 'filterRange') && !empty($this->filterRange)) {
            foreach($this->filterRange as $column => $request_key) {
                if ($request->has($request_key['from']) || $request->has($request_key['to'])) {
                    
                    if ($request->has($request_key['from']))
                        $query->where($column, '>=', $request->input($request_key['from']));

                    if ($request->has($request_key['to']))
                        $query->where($column, '<=', $request->input($request_key['to']));

                }
            }
        }

        return $query;
    }

    protected function applyCustomFilterOnCollection($collection, array $filters)
    {
        if(empty($filters))
            return $collection;

        foreach($filters as $column => $value) {
            $collection = $collection->where($column, $value);
        }
        return $collection;
    }

    protected function applyCustomSearchOnCollection($collection, array $filters)
    {
        if(empty($filters))
            return $collection;

        foreach($filters as $column => $value) {
            $collection = $collection->where($column, $value);
        }
        return $collection;
    }
}
