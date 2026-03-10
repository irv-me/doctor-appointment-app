<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Consultation;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;

    // Consulta fields
    public string $diagnosis = '';
    public string $treatment = '';
    public string $notes = '';

    // Receta fields
    public array $medications = [];

    // Modal toggles
    public bool $showHistoryModal = false;
    public bool $showConsultationsModal = false;

    public function mount(Appointment $appointment): void
    {
        $this->appointment = $appointment;
        $this->appointment->load(['patient.user', 'patient.bloodType', 'doctor.user', 'consultation',
            'patient.consultations.appointment.doctor.user']);

        // Pre-fill if a consultation already exists
        if ($this->appointment->consultation) {
            $this->diagnosis  = $this->appointment->consultation->diagnosis ?? '';
            $this->treatment  = $this->appointment->consultation->treatment ?? '';
            $this->notes      = $this->appointment->consultation->notes ?? '';
            $this->medications = $this->appointment->consultation->medications ?? [];
        }

        if (empty($this->medications)) {
            $this->medications = [['name' => '', 'dose' => '', 'frequency' => '']];
        }
    }

    public function addMedication(): void
    {
        $this->medications[] = ['name' => '', 'dose' => '', 'frequency' => ''];
    }

    public function removeMedication(int $index): void
    {
        array_splice($this->medications, $index, 1);
        if (empty($this->medications)) {
            $this->medications = [['name' => '', 'dose' => '', 'frequency' => '']];
        }
    }

    public function saveConsultation(): void
    {
        $this->validate([
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes'     => 'nullable|string',
        ]);

        // Filter out completely empty medication rows
        $meds = collect($this->medications)
            ->filter(fn($m) => !empty($m['name']))
            ->values()
            ->toArray();

        Consultation::updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis'   => $this->diagnosis ?: null,
                'treatment'   => $this->treatment ?: null,
                'notes'       => $this->notes ?: null,
                'medications' => $meds ?: null,
            ]
        );

        // Mark appointment as completed
        $this->appointment->update(['status' => 2]);

        session()->flash('success', 'Consulta guardada exitosamente.');
        $this->redirect(route('admin.appointments.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
