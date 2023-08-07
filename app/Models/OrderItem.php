<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'order_id',
        'quantity'
    ];

    protected $table = 'order_items';

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
