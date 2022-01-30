<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    public function messages(): HasMany
    {
        return $this->hasMany('App\Models\Message');
    }

    public function entries(): HasMany
    {
        return $this->hasMany('App\Models\Entry');
    }
}
