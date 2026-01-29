<?php

namespace App\Models;

use App\Enums\LeadStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'status',
        'manager_id',
    ];

    protected $casts = [
        'status' => LeadStatusEnum::class
    ];

    protected $attributes = [
        'status' => LeadStatusEnum::NEW
    ];


    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class);
    }
}
