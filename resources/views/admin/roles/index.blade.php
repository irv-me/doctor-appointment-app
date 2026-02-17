@php
    $title = 'Roles';
    $breadcrumbs = [
        ['name' => 'Inicio', 'href' => route('dashboard')],
        ['name' => 'Roles', 'href' => route('admin.roles.index')],
    ];
@endphp

@component('layouts.admin', ['title' => $title, 'breadcrumbs' => $breadcrumbs])
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Roles</h2>
            <a href="{{ route('admin.roles.create') }}" class="inline-block px-3 py-1 bg-blue-600 text-white rounded">Crear rol</a>
        </div>

        <livewire:admin.datatables.role-table />
    </div>
@endcomponent
