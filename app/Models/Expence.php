<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expence extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'amount',
        'description',
        'date',
    ];

    public function scopeFilterByCategoryAndSubCategory($query, $categoryId, $subCategoryId)
    {
        if (! is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! is_null($subCategoryId)) {
            $query->where('sub_category_id', $subCategoryId);
        }

        return $query;
    }

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(InventorySubCategory::class);
    }
}
