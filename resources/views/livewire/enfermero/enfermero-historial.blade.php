<div x-data="{ editModal: false }" class="padreTablas flex gap-x-2 px-6">
  <section class="seccionTab xl:mx-auto lg:mx-auto w-[75%]">
    <div class="mx-auto text-[12px]">
      <div class="bg-gray-800 shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between p-4">
          <div class="w-fit relative">
            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
              </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                   placeholder="Buscar...">
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-500">
            <thead class="teGead text-xs text-white uppercase bg-gray-900">
              <tr>
                <th class="px-4 py-3">Presión</th>
                <th class="px-4 py-3">Glucosa</th>
                <th class="px-4 py-3">Temperatura</th>
                <th class="px-4 py-3">Inyectable</th>
                <th class="px-4 py-3">Dosis</th>
                <th class="px-4 py-3">Fecha atención</th>
                <th class="px-4 py-3">Detalles</th>
                <th class="px-4 py-3">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($controles as $control)
              <tr class="border-b border-gray-700 text-[12px] hover:bg-[#204060]">
                <td class="tiBody px-4 py-1 text-white">{{ $control->presion }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->glucosa }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->temperatura }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->inyectable }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->dosis }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->fecha_atencion }}</td>
                <td class="tiBody px-4 py-1 text-gray-300">{{ $control->detalles }}</td>
                <td class="tiBody px-4 py-1 flex flex-wrap gap-2">
                  <button @click="editModal = true"
                          wire:click="openEditModal({{ $control->id }})"
                          class="px-4 py-[2px] bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                    Editar
                  </button>
                  <button onclick="confirm('¿Seguro que desea eliminar este control?') || event.stopImmediatePropagation()"
                          wire:click="delete({{ $control->id }})"
                          class="px-4 py-[2px] bg-[#2d5986] hover:bg-[#3973ac] text-white rounded">
                    Eliminar
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="py-4 px-5">
          <div class="flex space-x-4 items-center mb-3">
            <label class="text-sm font-medium text-white">Mostrar</label>
            <select wire:model.live="perPage"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
              <option value="6">6</option>
              <option value="8">8</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
          {{ $controles->links() }}
        </div>
      </div>
    </div>
  </section>
  <!-- Modal de edición -->
<!-- Modal Editar -->
<div x-show="editModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 px-4 overflow-y-auto">

  <div @click.away="editModal = false"
       class="bg-gray-800 shadow-lg rounded-lg  w-full max-w-2xl mx-auto my-12 p-6 overflow-y-auto max-h-[75vh]">

    <h2 class="text-lg text-white uppercase mb-2">Editar Control</h2>

    <form wire:submit.prevent="updateTratamiento" class="space-y-4">

      <div>
        <label class="block text-sm text-white">Presión</label>
        <input type="text" wire:model.defer="editControl.presion"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        @error('editControl.presion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Glucosa</label>
        <input type="text" wire:model.defer="editControl.glucosa"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        @error('editControl.glucosa') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Temperatura</label>
        <input type="number" step="0.1" wire:model.defer="editControl.temperatura"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        @error('editControl.temperatura') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Inyectable</label>
        <input type="text" wire:model.defer="editControl.inyectable"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        @error('editControl.inyectable') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Dosis</label>
        <input type="number" wire:model.defer="editControl.dosis"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        @error('editControl.dosis') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Fecha de Atención</label>
        <input type="date" wire:model.defer="editControl.fecha_atencion"
               class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        @error('editControl.fecha_atencion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block text-sm text-white">Detalles</label>
        <textarea wire:model.defer="editControl.detalles"
                  class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
        @error('editControl.detalles') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
      </div>

      <div class="flex justify-end gap-2 pt-4">
        <button type="button" @click="editModal = false"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
          Cancelar
        </button>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Guardar
        </button>
      </div>
    </form>
  </div>
</div>
<script>
  // Escucha el evento Livewire 'notify' y muestra el toast
  document.addEventListener('livewire:init', () => {
    Livewire.on('notify', (payload = {}) => {
      showToast(payload.message || 'Actualizado correctamente', payload.type || 'success');
    });
  });

  // Toast minimalista (sin dependencias)
  function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.textContent = message;

    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.padding = '12px 16px';
    toast.style.borderRadius = '10px';
    toast.style.boxShadow = '0 8px 20px rgba(0,0,0,0.25)';
    toast.style.color = '#fff';
    toast.style.fontWeight = '600';
    toast.style.zIndex = '9999';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(8px)';
    toast.style.transition = 'opacity 200ms ease, transform 200ms ease';
    toast.style.background = (type === 'error') ? '#dc2626' : '#16a34a';

    document.body.appendChild(toast);

    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
    });

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(8px)';
      setTimeout(() => toast.remove(), 220);
    }, 3000);
  }
</script>

</div>
