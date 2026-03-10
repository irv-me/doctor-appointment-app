<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Gestor de horarios</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $doctor->user->name }}
                @if($doctor->speciality) — {{ $doctor->speciality->name }} @endif
            </p>
        </div>
        <button wire:click="saveSchedule"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50 transition-colors">
            <i class="fa-solid fa-floppy-disk"></i>
            <span wire:loading.remove>Guardar horario</span>
            <span wire:loading>Guardando...</span>
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-sm text-green-800 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="w-28 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Día/Hora
                    </th>
                    @foreach ($days as $dayKey => $dayLabel)
                        <th class="px-2 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <div>{{ $dayLabel }}</div>
                            {{-- Select all day --}}
                            <label class="mt-1 inline-flex items-center gap-1 cursor-pointer text-gray-500 font-normal normal-case">
                                <input type="checkbox"
                                       wire:click="toggleAllDay('{{ $dayKey }}')"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                       @php
                                           $allSlots = collect($hourBlocks)->flatMap(fn($h) => $this->slotsForHour($h))->toArray();
                                           $allChecked = count($selected[$dayKey] ?? []) === count($allSlots) && count($allSlots) > 0;
                                       @endphp
                                       {{ $allChecked ? 'checked' : '' }}>
                                Todos
                            </label>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($hourBlocks as $hour)
                    @php $slots = $this->slotsForHour($hour); @endphp

                    {{-- Hour row with row-toggle checkbox --}}
                    <tr class="bg-gray-50/50">
                        <td class="px-4 py-2 font-semibold text-gray-700 text-xs align-middle">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleHourAllDays('{{ $hour }}')"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                       @php
                                           $hourAllSet = collect(array_keys($days))->every(
                                               fn($d) => empty(array_diff($slots, $selected[$d] ?? []))
                                           );
                                       @endphp
                                       {{ $hourAllSet ? 'checked' : '' }}>
                                {{ $hour }}
                            </label>
                        </td>
                        @foreach (array_keys($days) as $dayKey)
                            <td class="px-2 py-1 text-center align-middle">
                                {{-- "Todos" for this hour+day --}}
                                <label class="inline-flex items-center gap-1 text-xs text-gray-500 cursor-pointer mb-1">
                                    <input type="checkbox"
                                           wire:click="toggleHourForDay('{{ $dayKey }}', '{{ $hour }}')"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                           @php
                                               $hourDayAllSet = empty(array_diff($slots, $selected[$dayKey] ?? []));
                                           @endphp
                                           {{ $hourDayAllSet ? 'checked' : '' }}>
                                    Todos
                                </label>
                            </td>
                        @endforeach
                    </tr>

                    {{-- Slot rows --}}
                    @foreach ($slots as $slot)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-4 py-1.5 text-xs text-gray-400 pl-10">{{ $slot }}</td>
                            @foreach (array_keys($days) as $dayKey)
                                <td class="px-2 py-1.5 text-center">
                                    <input type="checkbox"
                                           wire:click="toggleSlot('{{ $dayKey }}', '{{ $slot }}')"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                           {{ in_array($slot, $selected[$dayKey] ?? []) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
