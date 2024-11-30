<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class WeddingCard extends Model
{
    protected $fillable = [
        'slug',
        'template_id',
        // Thông tin cơ bản
        'groom_name',
        'bride_name',
        'couple_email',
        // Ảnh đại diện
        'cover_image',
        'groom_image',
        'bride_image',
        // Thông tin gia đình
        'groom_father_name',
        'groom_mother_name',
        'bride_father_name',
        'bride_mother_name',
        // Thời gian và địa điểm
        'wedding_date',
        'venue_name',
        'venue_address',
        'google_map_iframe',
        'google_map',
        // Nội dung
        'wedding_poem',
        'qr_code',
        'is_active',
        'wedding_music_id',
        'lunar_wedding_date',
        'party_time',
        'price',
        'is_free',
        'is_hot',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'seo_title',
        'seo_description',
        'seo_image',
    ];

    protected $casts = [
        'wedding_date' => 'datetime',
        'lunar_wedding_date' => 'datetime',
        'party_time' => 'datetime',
        'is_active' => 'boolean',
        'is_free' => 'boolean',
        'is_hot' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(WeddingPhoto::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(WeddingRsvp::class);
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? Storage::url($this->cover_image) : null;
    }

    public function getGroomImageUrlAttribute()
    {
        return $this->groom_image ? Storage::url($this->groom_image) : null;
    }

    public function getBrideImageUrlAttribute()
    {
        return $this->bride_image ? Storage::url($this->bride_image) : null;
    }

    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code ? Storage::url($this->qr_code) : null;
    }

    public function music()
    {
        return $this->belongsTo(WeddingMusic::class, 'wedding_music_id');
    }

    public function getSeoImageUrlAttribute()
    {
        return $this->seo_image ? Storage::url($this->seo_image) : null;
    }
}
