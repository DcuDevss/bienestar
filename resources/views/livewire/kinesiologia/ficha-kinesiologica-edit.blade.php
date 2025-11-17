
    <!-- Formulario -->
    <form wire:submit.prevent="updateFichaKinesiologica" class="space-y-10">
        @csrf

      
       @include('livewire.kinesiologia.kinesiologia-form', ['isEdit' => true])

      
            <a href="{{ route('kinesiologia.fichas-kinesiologicas-index', ['paciente' => $paciente->id]) }}"
                class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </form>
</div>
