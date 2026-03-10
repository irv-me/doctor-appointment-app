<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use Livewire\Component;

class DoctorScheduleManager extends Component
{
    public Doctor $doctor;

    /** Selected slots: ['monday' => ['08:00-08:15', '08:15-08:30', ...], ...] */
    public array $selected = [];

    /** Week days displayed */
    public array $days = [
        'monday'    => 'Lunes',
        'tuesday'   => 'Martes',
        'wednesday' => 'Miércoles',
        'thursday'  => 'Jueves',
        'friday'    => 'Viernes',
    ];

    /** Time range */
    public string $startHour = '08:00';
    public string $endHour   = '18:00';
    public int    $interval  = 15; // minutes

    public function mount(Doctor $doctor): void
    {
        $this->doctor = $doctor->load(['user', 'speciality']);

        // Pre-populate from stored schedule
        $saved = $this->doctor->schedule ?? [];
        foreach (array_keys($this->days) as $day) {
            $this->selected[$day] = $saved[$day] ?? [];
        }
    }

    /** Generate 15-min slots for a given hour block (e.g. "08:00" → ['08:00-08:15', '08:15-08:30',...]) */
    public function slotsForHour(string $hour): array
    {
        [$h, $m] = explode(':', $hour);
        $slots = [];
        $base = ($h * 60) + $m;
        for ($i = 0; $i < 60; $i += $this->interval) {
            $start = $base + $i;
            $end   = $start + $this->interval;
            $slots[] = sprintf('%02d:%02d-%02d:%02d', intdiv($start, 60), $start % 60, intdiv($end, 60), $end % 60);
        }
        return $slots;
    }

    /** All hour blocks (08:00, 09:00, …, 17:00) */
    public function hourBlocks(): array
    {
        [$sh, $sm] = explode(':', $this->startHour);
        [$eh, $em] = explode(':', $this->endHour);
        $blocks = [];
        $current = (int)$sh * 60 + (int)$sm;
        $end     = (int)$eh * 60 + (int)$em;
        while ($current < $end) {
            $blocks[] = sprintf('%02d:%02d', intdiv($current, 60), $current % 60);
            $current += 60;
        }
        return $blocks;
    }

    /** Toggle a single 15-min slot */
    public function toggleSlot(string $day, string $slot): void
    {
        if (in_array($slot, $this->selected[$day] ?? [])) {
            $this->selected[$day] = array_values(array_diff($this->selected[$day], [$slot]));
        } else {
            $this->selected[$day][] = $slot;
        }
    }

    /** Toggle all slots in the entire day */
    public function toggleAllDay(string $day): void
    {
        $all = [];
        foreach ($this->hourBlocks() as $hour) {
            foreach ($this->slotsForHour($hour) as $slot) {
                $all[] = $slot;
            }
        }
        if (count($this->selected[$day] ?? []) === count($all)) {
            $this->selected[$day] = [];
        } else {
            $this->selected[$day] = $all;
        }
    }

    /** Toggle all slots for a specific hour across the given day */
    public function toggleHourForDay(string $day, string $hour): void
    {
        $slots = $this->slotsForHour($hour);
        $current = $this->selected[$day] ?? [];
        $allSet = empty(array_diff($slots, $current));
        if ($allSet) {
            $this->selected[$day] = array_values(array_diff($current, $slots));
        } else {
            $this->selected[$day] = array_values(array_unique(array_merge($current, $slots)));
        }
    }

    /** Toggle all days for a specific hour block ("Todos" checkbox on hour row) */
    public function toggleHourAllDays(string $hour): void
    {
        $slots = $this->slotsForHour($hour);
        // Check if all days have all slots for this hour
        $allSet = true;
        foreach (array_keys($this->days) as $day) {
            if (!empty(array_diff($slots, $this->selected[$day] ?? []))) {
                $allSet = false;
                break;
            }
        }
        foreach (array_keys($this->days) as $day) {
            if ($allSet) {
                $this->selected[$day] = array_values(array_diff($this->selected[$day] ?? [], $slots));
            } else {
                $this->selected[$day] = array_values(array_unique(array_merge($this->selected[$day] ?? [], $slots)));
            }
        }
    }

    public function saveSchedule(): void
    {
        $this->doctor->update(['schedule' => $this->selected]);
        session()->flash('success', 'Horario guardado exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule-manager', [
            'hourBlocks' => $this->hourBlocks(),
        ]);
    }
}
