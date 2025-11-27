<div class="min-h-screen flex items-center justify-center bg-gray-100 -mt-[64px] mt-8">
    <div class="w-[80%] p-6 bg-white rounded-lg shadow-md">
        <div class="w-[80%] mx-auto text-center">
            <h3 class="text-xl font-semibold mb-2">Nuevo Personal</h3>

            @if (session()->has('message'))
                <!-- <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('message') }}
                </div> -->
            @endif

            <div class="flex space-x-4 mb-4">
                @for ($i = 0; $i <= 3; $i++)
                    <div class="cont flex-1 relative" style="{{ $i === 3 ? 'display: contents;' : '' }}">
                        @php
                            $isLastIteration = $i === 3;
                        @endphp

                        <div
                            class="redondo relative w-7 h-7 rounded-full border-2 border-gray-300 {{ $i <= $step ? 'bg-[#2d5986] hr-transition z-20' : 'bg-gray-300' }} text-center text-{{ $isLastIteration ? 'transparent' : 'white' }}">
                            @if (!$isLastIteration)
                                <span id="paso" class="text-inherit">{{ $i + 1 }}</span>
                            @endif
                        </div>

                        <!-- Agregué el estilo al hr para que también tome el color del paso actual y anteriores -->
                        @if ($i < 3)
                            <hr
                                class="stepBar absolute -mt-4 ml-7 h-1 w-[96%] {{ $i < $step ? 'bg-[#2d5986]' : 'bg-gray-300' }} z-10">
                        @endif

                        <!-- <p class="text-xs font-semibold mt-1 {{ $i == $step ? 'text-blue-500' : 'text-gray-500' }}">Step {{ $i + 1 }}</p> -->
                    </div>
                @endfor

            </div>

        </div>

        <form class="flex flex-col items-center" wire:submit.prevent="submit">
            <div class=" w-full">
                @if ($step == 0)
                    <div class="mx-auto w-fit font-semibold text-[19px]">
                        <p>Personal:</p>
                    </div>
                    <!-- STEP 0 -->
                    <div class="grid grid-cols-3 gap-4 w-full step-transition {{ $step === 0 ? 'step-active' : '' }}">

                        <!-- COLUMNA 1 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <label>Nombre y Apellido:</label>
                            <input type="text" placeholder="..." wire:model.lazy="apellido_nombre"
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label>DNI:</label>
                            <input type="number" placeholder="..." wire:model.lazy="dni"
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label>Género:</label>
                            <select wire:model.lazy="sexo"
                                    class="h-9 rounded-md border border-gray-300 px-3 text-[#666] focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <option disabled value="">Seleccione un género</option>
                            <option>Masculino</option>
                            <option>Femenino</option>
                            </select>
                        </div>

                        <!-- COLUMNA 2 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <label>CUIL:</label>
                            <input type="number" wire:model.lazy="cuil" placeholder="..."
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label>Domicilio:</label>
                            <input type="text" wire:model.lazy="domicilio" placeholder="..."
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-600">Fecha de Nacimiento</label>
                            <input type="date" wire:model.lazy="fecha_nacimiento" placeholder="..."
                                class="h-10 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 3 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <label>E-mail:</label>
                            <input type="email" placeholder="..." wire:model.lazy="email"
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label>Teléfono:</label>
                            <input type="number" wire:model.lazy="TelefonoCelular" placeholder="..."
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                            <label>Fecha de Ingreso:</label>
                            <input type="date" wire:model.lazy="FecIngreso" placeholder="..."
                                class="h-8 rounded-md border border-gray-300 px-3 focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]">
                        </div>

                        <!-- BLOQUE FOTO + BOTÓN (alineado con el resto) -->
                        <div class="col-span-3">
                            <div class="w-[80%] mx-auto p-5 rounded-xl border border-gray-200 bg-white/50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto (opcional)</label>

                                <input type="file"
                                    wire:model="foto"
                                    wire:key="foto-{{ $uploadIteration }}"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-300 rounded-md cursor-pointer
                                            focus:outline-none focus:ring-2 focus:ring-[#2d5986]/40 focus:border-[#2d5986]
                                            file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium
                                            file:bg-[#2d5986] file:text-white hover:file:bg-[#244a70]">

                                @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div wire:loading wire:target="foto" class="text-sm text-gray-500 mt-2">Subiendo imagen...</div>

                                {{-- Archivo seleccionado (nuevo) + botón quitar --}}
                                @if ($foto)
                                <div class="mt-2 flex items-center justify-between gap-3 text-sm text-gray-700 rounded-md border border-gray-200 bg-white px-3 py-2">
                                    <span class="truncate">
                                    Archivo seleccionado:
                                    <span class="font-semibold truncate">{{ $foto->getClientOriginalName() }}</span>
                                    </span>
                                    <button type="button"
                                            wire:click="removePhoto"
                                            wire:loading.attr="disabled"
                                            wire:target="removePhoto"
                                            class="inline-flex items-center rounded-md border border-red-300 px-3 py-1.5 text-red-600 hover:bg-red-50 disabled:opacity-60 disabled:cursor-not-allowed">
                                    Quitar
                                    </button>
                                </div>
                                @endif

                                {{-- Archivo actual (solo para edición; en alta normalmente no hay) --}}
                                @if (!empty($customer?->foto))
                                <div class="mt-2 flex items-center gap-3 text-sm text-gray-600">
                                    <span>Archivo actual: <span class="font-semibold">{{ basename($customer->foto) }}</span></span>
                                    <button type="button"
                                            wire:click="removePhoto"
                                            wire:loading.attr="disabled"
                                            wire:target="removePhoto"
                                            class="inline-flex items-center rounded-md border border-red-300 px-3 py-1.5 text-red-600 hover:bg-red-50 disabled:opacity-60 disabled:cursor-not-allowed">
                                    Quitar foto
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>


                    </div>


                    <div class="mx-auto">
                        @error('apellido_nombre')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('dni')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('cuil')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('genero')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('direccion')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('fecha_nacimiento')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('email')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('telefono')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror
                        @error('FecIngreso')
                            <span class="text-red-500 text-center">{{ $message }}</span>
                        @enderror

                    </div>
                @endif

                @if ($step == 1)
                    <div class="mx-auto w-fit font-semibold text-[19px]">
                        <p>Institucion:</p>
                    </div>
                    <!-- STEP 1 -->
                    <div class="grid grid-cols-3 w-full step-transition {{ $step === 1 ? 'step-active' : '' }}">

                        <!-- COLUMNA 1 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- ESTADO -->
                            <label for="estado_id" class="">Estado</label>
                            <select wire:model.lazy="estado_id"
                                class="h-9 w-full rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                {{-- Placeholder seleccionable --}}
                                <option value="" @selected($estado_id === null)>Seleccionar Estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" class="text-[#666666]">
                                        {{ $estado->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- JERARQUIA -->
                            <label for="jerarquia_id" class="">Jerarquia</label>
                            <select wire:model.lazy="jerarquia_id"
                                class="h-9 w-full rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                <option disabled value="">Seleccionar Jerarquia</option>
                                @foreach ($jerarquias as $jerarquia)
                                    <option value="{{ $jerarquia->id }}" class="text-[#666666]">{{ $jerarquia->name }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- CHAPA --}}
                            <label for="">N° de Chapa:</label>
                            <input type="number"wire:model.lazy="chapa" placeholder="..."
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 2 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- DESTINO ACTUAL -->
                            <label for="">Destino Actual:</label>
                            <input type="text"wire:model.lazy="destino_actual" placeholder="..."
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- LEGAJO -->
                            <label for="">Legajo:</label>
                            <input type="number"wire:model.lazy="legajo" placeholder="..."
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            {{-- CREDENCIAL --}}
                            <label for="">N° de Credencial:</label>
                            <input type="number"wire:model.lazy="NroCredencial" placeholder="..."
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 3 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- CIUDAD -->
                            <label for="">Ciudad:</label>
                            {{-- <input type="text" placeholder="..." wire:model.lazy="ciudad"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]"> --}}
                            <select wire:model="ciudad_id" id="ciudad_id"
                                class="block w-full  rounded-md">
                                <option value="">Seleccione una ciudad</option>
                                @foreach ($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                                @endforeach
                            </select>
                            <!-- EDAD -->
                            <label for="">Edad:</label>
                            <input type="number" placeholder="..." wire:model.lazy="edad"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <label for="">Antigüedad:</label>
                            <input type="number" placeholder="..." wire:model.lazy="antiguedad"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                    </div>
                    <div class="mx-auto">
                        @error('estado_id')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('edad')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('jerarquia_id')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('destino_actual')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('legajo')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('ciudad')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('chapa')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('NroCredencial')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('antiguedad')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step == 2)
                    <div class="mx-auto">
                        <p>Personal:</p>
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <label for="factore_id" class="">Grupo y Factor Sanguineo</label>
                            <select wire:model.lazy="factore_id"
                                    class="h-9 w-full rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                <option value="" @selected($factore_id === null)>Sin factor / Seleccionar</option>

                                @foreach ($factores as $factor)
                                    <option value="{{ $factor->id }}" class="text-[#666666]">
                                        {{ $factor->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- PESO -->
                            <label for="peso">Peso:</label>
                            <input type="number" wire:model.lazy="peso" placeholder="peso" step="any"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- ALTURA -->
                            <label for="altura">Altura:</label>
                            <input type="text" wire:model.lazy="altura" placeholder="altura" step="any"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <label for="enfermedad">Posee alguna enfermedad preexistente:</label>
                            <input type="text" wire:model.lazy="enfermedad" placeholder="..." step="any"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <label for="remedios">Medicamentos que consume:</label>
                            <input type="text" wire:model.lazy="remedios" placeholder="..." step="any"
                                class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>
                    </div>

                    <div class="mx-auto">
                        @error('factore_id')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('peso')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('altura')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('enfermedad')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                        @error('remedios')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step > 2)
                    <div class="mx-auto w-fit font-semibold text-[19px]">
                        <p>Finalizado</p>
                    </div>
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <div class="flex">
                            <h4 class="text-xl font-semibold mb-4">Registro completado</h4>
                            <i class="fa-solid fa-check text-[#2d5986] text-[30px] font-extrabold ml-2 -mt-1"></i>
                        </div>
                    </div>
                @endif

            </div>
            <!-- BOTONES -->
            <div class="mt-4">
                @if ($step > 0 && $step <= 2)
                    <button type="button" wire:click="decreaseStep"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-3">Volver</button>
                @endif

                @if ($step <= 2)
                    <button type="submit" class="bg-[#2d5986] text-white px-4 py-2 rounded">Siguiente</button>
                @endif
            </div>
        </form>
        @if ($registroCompletado)
            <div class="mt-4">
                <a href="{{ route('interviews.index', $this->customer->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                    Acceder a Historia clínica
                </a>
            </div>
        @endif

        <div class="mt-4 ml-14 ">
            <a href="{{ route('dashboard') }}" class="bg-[#42be31] text-white px-4 py-2 rounded">
                {{ __('Volver') }}
            </a>
        </div>
    </div>
</div>
<script>
document.addEventListener('livewire:init', () => {
  Livewire.on('swal', ({ title = '', text = '', icon = 'success', timer = 2000, toast = true, position = 'top-end' } = {}) => {
    Swal.fire({
      title, text, icon,
      toast, position, timer,
      showConfirmButton: !toast,
    });
  });

  Livewire.on('confirm', ({
    title = '¿Estás seguro?',
    text = 'Esta acción no se puede deshacer.',
    icon = 'warning',
    confirmText = 'Sí, continuar',
    cancelText = 'Cancelar',
    action = null,
    params = {}
  } = {}) => {
    Swal.fire({
      title, text, icon,
      showCancelButton: true,
      confirmButtonText: confirmText,
      cancelButtonText: cancelText,
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed && action) {
        Livewire.dispatch(action, params);
      }
    });
  });
});
</script>
