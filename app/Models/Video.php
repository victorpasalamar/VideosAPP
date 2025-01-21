<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'published_at',
        'previous',
        'next',
        'series_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Retorna la data publicada en format "13 de gener de 2025".
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->translatedFormat('d \d\e F \d\e Y')
            : null;
    }

    /**
     * Get the published_at date in a human-readable format like "fa 2 hores".
     *
     * @return string|null
     */
    public function getFormattedForHumansPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->diffForHumans()
            : null;
    }

    /**
     * Get the Unix timestamp of published_at.
     *
     * @return int|null
     */
    public function getPublishedAtTimestampAttribute(): ?int
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->timestamp
            : null;
    }
}
