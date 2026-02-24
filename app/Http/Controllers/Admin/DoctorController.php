<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load(['user', 'speciality']);
        // Cast keys to strings — WireUI native-select needs string option values
        $specialities = Speciality::orderBy('name')
            ->get()
            ->mapWithKeys(fn($s) => [(string) $s->id => $s->name])
            ->toArray();
        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        // WireUI sends the option value as a string; parse it safely
        $raw = $request->input('speciality_id');
        $specialityId = (is_numeric($raw) && (int) $raw > 0) ? (int) $raw : null;
        $request->merge(['speciality_id' => $specialityId]);

        $validated = $request->validate([
            'speciality_id'          => 'nullable|integer',
            'medical_license_number' => 'nullable|string|max:255',
            'biography'              => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'title' => 'Doctor actualizado',
                'text'  => 'La información del doctor ha sido actualizada exitosamente.',
                'icon'  => 'success',
            ]);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();

        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'title' => 'Doctor eliminado',
                'text'  => 'El doctor ha sido eliminado exitosamente.',
                'icon'  => 'success',
            ]);
    }
}
