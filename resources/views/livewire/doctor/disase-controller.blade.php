<div class="py-8">
  <section class="w-full max-w-5xl mx-auto">
    <!-- Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow ring-1 ring-slate-200/60 dark:ring-slate-700">

      <!-- Header -->
      <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
        <div>
          <h2 class="font-bold text-slate-800 dark:text-slate-100 text-2xl text-center capitalize">
            {{ __('enfermedades') }}
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-100">Listado y gestión</p>
        </div>

        <button
        type="button"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 dark:focus:ring-offset-slate-800"
        wire:click="$set('modal', true)"
        >
        <!-- ícono + texto -->
        {{ __('agregar') }}
        </button>
      </div>

      <!-- Toolbar -->
      <div class="flex items-center gap-2 px-5 py-3 bg-slate-50 dark:bg-slate-900">
      <input class="w-full rounded border-slate-300 dark:border-slate-600 dark:bg-slate-800 text-white placeholder-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            type="text" placeholder="Buscar enfermedad" wire:model.live="search"/>
        <select class="rounded border-slate-300 dark:border-slate-600 dark:bg-slate-800 text-white placeholder-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.live="perPage">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
        <select class="rounded border-slate-300 dark:border-slate-600 dark:bg-slate-800 text-white placeholder-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.live="sortAsc">
          <option value="1">{{ __('asc') }}</option>
          <option value="0">{{ __('des') }}</option>
        </select>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
          <thead class="bg-slate-700 text-white">
            <tr>
              <th class="px-4 py-2">{{ __('nombre') }}</th>
              <th class="px-4 py-2">{{ __('sintomas') }}</th>
              <th class="px-4 py-2">{{ __('acciones') }}</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach ($disases as $disase)
              <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                <td class="px-4 py-2 font-medium text-white">{{ $disase->name }}</td>
                <td class="px-4 py-2 font-medium text-white">{{ $disase->symptoms }}</td>
                <td class="px-4 py-2">
                  <div class="flex items-center gap-3">
                    <!-- Edit -->
                    <a class="text-green-500 cursor-pointer hover:text-green-700"
                       wire:click="edit({{ $disase->id }})">
                      ✏️
                    </a>
                    <!-- Delete con confirm -->
                    <a x-data
                        @click="
                                Swal.fire({
                                    title: '¿Eliminar enfermedad?',
                                    text: 'Esta acción no se puede deshacer.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar',
                                    reverseButtons: true,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.eliminarConfirmado({{ $disase->id }})
                                    }
                                })
                        "
                        class="text-red-500 cursor-pointer hover:text-red-700">
                        🗑️
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      @if ($disases->count() > 0)
        <div class="px-5 py-3 border-t dark:border-slate-600 dark:bg-slate-800 text-white placeholder-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          {{ $disases->links() }}
        </div>
      @endif
    </div>
  </section>
  <x-dialog-modal wire:model="modal">
    <x-slot name="title">
        <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
        {{ __('agregar enfermedad') }}
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="grid gap-4">
        <div>
            <input class="w-full rounded border-slate-300" type="text" placeholder="{{ __('nombre') }}"
                wire:model.defer="name">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <textarea class="w-full rounded border-slate-300" rows="4" placeholder="{{ __('sintomas') }}"
                    wire:model.defer="symptoms"></textarea>
        </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button class="bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded mx-3"
                wire:click="$set('modal', false)">
        {{ __('cancelar') }}
        </button>
        <button class="bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded"
                wire:click="addDisase">
        {{ __('crear') }}
        </button>
    </x-slot>
   </x-dialog-modal>
   <x-dialog-modal wire:model="modalEdit">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
            {{ __('actualizar enfermedad') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="grid gap-4">
            <div>
                <input class="w-full rounded border-slate-300"
                    type="text" placeholder="{{ __('nombre') }}"
                    wire:model.defer="name">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <textarea class="w-full rounded border-slate-300" rows="4"
                        placeholder="{{ __('sintomas') }}"
                        wire:model.defer="symptoms"></textarea>
            </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded mx-3"
                    wire:click="$set('modalEdit',false)">
            {{ __('cancelar') }}
            </button>
            <button class="bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded"
                    wire:click="update">
            {{ __('actualizar') }}
            </button>
        </x-slot>
    </x-dialog-modal>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('livewire:init', () => {

  // ✅ Alerta normal
  Livewire.on('swal', (payload = {}) => {
    Swal.fire({
      title: payload.title ?? '',
      text: payload.text ?? '',
      icon: payload.icon ?? 'info',
      position: payload.position ?? 'top-end',
      toast: payload.toast ?? true,
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  });

  // ✅ Confirmación con acción
  Livewire.on('confirm', ({title='¿Estás seguro?', text='', icon='warning', confirmText='Confirmar', cancelText='Cancelar', action='', id=null} = {}) => {
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

