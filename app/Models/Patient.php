<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_type_id',
        'date_of_birth',
        'gender',
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_relationship',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Obtener el usuario asociado al paciente.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el tipo de sangre del paciente.
     */
    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    /**
     * Citas del paciente.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Consultas del paciente a través de sus citas.
     */
    public function consultations(): HasManyThrough
    {
        return $this->hasManyThrough(Consultation::class, Appointment::class);
    }
}
