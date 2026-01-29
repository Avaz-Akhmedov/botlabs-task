<?php

namespace App\Models;

use App\Enums\CallResultEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    use  HasFactory;

    protected $fillable = [
        'lead_id',
        'duration',
        'result',
    ];


    protected $casts = [
        'result' => CallResultEnum::class
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
