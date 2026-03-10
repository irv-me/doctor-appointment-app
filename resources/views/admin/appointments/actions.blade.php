<div class="flex items-center space-x-2">
    {{-- Consultar cita --}}
    <x-wire-button href="{{ route('admin.appointments.consult', $appointment) }}" green xs>
        <i class="fa-solid fa-stethoscope"></i>
    </x-wire-button>

    {{-- Eliminar cita --}}
    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>
