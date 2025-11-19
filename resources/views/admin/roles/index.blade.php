<x-admin-layout 
    title="Roles"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['name' => 'Roles',     'url' => route('admin.roles.index')],
    ]"
>
    <section class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg">
        
        <div class="flex items-center justify-between mb-6">
            
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Roles
            </h1>

        
            <a
                href="{{ route('admin.roles.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition-colors duration-150"
            >
                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                
                Nuevo
            </a>
        </div>

        @livewire('admin.datatables.role-table')
        
    </section>
</x-admin-layout>
