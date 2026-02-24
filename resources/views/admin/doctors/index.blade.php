<x-admin-layout
    title="Doctores | MediMatch"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
        ],
    ]"
>
    @livewire('admin.data-tables.doctor-table')

</x-admin-layout>
