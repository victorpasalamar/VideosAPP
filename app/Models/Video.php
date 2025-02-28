<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user_id
 * @method static findOrFail($id)
 */
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
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at->locale('ca')->isoFormat('D [de] MMMM [de] YYYY');
    }

    public function getFormattedForHumansPublishedAtAttribute()
    {
        return $this->published_at->locale('ca')->diffForHumans();
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
