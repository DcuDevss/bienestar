<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Editar Paciente</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-2 text-green-600 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">

        <!-- Información Básica -->
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 sm:col-span-1">
                <label for="apellido_nombre" class="block font-medium">Apellido y Nombre</label>
                <input type="text" id="apellido_nombre" wire:model="apellido_nombre" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="dni" class="block font-medium">DNI</label>
                <input type="text" id="dni" wire:model="dni" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="cuil" class="block font-medium">CUIL</label>
                <input type="text" id="cuil" wire:model="cuil" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="sexo" class="block font-medium">Sexo</label>
                <select id="sexo" wire:model="sexo" class="input" required>
                    <option value="">Seleccione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="domicilio" class="block font-medium">Domicilio</label>
                <input type="text" id="domicilio" wire:model="domicilio" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="fecha_nacimiento" class="block font-medium">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="email" class="block font-medium">Email</label>
                <input type="email" id="email" wire:model="email" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="TelefonoCelular" class="block font-medium">Teléfono Celular</label>
                <input type="text" id="TelefonoCelular" wire:model="TelefonoCelular" class="input" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="FecIngreso" class="block font-medium">Fecha de Ingreso</label>
                <input type="date" id="FecIngreso" wire:model="FecIngreso" class="input" required>
            </div>
        </div>

        <!-- Información Laboral -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold">Información Laboral</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label for="legajo" class="block font-medium">Legajo</label>
                    <input type="text" id="legajo" wire:model="legajo" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="jerarquia_id" class="block font-medium">Jerarquía</label>
                    <select id="jerarquia_id" wire:model="jerarquia_id" class="input" required>
                        <option value="">Seleccione</option>
                        @foreach ($jerarquias as $jerarquia)
                            <option value="{{ $jerarquia->id }}">{{ $jerarquia->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="destino_actual" class="block font-medium">Destino Actual</label>
                    <input type="text" id="destino_actual" wire:model="destino_actual" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="ciudad" class="block font-medium">Ciudad</label>
                    <input type="text" id="ciudad" wire:model="ciudad" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="edad" class="block font-medium">Edad</label>
                    <input type="number" id="edad" wire:model="edad" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="estado_id" class="block font-medium">Estado</label>
                    <select id="estado_id" wire:model="estado_id" class="input" required>
                        <option value="">Seleccione</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="NroCredencial" class="block font-medium">Nro Credencial</label>
                    <input type="text" id="NroCredencial" wire:model="NroCredencial" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="antiguedad" class="block font-medium">Antigüedad</label>
                    <input type="number" id="antiguedad" wire:model="antiguedad" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="chapa" class="block font-medium">Chapa</label>
                    <input type="text" id="chapa" wire:model="chapa" class="input" required>
                </div>
            </div>
        </div>

        <!-- Información de Salud -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold">Información de Salud</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label for="peso" class="block font-medium">Peso</label>
                    <input type="text" id="peso" wire:model="peso" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="altura" class="block font-medium">Altura</label>
                    <input type="text" id="altura" wire:model="altura" class="input" required>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="factore_id" class="block font-medium">Factor</label>
                    <select id="factore_id" wire:model="factore_id" class="input" required>
                        <option value="">Seleccione</option>
                        @foreach ($factores as $factore)
                            <option value="{{ $factore->id }}">{{ $factore->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label for="enfermedad" class="block font-medium">Enfermedad</label>
                    <textarea id="enfermedad" wire:model="enfermedad" class="input" rows="3" required></textarea>
                </div>

                <div class="col-span-2">
                    <label for="remedios" class="block font-medium">Remedios</label>
                    <textarea id="remedios" wire:model="remedios" class="input" rows="3" required></textarea>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600">
                Actualizar Paciente
            </button>
        </div>
    </form>
</div>
