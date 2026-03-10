<x-admin-layout
    title="Nueva Cita | MediMatch"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Citas', 'href' => route('admin.appointments.index')],
        ['name' => 'Nuevo'],
    ]"
>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 max-w-3xl mx-auto">
        <h2 class="text-xl font-bold text-gray-900 mb-6">
            <i class="fa-solid fa-calendar-plus text-blue-600 mr-2"></i>
            Registrar nueva cita
        </h2>

        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Validations summary --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Paciente --}}
                <div class="space-y-1">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700">
                        Paciente <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="patient_id"
                        name="patient_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('patient_id') border-red-500 @enderror"
                    >
                        <option value="">— Seleccione un paciente —</option>
                        @foreach ($patients as $id => $name)
                            <option value="{{ $id }}" {{ old('patient_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Doctor --}}
                <div class="space-y-1">
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">
                        Doctor <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="doctor_id"
                        name="doctor_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('doctor_id') border-red-500 @enderror"
                    >
                        <option value="">— Seleccione un doctor —</option>
                        @foreach ($doctors as $id => $name)
                            <option value="{{ $id }}" {{ old('doctor_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div class="space-y-1">
                    <label for="date" class="block text-sm font-medium text-gray-700">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ old('date') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('date') border-red-500 @enderror"
                    >
                    @error('date')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora inicio --}}
                <div class="space-y-1">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">
                        Hora de inicio <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('start_time') border-red-500 @enderror"
                    >
                    @error('start_time')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora fin --}}
                <div class="space-y-1">
                    <label for="end_time" class="block text-sm font-medium text-gray-700">
                        Hora de fin <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        value="{{ old('end_time') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('end_time') border-red-500 @enderror"
                    >
                    @error('end_time')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Motivo --}}
                <div class="space-y-1 md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700">
                        Motivo de la cita
                    </label>
                    <textarea
                        id="reason"
                        name="reason"
                        rows="3"
                        placeholder="Describa el motivo de la cita (opcional)"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.appointments.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fa-solid fa-arrow-left"></i>
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    <i class="fa-solid fa-check"></i>
                    Guardar cita
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
