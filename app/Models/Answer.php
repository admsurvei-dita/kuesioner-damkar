<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
        'score_e',
        'score_p',
        'score_c',
        'text_jawaban_manual'
    ];

    /**
     * Relationship ke User (Responden yang menjawab)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship ke Question (Pertanyaan yang dijawab)
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relationship ke Option (Pilihan jawaban yang dipilih)
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
