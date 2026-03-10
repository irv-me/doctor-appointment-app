<div>
    {{-- Header --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $appointment->patient->user->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">DNI: {{ $appointment->patient->user->id_number ?? 'N/A' }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                {{-- Ver Historia médica --}}
                <button type="button"
                        wire:click="$set('showHistoryModal', true)"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fa-solid fa-notes-medical"></i>
                    Ver Historia
                </button>

                {{-- Consultas anteriores --}}
                <button type="button"
                        wire:click="$set('showConsultationsModal', true)"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Consultas Anteriores
                </button>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'consulta' }">
        {{-- Tab buttons --}}
        <div class="border-b border-gray-200 mb-0">
            <nav class="flex space-x-1 -mb-px" aria-label="Tabs">
                <button @click="tab = 'consulta'" type="button"
                        :class="tab === 'consulta'
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="inline-flex items-center gap-2 px-4 py-3 border-b-2 text-sm font-medium transition-colors">
                    <i class="fa-solid fa-stethoscope"></i>
                    Consulta
                </button>
                <button @click="tab = 'receta'" type="button"
                        :class="tab === 'receta'
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="inline-flex items-center gap-2 px-4 py-3 border-b-2 text-sm font-medium transition-colors">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                    Receta
                </button>
            </nav>
        </div>

        {{-- Tab: Consulta --}}
        <div x-show="tab === 'consulta'"
             class="bg-white border border-gray-200 rounded-b-lg rounded-tr-lg shadow-sm p-6 space-y-5">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                <textarea wire:model="diagnosis" rows="4"
                          placeholder="Describa el diagnóstico del paciente aquí..."
                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Tratamiento</label>
                <textarea wire:model="treatment" rows="3"
                          placeholder="Describa el tratamiento recomendado aquí..."
                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Notas</label>
                <textarea wire:model="notes" rows="3"
                          placeholder="Agregue notas adicionales sobre la consulta..."
                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>
        </div>

        {{-- Tab: Receta --}}
        <div x-show="tab === 'receta'"
             class="bg-white border border-gray-200 rounded-b-lg rounded-tr-lg shadow-sm p-6 space-y-4">
            <div class="grid grid-cols-12 gap-2 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                <div class="col-span-5">Medicamento</div>
                <div class="col-span-3">Dosis</div>
                <div class="col-span-3">Frecuencia / Duración</div>
                <div class="col-span-1"></div>
            </div>

            @foreach ($medications as $i => $med)
                <div class="grid grid-cols-12 gap-2 items-center">
                    <div class="col-span-5">
                        <input type="text"
                               wire:model="medications.{{ $i }}.name"
                               placeholder="Ej: Amoxicilina 500mg"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-3">
                        <input type="text"
                               wire:model="medications.{{ $i }}.dose"
                               placeholder="1 cada 8 horas"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-3">
                        <input type="text"
                               wire:model="medications.{{ $i }}.frequency"
                               placeholder="Ej: cada 8 horas por 7 días"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button type="button" wire:click="removeMedication({{ $i }})"
                                class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addMedication"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 border border-blue-300 rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fa-solid fa-plus"></i>
                Añadir Medicamento
            </button>
        </div>

        {{-- Save button --}}
        <div class="flex justify-end mt-4">
            <button type="button" wire:click="saveConsultation"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50">
                <i class="fa-solid fa-floppy-disk"></i>
                <span wire:loading.remove>Guardar Consulta</span>
                <span wire:loading>Guardando...</span>
            </button>
        </div>
    </div>

    {{-- Modal: Historia médica --}}
    @if ($showHistoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
             x-data x-show="true" x-transition>
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Historia médica del paciente</h3>
                    <button wire:click="$set('showHistoryModal', false)"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                @php $patient = $appointment->patient; @endphp

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Tipo de sangre:</p>
                        <p class="text-sm text-gray-900 font-medium">{{ $patient->bloodType->name ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Alergias:</p>
                        <p class="text-sm text-gray-900">{{ $patient->allergies ?: 'No registradas' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Enfermedades crónicas:</p>
                        <p class="text-sm text-gray-900">{{ $patient->chronic_conditions ?: 'No registradas' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Antecedentes quirúrgicos:</p>
                        <p class="text-sm text-gray-900">{{ $patient->surgical_history ?: 'No registrados' }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.patients.edit', $patient) }}"
                       class="text-sm text-blue-600 hover:underline font-medium">
                        Ver / Editar Historia Médica
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Consultas anteriores --}}
    @if ($showConsultationsModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
             x-data x-show="true" x-transition>
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Consultas Anteriores</h3>
                    <button wire:click="$set('showConsultationsModal', false)"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                @php
                    $pastConsultations = $appointment->patient->consultations()
                        ->with(['appointment.doctor.user'])
                        ->where('appointment_id', '!=', $appointment->id)
                        ->latest()
                        ->get();
                @endphp

                @if ($pastConsultations->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-file-medical text-4xl mb-3 text-gray-300"></i>
                        <p>Este paciente no tiene consultas anteriores.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($pastConsultations as $consultation)
                            <div class="border border-gray-200 rounded-lg p-4 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $consultation->appointment->date->format('d/m/Y') }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Dr. {{ $consultation->appointment->doctor->user->name }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Diagnóstico:</p>
                                    <p class="text-sm text-gray-800">{{ $consultation->diagnosis ?: 'No registrado' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Tratamiento:</p>
                                    <p class="text-sm text-gray-800">{{ $consultation->treatment ?: 'No registrado' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
