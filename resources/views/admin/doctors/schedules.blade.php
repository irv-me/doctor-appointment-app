<x-admin-layout
    title="Horarios del Doctor | MediMatch"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
        ['name' => 'Horarios'],
    ]"
>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        @livewire('admin.doctor-schedule-manager', ['doctor' => $doctor])
    </div>

</x-admin-layout>
