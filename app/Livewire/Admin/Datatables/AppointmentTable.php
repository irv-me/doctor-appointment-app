<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    protected $model = Appointment::class;

    public function builder(): Builder
    {
        return Appointment::query()->with(['patient.user', 'doctor.user']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('Paciente', 'patient.user.name')
                ->sortable()
                ->searchable(),
            Column::make('Doctor', 'doctor.user.name')
                ->sortable()
                ->searchable(),
            Column::make('Fecha', 'date')
                ->sortable()
                ->format(fn($value) => $value ? $value->format('d/m/Y') : '-'),
            Column::make('Hora', 'start_time')
                ->sortable(),
            Column::make('Hora Fin', 'end_time')
                ->sortable(),
            Column::make('Estado', 'status')
                ->sortable()
                ->format(fn($value) => match ($value) {
                    1 => 'Programado',
                    2 => 'Completado',
                    3 => 'Cancelado',
                    default => 'Desconocido',
                }),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.appointments.actions', ['appointment' => $row])),
        ];
    }
}
