<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'medical_license_number',
        'biography',
        'schedule',
    ];

    protected $casts = [
        'schedule' => 'array',
    ];

    /**
     * El usuario asociado al doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La especialidad del doctor.
     */
    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    /**
     * Citas del doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
