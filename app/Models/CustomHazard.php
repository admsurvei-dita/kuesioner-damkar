<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomHazard extends Model
{
    protected $fillable = ['user_id', 'kategori_bahaya', 'deskripsi_bahaya', 'frekuensi_kejadian'];

    /**
     * Relationship ke User (Responden yang membuat custom hazard)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
