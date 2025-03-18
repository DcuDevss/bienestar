


<div class="w-3/4 mx-auto">
    <section class="w-full  mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-8">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-center text-gray-800 capitalize text-2xl mb-2">{{ __('historial certificados') }}
            </h2>
        </header>
        <div class="flex items-center bg-white p-3">
            <input class="w-full rounded" type="text" placeholder="search disase" wire:model.live="search" />

        </div>
        <table class="w-full table-auto">
            <thead class="text-xs font-semibold uppercase rounded-md bg-slate-800">
                <tr>
                    <th class="p-1   text-center text-xs text-red-500"> Id</th>
                    <th class="p-1  text-center  text-xs text-white cursor-pointer">nombre de enfermedad</th>
                    <th class="p-1  text-center  text-xs text-white cursor-pointer">apellido nombre</th>
                    <th class="p-1  text-center  text-xs text-white cursor-pointer">Fecha de atencion</th>
                    <th class="p-1  text-center  text-xs text-white cursor-pointer">horas de salud</th>
                    <th class="p-1  text-center  text-xs text-white cursor-pointer">detalles dela enfermedad </th>

                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">

                @foreach ($enfermedadesPacientes as $pd)
                <tr>
                    <td class="text-center py-6 font-bold">{{ $pd->id }}</td>
                    <td class="text-center py-6 font-bold">{{ $pd->enfermedad->name }}</td>
                    <td class="text-center py-6 font-bold">{{ $pd->paciente->apellido_nombre }}</td>
                    <td class="text-center py-6 font-bold">{{ $pd->fecha_atencion2 }}</td>
                    <td class="text-center py-6 font-bold">{{ $pd->horas_reposo2 }}</td>
                    <td class="text-center py-6 font-bold">{{ $pd->detalle_enfermedad2 }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
        {{-- $pacientes->diases->links() --}}

    </section>

   
</div>
