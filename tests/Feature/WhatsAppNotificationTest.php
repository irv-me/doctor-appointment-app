<?php

use App\Jobs\SendAppointmentReminder;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

/**
 * Create a patient + doctor pair ready for appointment tests.
 */
function makePatientAndDoctor(): array
{
    $patientUser = User::factory()->create([
        'phone'              => '+521234567890',
        'callmebot_api_key'  => 'test-api-key-123',
    ]);
    $doctorUser = User::factory()->create();

    $patient = Patient::factory()->create(['user_id' => $patientUser->id]);
    $doctor  = Doctor::factory()->create(['user_id' => $doctorUser->id]);

    return [$patient, $doctor];
}

// ---------------------------------------------------------------------------
// Job dispatch tests
// ---------------------------------------------------------------------------

it('dispatches SendAppointmentReminder job when appointment is 5+ days away', function () {
    Bus::fake();
    Http::fake(); // prevent real HTTP calls

    [$patient, $doctor] = makePatientAndDoctor();
    $admin = User::factory()->create();

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id'  => $doctor->id,
        'date'       => Carbon::now()->addDays(5)->format('Y-m-d'),
        'start_time' => '10:00',
        'end_time'   => '10:30',
        'reason'     => 'Revisión general',
    ])->assertRedirect(route('admin.appointments.index'));

    $this->assertDatabaseHas('appointments', [
        'patient_id' => $patient->id,
        'status'     => 1,
    ]);

    Bus::assertDispatched(SendAppointmentReminder::class);
});

it('does not dispatch reminder job when appointment date is today (no 24h gap)', function () {
    Bus::fake();
    Http::fake();

    [$patient, $doctor] = makePatientAndDoctor();
    $admin = User::factory()->create();

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id'  => $doctor->id,
        'date'       => Carbon::now()->format('Y-m-d'),
        'start_time' => '10:00',
        'end_time'   => '10:30',
        'reason'     => null,
    ]);

    Bus::assertNotDispatched(SendAppointmentReminder::class);
});

// ---------------------------------------------------------------------------
// CallMeBot HTTP call test
// ---------------------------------------------------------------------------

it('hits the CallMeBot API when an appointment is created', function () {
    Bus::fake();

    // Fake HTTP so we intercept the CallMeBot GET request
    Http::fake([
        'api.callmebot.com/*' => Http::response('Message queued.', 200),
    ]);

    [$patient, $doctor] = makePatientAndDoctor();
    $admin = User::factory()->create();

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id'  => $doctor->id,
        'date'       => Carbon::now()->addDays(5)->format('Y-m-d'),
        'start_time' => '09:00',
        'end_time'   => '09:30',
        'reason'     => null,
    ]);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'api.callmebot.com')
            && str_contains($request->url(), 'apikey=test-api-key-123');
    });
});
