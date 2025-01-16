<?php

namespace App\Models;

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
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->isoFormat('D [de] MMMM [de] YYYY') : null;
    }

    /**
     * Retorna la data publicada en format "fa 2 hores".
     */
    public function getFormattedForHumansPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->diffForHumans() : null;
    }
}
