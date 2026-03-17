<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('callmebot.url', 'https://api.callmebot.com/whatsapp.php');
    }

    /**
     * Send an immediate booking confirmation via WhatsApp (CallMeBot).
     */
    public function sendConfirmation(Appointment $appointment): void
    {
        $appointment->loadMissing(['patient.user', 'doctor.user']);

        $user   = $appointment->patient->user;
        $phone  = $user->phone ?? null;
        $apiKey = $user->callmebot_api_key ?? null;

        if (empty($phone) || empty($apiKey)) {
            Log::warning('WhatsApp confirmation skipped: missing phone or CallMeBot API key.', [
                'appointment_id' => $appointment->id,
            ]);
            return;
        }

        $patientName = $user->name;
        $doctorName  = $appointment->doctor->user->name;
        $date        = $appointment->date->format('d/m/Y');
        $time        = $appointment->start_time;

        $body = "✅ Confirmación de Cita — MediMatch\n\n"
              . "Hola, {$patientName} 👋\n"
              . "Tu cita médica ha sido registrada exitosamente.\n\n"
              . "📅 Fecha: {$date}\n"
              . "🕐 Hora: {$time}\n"
              . "👨‍⚕️ Doctor: {$doctorName}\n\n"
              . "Por favor, llega 10 minutos antes.";

        $this->send($phone, $apiKey, $body, $appointment->id);
    }

    /**
     * Send a 24-hour reminder via WhatsApp (CallMeBot).
     */
    public function sendReminder(Appointment $appointment): void
    {
        $appointment->loadMissing(['patient.user', 'doctor.user']);

        $user   = $appointment->patient->user;
        $phone  = $user->phone ?? null;
        $apiKey = $user->callmebot_api_key ?? null;

        if (empty($phone) || empty($apiKey)) {
            Log::warning('WhatsApp reminder skipped: missing phone or CallMeBot API key.', [
                'appointment_id' => $appointment->id,
            ]);
            return;
        }

        $patientName = $user->name;
        $doctorName  = $appointment->doctor->user->name;
        $date        = $appointment->date->format('d/m/Y');
        $time        = $appointment->start_time;

        $body = "⏰ Recordatorio de Cita — MediMatch\n\n"
              . "Hola, {$patientName} 👋\n"
              . "Mañana tienes una cita médica.\n\n"
              . "📅 Fecha: {$date}\n"
              . "🕐 Hora: {$time}\n"
              . "👨‍⚕️ Doctor: {$doctorName}\n\n"
              . "¡Te esperamos! Llega 10 minutos antes.";

        $this->send($phone, $apiKey, $body, $appointment->id);
    }

    /**
     * Internal: performs the GET request to the CallMeBot API.
     */
    private function send(string $phone, string $apiKey, string $body, int $appointmentId): void
    {
        try {
            $response = Http::get($this->baseUrl, [
                'phone'  => $phone,
                'text'   => $body,
                'apikey' => $apiKey,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp (CallMeBot) sent to {$phone}", [
                    'appointment_id' => $appointmentId,
                ]);
            } else {
                Log::error("WhatsApp (CallMeBot) failed: HTTP {$response->status()}", [
                    'appointment_id' => $appointmentId,
                    'response'       => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp (CallMeBot) exception: {$e->getMessage()}", [
                'appointment_id' => $appointmentId,
            ]);
        }
    }
}
