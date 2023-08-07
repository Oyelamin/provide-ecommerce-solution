<?php

namespace App\Models;

use App\Support\Enums\ItemStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'price',
        'admin_id',
        'currency',
        'status',
        'total_stocked',
        'available_stock',
        'last_stocked'
    ];

    public function scopeByPriceRange($query, $min, $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByStatus(Builder $query, int $value): Builder
    {
        if($value == ItemStatusEnum::DELETED->value){
            return $query->onlyTrashed();
        }
        return $query->where('status', $value);
    }

}
