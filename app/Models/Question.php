<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'klaster',
        'sub_klaster',
        'text_pertanyaan',
        'target_kelompok',
        'type',
    ];

    protected $casts = ['target_kelompok' => 'array'];

    /**
     * Relationship ke Options (Pilihan jawaban untuk pertanyaan ini)
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Relationship ke Answers (Jawaban dari responden untuk pertanyaan ini)
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}