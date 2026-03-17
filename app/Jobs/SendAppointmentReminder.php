<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAppointmentReminder implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly Appointment $appointment)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsApp): void
    {
        // Only send if the appointment is still scheduled (status = 1)
        if ($this->appointment->status !== 1) {
            return;
        }

        $whatsApp->sendReminder($this->appointment);
    }
}
