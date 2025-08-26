<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4 text-center">Editar Paciente</h2>

    <form wire:submit.prevent="submit" class="space-y-4">

        <!-- Información del paciente -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-center mb-4">Información personal</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="apellido_nombre" class="block font-medium">Apellido y Nombre</label>
                        <input type="text" id="apellido_nombre" wire:model="apellido_nombre" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="dni" class="block font-medium">DNI</label>
                        <input type="number" id="dni" wire:model="dni" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="cuil" class="block font-medium">CUIL</label>
                        <input type="number" id="cuil" wire:model="cuil" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="sexo" class="block font-medium">Sexo</label>
                        <select id="sexo" wire:model="sexo" class="input rounded-md w-full" >
                            <option value="">Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="domicilio" class="block font-medium">Domicilio</label>
                        <input type="text" id="domicilio" wire:model="domicilio" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="fecha_nacimiento" class="block font-medium">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="email" class="block font-medium">Email</label>
                        <input type="email" id="email" wire:model="email" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="TelefonoCelular" class="block font-medium">Teléfono Celular</label>
                        <input type="number" id="TelefonoCelular" wire:model="TelefonoCelular" class="input rounded-md w-full" >
                    </div>

                    <div class="col-span-1">
                        <label for="FecIngreso" class="block font-medium">Fecha de Ingreso</label>
                        <input type="date" id="FecIngreso" wire:model="FecIngreso" class="input rounded-md w-full" >
                    </div>
                </div>
            </div>
        </div>



        <!-- Información Laboral -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-center mb-4">Información Laboral</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <div class="col-span-1">
                    <label for="legajo" class="block font-medium">Legajo</label>
                    <input type="number" id="legajo" wire:model="legajo" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="jerarquia_id" class="block font-medium">Jerarquía</label>
                    <select id="jerarquia_id" wire:model="jerarquia_id" class="input rounded-md w-full" >
                        <option value="">Seleccione</option>
                        @foreach ($jerarquias as $jerarquia)
                            <option value="{{ $jerarquia->id }}">{{ $jerarquia->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="destino_actual" class="block font-medium">Destino Actual</label>
                    <input type="text" id="destino_actual" wire:model="destino_actual" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="ciudad" class="block font-medium">Ciudad</label>
                    <input type="text" id="ciudad" wire:model="ciudad" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="edad" class="block font-medium">Edad</label>
                    <input type="number" id="edad" wire:model="edad" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="estado_id" class="block font-medium">Estado</label>
                    <select id="estado_id" wire:model="estado_id" class="input rounded-md w-full" >
                        <option value="">Seleccione</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="NroCredencial" class="block font-medium">Nro Credencial</label>
                    <input type="number" id="NroCredencial" wire:model="NroCredencial" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="antiguedad" class="block font-medium">Antigüedad</label>
                    <input type="number" id="antiguedad" wire:model="antiguedad" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="chapa" class="block font-medium">Chapa</label>
                    <input type="number" id="chapa" wire:model="chapa" class="input rounded-md w-full" >
                </div>
            </div>
            </div>
        </div>


        <!-- Información de Salud -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold text-center mb-4">Información de Salud</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <div class="col-span-1">
                    <label for="peso" class="block font-medium">Peso</label>
                    <input type="number" id="peso" wire:model="peso" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="altura" class="block font-medium">Altura</label>
                    <input type="number" id="altura" wire:model="altura" class="input rounded-md w-full" >
                </div>

                <div class="col-span-1">
                    <label for="factore_id" class="block font-medium">Factor</label>
                    <select id="factore_id" wire:model="factore_id" class="input rounded-md w-full" >
                        <option value="">Seleccione</option>
                        @foreach ($factores as $factore)
                            <option value="{{ $factore->id }}">{{ $factore->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1 lg:col-span-3">
                    <label for="enfermedad" class="block font-medium">Posee alguna enfermedad preexistente</label>
                    <textarea id="enfermedad" wire:model="enfermedad" class="input rounded-md w-full" rows="3" ></textarea>
                </div>

                <div class="col-span-1 lg:col-span-3">
                    <label for="remedios" class="block font-medium">Remedios</label>
                    <textarea id="remedios" wire:model="remedios" class="input rounded-md w-full" rows="3" ></textarea>
                </div>
            </div>
            </div>
        </div>


        <div class="px-4 mt-6">
                @if (session()->has('message'))
        <div class="mb-4 p-2 text-green-600 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600">
                Actualizar Paciente
            </button>
        </div>

    </form>


    @if (session()->has('message'))
        <div class="mb-4 p-2 text-green-600 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('notify', data => {
            showToast(data.message);
        });
    });

    function showToast(message) {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = '#16a34a';   // verde
        toast.style.color = '#fff';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 4px 6px rgba(0,0,0,0.2)';
        toast.style.zIndex = 9999;
        toast.style.fontWeight = 'bold';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';

        document.body.appendChild(toast);

        // animar aparición
        requestAnimationFrame(() => {
            toast.style.opacity = '1';
        });

        // remover después de 3s
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>

</div>
