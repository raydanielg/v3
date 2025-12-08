<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    protected $fillable = [
        'region_id',
        'district_id',
        'name',
        'code',
        'headmaster_id',
        'center_supervisor_id',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function headmaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'headmaster_id');
    }

    public function centerSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'center_supervisor_id');
    }
}
