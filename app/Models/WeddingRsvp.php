<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingRsvp extends Model
{
    protected $fillable = [
        'wedding_card_id',
        'guest_name',
        'phone_number',
        'number_of_guests',
        'is_attending',
        'message',
    ];

    protected $casts = [
        'number_of_guests' => 'integer',
        'is_attending' => 'boolean',
    ];

    public function weddingCard(): BelongsTo
    {
        return $this->belongsTo(WeddingCard::class);
    }
}
