<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sales extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'status',
        'notes'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SalesItem::class, 'sale_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
