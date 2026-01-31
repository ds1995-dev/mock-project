<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'item_id',
        'buyer_id',
        'seller_id',
        'price',
        'status',
        'postal_code',
        'address',
        'building',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
