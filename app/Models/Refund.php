<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'sale_id',
        'user_id',
        'amount',
        'reason',
        'refund_date',
        'status'
    ];

    protected $casts = [
        'refund_date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 