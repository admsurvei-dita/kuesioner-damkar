<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponderHealthHistory extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_dampak',
        'deskripsi_kronologi',
        'tahun_kejadian',
        'dampak_tugas'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}