<div x-data="{ editModal: false }" class="padreTablas flex gap-x-2 px-6">
  <section class="seccionTab xl:mx-auto lg:mx-auto w-[75%]">
    <div class="mx-auto text-[12px]">
      <div class="bg-gray-800 shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between p-4">
          <div class="w-fit relative">
            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
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
                <th class="px-4 py-3">Peso</th>
                <th class="px-4 py-3">Altura</th>
                <th class="px-4 py-3">Talla</th>

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
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->peso }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->altura }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->talla }}</td>

                  <td class="tiBody px-4 py-1 text-white">{{ $control->presion }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->glucosa }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->temperatura }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->inyectable }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->dosis }}</td>
                  <td class="tiBody px-4 py-1 text-gray-300">
                    @if($control->fecha_atencion)
                      {{ \Carbon\Carbon::parse($control->fecha_atencion)->format('d-m-Y H:i:s') }}
                    @else
                      —
                    @endif
                  </td>
                  <td class="tiBody px-4 py-1 text-gray-300">{{ $control->detalles }}</td>

                  <td class="tiBody px-4 py-1 flex flex-wrap gap-2">
                    @role('enfermero')
                      <button @click="editModal = true"
                              wire:click="openEditModal({{ $control->id }})"
                              class="px-4 py-[2px] bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                        Editar
                      </button>
                    @endrole

                    @role('super-admin')
                     {{--  <button
                        x-data
                        x-on:click.prevent="
                          Swal.fire({
                            title: '¿Eliminar control?',
                            text: 'Esta acción no se puede deshacer.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true,
                          }).then((r) => {
                            if (r.isConfirmed) {
                              $wire.delete({{ $control->id }}).then(() => {
                                Swal.fire({
                                  title: 'Eliminado',
                                  text: 'Control eliminado correctamente.',
                                  icon: 'success',
                                  toast: true,
                                  position: 'top-end',
                                  timer: 2500,
                                  showConfirmButton: false,
                                  timerProgressBar: true,
                                });
                              });
                            }
                          });
                        "
                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                      >
                        Eliminar
                      </button> --}}
                    @endrole
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

  <!-- Modal Editar -->
  <div x-show="editModal" x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 px-4 overflow-y-auto">
    <div @click.away="editModal = false"
         class="bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl mx-auto my-12 p-6 overflow-y-auto max-h-[75vh]">
      <h2 class="text-lg text-white uppercase mb-2">Editar Control</h2>

      <form wire:submit.prevent="updateTratamiento" class="space-y-4">
        <div class="flex w-full gap-x-6">
          <div class="flex flex-col w-full gap-y-3">
            <!-- NUEVOS -->
            <div>
              <label class="block text-sm text-white">Peso</label>
              <input type="text" wire:model.defer="editControl.peso"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.peso') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm text-white">Altura</label>
              <input type="text" wire:model.defer="editControl.altura"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.altura') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm text-white">Talla</label>
              <input type="text" wire:model.defer="editControl.talla"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.talla') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm text-white">Presión</label>
              <input type="text" wire:model.defer="editControl.presion"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.presion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm text-white">Glucosa</label>
              <input type="text" wire:model.defer="editControl.glucosa"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.glucosa') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="flex flex-col w-full gap-y-3">
            <div>
              <label class="block text-sm text-white">Temperatura</label>
              <input type="text" wire:model.defer="editControl.temperatura"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
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
              <input type="text" wire:model.defer="editControl.dosis"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.dosis') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm text-white">Fecha de Atención</label>
              <input type="date" wire:model.defer="editControl.fecha_atencion"
                     class="mt-1 block w-full rounded border-gray-300 shadow-sm">
              @error('editControl.fecha_atencion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>

        <div>
          <label class="block text-sm text-white">Detalles</label>
          <textarea wire:model.defer="editControl.detalles" class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
          @error('editControl.detalles') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-2 pt-4">
          <button type="button" @click="editModal = false"
                  class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            Cancelar
          </button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('livewire:init', () => {
  Livewire.on('swal', function () {
    let payload = {};
    if (arguments.length === 1 && typeof arguments[0] === 'object' && !Array.isArray(arguments[0])) {
      payload = arguments[0];
    } else {
      payload = { title: arguments[0] ?? '', text: arguments[1] ?? '', icon: arguments[2] ?? 'info' };
    }
    const { title='Listo', text='', html=null, icon='success', timer=3000 } = payload;

    Swal.fire({
      title, text, html, icon,
      timer,
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timerProgressBar: true,
    });
  });

  Livewire.on('confirm', ({title='¿Estás seguro?', text='', icon='warning', confirmText='Sí', cancelText='Cancelar', action='', id=null} = {}) => {
    Swal.fire({
      title, text, icon,
      showCancelButton: true,
      confirmButtonText: confirmText,
      cancelButtonText: cancelText,
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed && action) {
        Livewire.dispatch(action, { id });
      }
    });
  });
});
</script>
