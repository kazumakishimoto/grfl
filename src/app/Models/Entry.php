<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function rooms(): BelongsTo
    {
        return $this->belongsTo('App\Models\Room')->withTimestamps();
    }
}
