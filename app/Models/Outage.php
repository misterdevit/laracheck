<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outage extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'occurred_at',
        'resolved_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getDurationAttribute()
    {
        $duration = 'In outage since '.$this->occurred_at->since();

        if ($this->resolved_at) {
            $duration = $duration = $this->occurred_at->diff($this->resolved_at);
        }

        return $duration;
    }

    public function getStatusAttribute()
    {
        if ($this->resolved_at) {
            return true;
        }

        return false;
    }
}
