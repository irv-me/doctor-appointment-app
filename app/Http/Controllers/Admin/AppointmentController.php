<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $patients = Patient::with('user')->get()->mapWithKeys(
            fn($p) => [$p->id => $p->user->name]
        )->toArray();

        $doctors = Doctor::with('user')->get()->mapWithKeys(
            fn($d) => [$d->id => $d->user->name]
        )->toArray();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string|max:1000',
        ], [
            'date.after_or_equal' => 'La fecha de la cita no puede ser anterior a hoy.',
            'end_time.after'      => 'La hora de fin debe ser posterior a la hora de inicio.',
            'patient_id.required' => 'Debe seleccionar un paciente.',
            'doctor_id.required'  => 'Debe seleccionar un doctor.',
        ]);

        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id'  => $validated['doctor_id'],
            'date'       => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time'   => $validated['end_time'],
            'reason'     => $validated['reason'] ?? null,
            'status'     => 1,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => 'Cita registrada',
                'text'  => 'La cita ha sido registrada exitosamente.',
                'icon'  => 'success',
            ]);
    }

    /**
     * Load the consultation view for a given appointment.
     */
    public function consult(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'patient.bloodType', 'doctor.user', 'consultation']);
        return view('admin.appointments.consult', compact('appointment'));
    }
}
