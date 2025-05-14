<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'font_size',
        'high_contrast',
        'reduce_motion',
        'theme_color'
    ];

    protected $casts = [
        'high_contrast' => 'boolean',
        'reduce_motion' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 