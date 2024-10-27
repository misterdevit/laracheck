<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function outages()
    {
        return $this->hasMany(Outage::class);
    }

    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }
}
