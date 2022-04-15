<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pref_id',
        'title',
        'body',
        'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'likes')->withTimestamps();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function getPrefNameAttribute()
    {
        return config('pref.' . $this->pref_id);
    }

    public function scopeSearchFilter($query, string $search = null)
    {
        if (!$search) {
            return $query;
        }

        return $query->where('title', 'LIKE', "%{$search}%")
        ->orWhere('body', 'LIKE', "%{$search}%");
    }

    public function scopePrefFilter($query, string $pref = null)
    {
        if (!$pref) {
            return $query;
        }

        return $query->where('pref_id', $pref);
    }
}