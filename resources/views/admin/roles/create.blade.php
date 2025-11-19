<x-admin-layout 
    title="Create New Role"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'url'  => route('admin.dashboard')
        ],
        [
            'name' => 'Roles',
            'url'  => route('admin.roles.index')
        ],
        [
            'name' => 'Create'
        ]
    ]">

    {{-- Aquí va el contenido del formulario --}}
    <div class="p-4 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf {{-- Directiva de seguridad de Laravel --}}
            
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Role Name</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 font-bold text-blue-800 bg-blue-200 rounded hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow">
                    Save Role
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>