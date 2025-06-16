<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Space extends Model
{
    protected $fillable = [
        'name',
        'layout'
    ];

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class, 'space_id');
    }
}
