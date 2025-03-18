
<div class="min-h-screen flex items-center justify-center bg-gray-100 -mt-[64px]">
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

                    <div class="redondo relative w-7 h-7 rounded-full border-2 border-gray-300 {{ $i <= $step ? 'bg-[#2d5986] hr-transition z-20' : 'bg-gray-300' }} text-center text-{{ $isLastIteration ? 'transparent' : 'white' }}">
                        @if (!$isLastIteration)
                            <span id="paso" class="text-inherit">{{ $i + 1 }}</span>
                        @endif
                    </div>

                    <!-- Agregué el estilo al hr para que también tome el color del paso actual y anteriores -->
                    @if ($i < 3)
                        <hr class="stepBar absolute -mt-4 ml-7 h-1 w-[96%] {{ $i < $step ? 'bg-[#2d5986]' : 'bg-gray-300' }} z-10">
                    @endif

                    <!-- <p class="text-xs font-semibold mt-1 {{ $i == $step ? 'text-blue-500' : 'text-gray-500' }}">Step {{ $i + 1 }}</p> -->
                </div>
            @endfor

            </div>

        </div>

        <form class="flex flex-col items-center" wire:submit.prevent="submit">
            <div class=" w-full">
                @if ($step == 0)
                    <div class="mx-auto w-fit font-semibold text-[19px]"><p>Personal:</p></div>
                    <!-- STEP 0 -->
                    <div class="grid grid-cols-3 w-full step-transition {{ $step === 0 ? 'step-active' : '' }}">

                        <!-- COLUMNA 1 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- NOMBRE Y APELLIDO -->
                            <label for="">Nombre y Apellido:</label>
                            <input type="text"  placeholder="..." wire:model.lazy="apellido_nombre" class="h-8 rounded-md border focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- DNI: -->
                            <label for="">Dni:</label>
                            <input type="text" placeholder="..." wire:model.lazy="dni" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- GENERO: -->
                            <label for="">Genero:</label>
                            <select wire:model.lazy="genero" class="h-9 rounded-md text-[#666666] focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                <option disabled selected value="">Genero</option>
                                <option class="text-[#666666] h-8">Masculino</option>
                                <option class="text-[#666666] h-8">Femenino</option>
                            </select>
                        </div>

                        <!-- COLUMNA 2 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- CUIL -->
                            <label for="">Cuil:</label>
                            <input type="text" wire:model.lazy="cuil" placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- DOMICILIO -->
                            <label for="">Domicilio:</label>
                            <input type="text" wire:model.lazy="direccion" placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 3 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <label for="">E-mail:</label>
                            <input type="text" placeholder="..." wire:model.lazy="email" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <label for="">Telefono:</label>
                            <input type="text"wire:model.lazy="telefono"  placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                    </div>

                    <div class="mx-auto">
                        @error('apellido_nombre')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step == 1)
                    <div class="mx-auto w-fit font-semibold text-[19px]"><p>Institucion:</p></div>
                    <!-- STEP 1 -->
                    <div class="grid grid-cols-3 w-full step-transition {{ $step === 1 ? 'step-active' : '' }}">

                        <!-- COLUMNA 1 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- ESTADO -->
                            <label for="estado_id" class="">Estado</label>
                            <select wire:model.lazy="estado_id" class="h-9 w-full rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                <option disabled selected value="">Seleccionar Estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" class="text-[#666666]">{{ $estado->name }}</option>
                                @endforeach
                            </select>
                            <!-- ESCALAFON -->
                            <label for="">Escalafon:</label>
                            <input type="text"wire:model.lazy="escalafon"  placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- JERARQUIA -->
                            <label for="">Jerarquia:</label>
                            <input type="text"wire:model.lazy="jerarquia"  placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 2 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- DESTINO ACTUAL -->
                            <label for="">Destino Actual:</label>
                            <input type="text"wire:model.lazy="destino_actual"  placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- LEGAJO -->
                            <label for="">Legajo:</label>
                            <input type="text"wire:model.lazy="legajo"  placeholder="..." class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                        <!-- COLUMNA 3 -->
                        <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                            <!-- CIUDAD -->
                            <label for="">Ciudad:</label>
                            <input type="text" placeholder="..." wire:model.lazy="ciudad" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            <!-- EDAD -->
                            <label for="">Edad:</label>
                            <input type="number" placeholder="..." wire:model.lazy="edad" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                        </div>

                    </div>
                    <div class="mx-auto">
                        @error('escalafon')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mx-auto">
                        @error('estado_id')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step == 2)
                    <div class="mx-auto w-fit font-semibold text-[19px]"><p>Familiar:</p></div>
                    <div class="mx-auto">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-600">Fecha de Nacimiento</label>
                        <input type="date" class="mt-1 p-2 w-full border border-gray-300 rounded" wire:model.lazy="fecha_nacimiento" placeholder="Fecha de Nacimiento">

                            <div class="flex flex-col gap-y-2 p-5 w-[80%] mx-auto">
                                <!-- PESO -->
                                <label for="">Peso:</label>
                                <input type="number" wire:model.lazy="peso" placeholder="peso" step="any" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                                <!-- ALTURA -->
                                <label for="">Altura:</label>
                                <input type="number" wire:model.lazy="altura" placeholder="altura" step="any" class="h-8 rounded-md focus:outline-none focus:border-1 focus:border-solid focus:border-[#2d5986]">
                            </div>


                        @error('fecha_nacimiento')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step > 2)
                    <div class="mx-auto w-fit font-semibold text-[19px]"><p>Finalizado</p></div>
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <div class="flex">
                            <h4 class="text-xl font-semibold mb-4">Registro completado</h4>
                            <i class="fa-solid fa-check text-[#2d5986] text-[30px] font-extrabold ml-2 -mt-1"></i>
                        </div>

                        <a href="/" class="text-blue-500">Volver a inicio</a>
                    </div>
                @endif
            </div>
            <!-- BOTONES -->
            <div class="mt-4">
                @if ($step > 0 && $step <= 2)
                    <button type="button" wire:click="decreaseStep"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-3">Back</button>
                @endif

                @if ($step <= 2)
                    <button type="submit" class="bg-[#2d5986] text-white px-4 py-2 rounded">Next</button>
                @endif
            </div>
        </form>
    </div>
</div>
