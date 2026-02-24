<x-admin-layout
    title="Editar Doctor | MediMatch"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
            'href' => route('admin.doctors.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ]"
>
    {{-- Header Card --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                {{-- Initials avatar --}}
                @php
                    $words = explode(' ', trim($doctor->user->name));
                    $initials = strtoupper(
                        (isset($words[0]) ? mb_substr($words[0], 0, 1) : '') .
                        (isset($words[1]) ? mb_substr($words[1], 0, 1) : '')
                    );
                @endphp
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 text-xl font-bold select-none">
                    {{ $initials }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $doctor->user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}
                        &nbsp;&bull;&nbsp;
                        Biografía: {{ $doctor->biography ? 'Registrada' : 'N/A' }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.doctors.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    Volver
                </a>
                <button type="submit" form="edit-doctor-form"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300">
                    <i class="fa-solid fa-check"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>

    {{-- Formulario limpio (sin pestañas) --}}
    <x-wire-card>
        <form id="edit-doctor-form" action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-5">

                {{-- Especialidad --}}
                <div class="space-y-1">
                    <x-wire-native-select
                        label="Especialidad"
                        name="speciality_id"
                    >
                        <option value="">Seleccione una especialidad</option>
                        @foreach($specialities as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('speciality_id', $doctor->speciality_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                </div>

                {{-- Número de licencia médica --}}
                <x-wire-input
                    label="Número de licencia médica"
                    name="medical_license_number"
                    placeholder="Número de licencia"
                    value="{{ old('medical_license_number', $doctor->medical_license_number) }}"
                >
                </x-wire-input>

                {{-- Biografía --}}
                <x-wire-textarea
                    label="Biografía"
                    name="biography"
                    placeholder="Breve descripción del doctor"
                    :value="old('biography', $doctor->biography)"
                >
                </x-wire-textarea>

            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
