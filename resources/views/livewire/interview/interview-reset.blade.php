<!-- resources/views/livewire/reset-sums.blade.php -->

<div>
    {{--  <button wire:click="resetSums" class="px-4 py-2 bg-red-700 text-white rounded">Reiniciar Sumas</button>--}}
   <div class=" p-2 rounded-md mb-2 bg-red-600 text-center">
    <td class="tiBody px-4 mb-2 py-1">
        <button
            onclick="confirm('Seguro desea eliminar la suma de salud ?') || event.stopImmediatePropagation()"
            wire:click="resetSums"
            class="ml-2 px-4 py-[2px]  text-white rounded">Borrar suma salud</button>
    </td>
</div>
   <div class=" p-2 rounded-md mb-2 bg-red-600 text-center" >
    <td class="tiBody px-4 py-1 mt-2">
        <button
            onclick="confirm('Seguro desea eliminar la suma de atendibles ?') || event.stopImmediatePropagation()"
            wire:click="resetSumsAtendibles"
            class="ml-2 px-4 py-[2px]  text-white rounded">Borrar suma atendibles</button>
    </td>
   </div>
   {{--
   <div class=" p-2 rounded-md mb-2 bg-black text-center" >
    <td class="tiBody px-4 py-1 mt-2">
        <button
            onclick="confirm('Seguro desea reiniciar atendibles y salud ?') || event.stopImmediatePropagation()"
            wire:click="resetGeneral"
            class="ml-2 px-4 py-[2px]  text-white rounded">Reiniciar el total de dias</button>
    </td>
   </div> --}}
</div>

