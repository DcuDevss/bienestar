<div class="p-4 text-center">
    @if (session()->has('success'))
        <div class="mb-4 px-4 py-2 bg-green-600 text-white text-sm rounded text-left">
            {!! session('success') !!}
        </div>
    @endif

    <button
        onclick="confirm('⚠️ ¿Seguro deseas reiniciar TODAS las licencias de todos los pacientes? Esta acción no se puede deshacer.') || event.stopImmediatePropagation()"
        wire:click="resetAll"
        class="pr-3 pl-2 py-2 text-white bg-[#dd2a0b] rounded-md hover:text-white hover:bg-[#c46356]">
        Reiniciar licencias de todos los pacientes
    </button>
</div>
