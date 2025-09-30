<div>
    <!-- component -->
    <div>
        <!-- component -->
        <section class="max-w-7xl p-6 mx-auto bg-slate-800 rounded-md shadow-md dark:bg-gray-800 mt-20">
            <h1 class="text-xl font-bold text-white capitalize dark:text-white">Antecedentes pasados</h1>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">

                    <div>
                        <label class="text-white dark:text-gray-200" for="profesional_enterior">Profesional donde realizo
                            la consulta</label>
                        <input wire:model="profesional_enterior" id="profesional_enterior" type="text"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div>
                        <label class="text-white dark:text-gray-200" for="fecha_atencion">Fecha de atencion</label>
                        <input wire:model="fecha_atencion" id="fecha_atencion" type="datetime-local"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div>
                        <label class="text-white dark:text-gray-200" for="consumo_farmacos">Consumo de Fármacos</label>
                        <input wire:model="consumo_farmacos" id="consumo_farmacos" type="text"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div>
                        <label for="antecedente_familiar"
                            class="block text-sm font-medium text-white">{{ __('antecedentes familiares') }}</label>
                        <textarea id="antecedente_familiar" class="w-full rounded cursor-pointer" rows="5"
                            placeholder="{{ __('ingrese antcedentes') }}" wire:model="antecedente_familiar"></textarea>{{-- --}}
                    </div>

                    <div>
                        <label for="motivo_consulta_anterior"
                            class="block text-sm font-medium text-white">{{ __('motivo de consulta') }}</label>
                        <textarea id="motivo_consulta_anterior" class="w-full rounded cursor-pointer" rows="5"
                            placeholder="{{ __('ingrese motivo') }}" wire:model="motivo_consulta_anterior"></textarea>{{-- --}}
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div>
                        <label class="text-white dark:text-gray-200" for="indicacionterapeutica_id">Indicación
                            Terapéutica</label>
                        <select wire:model.lazy="indicacionterapeutica_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option disabled selected value="">Indicación Terapéutica </option>
                            @foreach ($indicacionterapeuticas as $indicacion)
                                <option value="{{ $indicacion->id }}" class="text-[#666666]">{{ $indicacion->name }}
                                </option>
                            @endforeach
                        </select>
                            @error('indicacionterapeutica_id')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                                        <!-- Derivación Psiquiátrica -->
                    <div>
                        <label class="text-white dark:text-gray-200" for="derivacionpsiquiatrica_id">Derivación Psiquiátrica</label>
                        <select wire:model.lazy="derivacionpsiquiatrica_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md
                                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- Seleccione una derivación --</option>
                            @foreach ($derivacionpsiquiatricas as $derivacion)
                                <option value="{{ $derivacion->id }}">{{ $derivacion->name }}</option>
                            @endforeach
                        </select>
                            @error('derivacionpsiquiatrica_id')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                    <!-- Procedencia -->
                    <div>
                        <label class="text-white dark:text-gray-200" for="procedencia_id">Procedencia</label>
                        <select wire:model.lazy="procedencia_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md
                                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- Seleccione una procedencia --</option>
                            @foreach ($procedencias as $proce)
                                <option value="{{ $proce->id }}">{{ $proce->name }}</option>
                            @endforeach
                        </select>
                            @error('procedencia_id')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                    <!-- Enfermedad -->
                    <div>
                        <label class="text-white dark:text-gray-200" for="enfermedade_id">Enfermedad</label>
                        <select wire:model.lazy="enfermedade_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md
                                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- Seleccione una enfermedad --</option>
                            @foreach ($enfermedades as $enfer)
                                <option value="{{ $enfer->id }}">{{ $enfer->name }}</option>
                            @endforeach
                        </select>
                            @error('enfermedade_id')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>

                    <!-- Tipo de Licencia -->
                    <div>
                        <label class="text-white dark:text-gray-200" for="tipolicencia_id">Tipo de Licencia</label>
                        <select wire:model.lazy="tipolicencia_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md
                                dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- Seleccione un tipo de licencia --</option>
                            @foreach ($tipolicencias as $tipolic)
                                <option value="{{ $tipolic->id }}">{{ $tipolic->name }}</option>
                            @endforeach
                        </select>
                            @error('tipolicencia_id')
                              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <button type="submit"
                        class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">
                        Guardar
                    </button>
                </div>
            </form>
        </section>
    </div>

    {{--
    <section class="max-w-7xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tabla Tratamiento</h2>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-3">Profesional que realizo la consulta</th>
                        <th scope="col" class="px-4 py-3">Consumo de Fármacos</th>
                        <th scope="col" class="px-4 py-3">Antecedente Familiar</th>
                        <th scope="col" class="px-4 py-3">Fecha de atencion</th>
                        <th scope="col" class="px-4 py-3">Motivo Consulta Anterior</th>

                        <th scope="col" class="px-4 py-3">Indicación Terapéutica ID</th>
                        <th scope="col" class="px-4 py-3">Derivación Psiquiátrica ID</th>
                        <th scope="col" class="px-4 py-3">Procedencia ID</th>
                        <th scope="col" class="px-4 py-3">Enfermedad ID</th>
                        <th scope="col" class="px-4 py-3">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tratamientos as $tratamiento)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->profesional_enterior }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->consumo_farmacos }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->antecedente_familiar }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->fecha_atencion }}</td>

                            <td class="py-2 px-4 border-b">{{ $tratamiento->motivo_consulta_anterior }}</td>


                            <td class="py-2 px-4 border-b">{{ $tratamiento->indicacionterapeuticas->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->derivacionpsiquiatricas->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->procedencias->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->enfermedades->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('patient.patient-historial', ['paciente' => $tratamiento->paciente_id, 'tratamiento' => $tratamiento->id]) }}"
                                    class="text-blue-500 hover:underline">Crear</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
 --}}


    <div class="padreTablas mt-6 flex gap-x-2 px-6 mb-6">

        <section class="seccionTab xl:mx-auto lg:mx-auto w-[75%]">
            <div class="mx-auto text-[12px]">
                <!-- Start coding here -->
                <div class="bg-gray-800  shadow-md sm:rounded-lg ">
                    <div class="flex items-center justify-between d p-4">
                        <div class="flex flex-row items-end justify-between w-full">
                            <div class="w-fit">
                                <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model.live.debounce.300ms="search" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                                    placeholder="Buscar..." required="">

                            </div>
                            <!-- BOTON AGREGAR -->
                            {{-- <div class="">
                                    <a href="{{route('multiform.index')}}" class="pr-3 pl-2 py-2 text-white bg-[#2d5986] rounded-md hover:text-white hover:bg-[#3973ac]">
                                        <span class="text-[20px]">+ </span>
                                        <span class="agre text-[13px]">AGREGAR</span>
                                    </a>
                                </div> --}}
                        </div>

                    </div>
                    <div class="overflow-x-auto">
                        <div x-data="{ editModal: false }">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="teGead text-xs text-white uppercase bg-gray-900">
                                <tr>

                                    <th scope="col" class="px-4 py-3">Profesional que realizo la consulta</th>
                                    <th scope="col" class="px-4 py-3">Consumo de Fármacos</th>
                                    <th scope="col" class="px-4 py-3">Antecedente Familiar</th>
                                    <th scope="col" class="px-4 py-3">Fecha de atencion</th>
                                    <th scope="col" class="px-4 py-3">Motivo Consulta Anterior</th>
                                    <th scope="col" class="px-4 py-3">Indicación Terapéutica</th>
                                    <th scope="col" class="px-4 py-3">Derivación Psiquiátrica</th>
                                    <th scope="col" class="px-4 py-3">Procedencia</th>
                                    <th scope="col" class="px-4 py-3">Enfermedad</th>
                                    <th scope="col" class="px-4 py-3">Tipo Licencia</th>
                                    <th scope="col" class="px-4 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tratamientos as $tratamiento)
                                    <tr wire:key="{{ $tratamiento->id }}" class="border-b border-gray-700 text-[12px] hover:bg-[#204060]">
                                        <th class="tiBody px-4 py-1 font-medium text-white whitespace-nowrap dark:text-white">
                                            {{ $tratamiento->profesional_enterior }}
                                        </th>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->consumo_farmacos }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->antecedente_familiar }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">
                                            {{ \Carbon\Carbon::parse($tratamiento->fecha_atencion)->format('d-m-Y H:i:s') }}
                                        </td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->motivo_consulta_anterior }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->indicacionterapeuticas->name }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->derivacionpsiquiatricas->name }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->procedencias->name ?? 'Sin procedencia' }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->enfermedades->name }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->tipolicencias->name }}</td>
                                        <td class="tiBody px-4 py-1">
                                        <div class="flex flex-wrap gap-2 justify-center">
                                            @role('super-admin')
                                            <button onclick="confirm('¿Seguro que desea eliminar este tratamiento?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $tratamiento->id }})"
                                                class="ml-2 px-4 py-[2px] bg-[#f02f39] hover:bg-[#3973ac] text-white rounded">
                                                Eliminar
                                            </button>
                                            @endrole
                                            <button
                                                @click="editModal = true"
                                                wire:click="openEditModal({{ $tratamiento->id }})"
                                                class="ml-2 px-4 py-[2px] bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                                                Editar
                                            </button>
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                                <!-- MODAL -->
                            <div x-show="editModal" x-cloak x-transition
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
                                <div class="bg-white rounded-lg shadow p-6 w-full max-w-2xl">
                                    <h2 class="text-xl font-bold mb-4">Editar Tratamiento</h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label>Profesional</label>
                                            <input type="text" wire:model.defer="edit_profesional_enterior" class="w-full border rounded px-2 py-1" />
                                        </div>
                                        <div>
                                            <label>Fecha de atención</label>
                                            <input type="datetime-local" wire:model.defer="edit_fecha_atencion" class="w-full border rounded px-2 py-1" />
                                        </div>
                                        <div>
                                            <label>Consumo Fármacos</label>
                                            <input type="text" wire:model.defer="edit_consumo_farmacos" class="w-full border rounded px-2 py-1" />
                                        </div>
                                        <div>
                                            <label>Antecedente Familiar</label>
                                            <input type="text" wire:model.defer="edit_antecedente_familiar" class="w-full border rounded px-2 py-1" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <label>Motivo Consulta Anterior</label>
                                            <input type="text" wire:model.defer="edit_motivo_consulta_anterior" class="w-full border rounded px-2 py-1" />
                                        </div>
                                        <div>
                                            <label>Tipo Licencia</label>
                                            <select wire:model.defer="edit_tipolicencia_id" class="w-full border rounded px-2 py-1">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($tipolicencias as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label>Indicación Terapéutica</label>
                                            <select wire:model.defer="edit_indicacionterapeutica_id" class="w-full border rounded px-2 py-1">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($indicacionterapeuticas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label>Derivación Psiquiátrica</label>
                                            <select wire:model.defer="edit_derivacionpsiquiatrica_id" class="w-full border rounded px-2 py-1">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($derivacionpsiquiatricas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label>Procedencia</label>
                                            <select wire:model.defer="edit_procedencia_id" class="w-full border rounded px-2 py-1">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($procedencias as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label>Enfermedad</label>
                                            <select wire:model.defer="edit_enfermedade_id" class="w-full border rounded px-2 py-1">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($enfermedades as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-2">
                                        <button @click="editModal = false" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                            ❌ Cerrar
                                        </button>
                                        <button wire:click="updateTratamiento" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </table>
                    </div>
                    <div class="py-4 px-5">
                        <div class="flex">
                            <div class="flex space-x-4 items-center mb-3">
                                <label class="text-sm font-medium text-white">Mostrar</label>
                                <select wire:model.live='perPage'
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        {{ $tratamientos->links() }}
                    </div>
                </div>
            </div>
        </section>
        {{--   <section class="seccionTab2 w-fit">@livewire('patient.patient-listfechas')</section> --}}
            <script>
  document.addEventListener('livewire:init', () => {
    Livewire.on('notify', (payload = {}) => {
      showToast(payload.message || 'Operación realizada', payload.type || 'success');
    });
  });

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
    requestAnimationFrame(() => { toast.style.opacity = '1'; toast.style.transform = 'translateY(0)'; });
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(8px)';
      setTimeout(() => toast.remove(), 220);
    }, 3000);
  }
</script>

    </div>

</div>

