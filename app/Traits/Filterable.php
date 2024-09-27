<?php

namespace App\Traits;

use Carbon\Carbon;

trait Filterable
{
    /**
     * Filter results by active status.
     */
    public function scopeStatusActive($query,$status)
    {
        return $query->where('status', $status);
    }
 
    /**
     * Filter results by term
     */
    public function scopeSearchName($query, $term)
    {
        if ($term) {
            return $query->where('name', 'LIKE', '%'.$term.'%');
        }

        return $query;
    }

    /**
     * Filter results by a date range between start and end date.
     */
    public function scopeDateBetween($query, $startDate = null, $endDate = null)
    {

        if (($startDate && $endDate) && $startDate != '' && $endDate != '') {
            // Convert to Carbon instances to ensure date format
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            return $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query;
    }
}
