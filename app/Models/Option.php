<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = ['question_id', 'text_pilihan', 'parameter_type', 'score_value'];

    /**
     * Relationship ke Question (Pertanyaan yang dimiliki option ini)
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relationship ke Answers (Jawaban yang menggunakan option ini)
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}