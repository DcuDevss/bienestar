<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Pacientes') }}
        </h2> --}}
    </x-slot>

    <div class="py-12 bg-gray-50"> 
        <div class="mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- GRID DE DOS COLUMNAS (3/4 para la tabla, 1/4 para la barra lateral) --}}
            {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">  --}}
                
                {{-- COLUMNA PRINCIPAL (3/4): TABLA DE PACIENTES --}}
                {{-- <div class="lg:col-span-3"> 
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Listado de Pacientes Activos</h3> --}}
                    
                    {{-- Contenedor clave: Asegura que el Livewire no rompa la barra lateral --}}
                    <div class="w-full overflow-x-auto"> 
                        @livewire('patient.patient-list') 
                    </div>
                </div>

                {{-- COLUMNA LATERAL (1/4): LICENCIAS Y FECHAS --}}
                <div class="lg:col-span-1 space-y-6"> 
                    {{-- Título y Livewire de la barra lateral --}}
                    <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-b pb-2">Licencias y Fechas</h3>
                        @livewire('patient.patient-listfechas')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- SCRIPT: Incluimos aquí el script de JavaScript para el dropdown 'Opciones' --}}
<script>
    function toggleDropdown(event, patientId) {
        // Cerrar cualquier otro dropdown abierto
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        dropdowns.forEach(function(dropdown) {
            if (dropdown.id !== `dropdown-${patientId}`) {
                dropdown.classList.add('hidden');
            }
        });

        // Toggle (mostrar/ocultar) el dropdown del paciente actual
        const dropdown = document.getElementById(`dropdown-${patientId}`);
        dropdown.classList.toggle('hidden');
    }
</script>