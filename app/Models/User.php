<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'status_kepegawaian', 'kelompok_responden', 'unit_kerja', 'role', 'is_completed'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship ke Answers (Jawaban survei dari user)
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Relationship ke CustomHazards (Bahaya khas yang dilaporkan user)
     */
    public function customHazards()
    {
        return $this->hasMany(CustomHazard::class);
    }
    public function healthHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ResponderHealthHistory::class);
    }
}
