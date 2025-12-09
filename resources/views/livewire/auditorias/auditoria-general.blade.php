<div class="padreTablas flex gap-x-2 px-6">
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-gray-800 shadow-md sm:rounded-lg">
                <!-- 🔍 Filtros -->
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-x-3">

                        <!-- Buscar -->
                        <div class="relative">
                            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.debounce.500ms="search" type="text"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 pl-10 p-2 w-56"
                                   placeholder="Buscar acción o descripción..."  wire:change="resetPage">
                        </div>

                        <!-- Acción -->
                        <select wire:model="action"  wire:change="resetPage"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-56">
                            <option value="">Acción</option>
                            <option value="paciente.create">Alta de paciente</option>
                            <option value="paciente.update">Edición de paciente</option>
                            <option value="paciente.delete">Eliminación de paciente</option>
                            <option value="paciente.restore">Restauración de paciente</option>
                            <option value="entrevista.create">Nueva entrevista</option>
                            <option value="entrevista.update">Edición de entrevista</option>
                            <option value="certificado.create">Alta de certificado</option>
                            <option value="certificado.update">Edición de certificado</option>
                            <option value="enfermedad.create">Atención médica agregada</option>
                            <option value="enfermedad.update">Atención médica actualizada</option>
                            <option value="disase.create">Alta de Enfermedad</option>
                            <option value="enfermeria.control.create">Control de enfermería</option>
                            <option value="enfermeria.control.update">Edición control de enfermería</option>
                            <option value="archivo.create">Subida de PDF(archivo)</option>
                            <option value="pdf.create">Subida de PDF(psicologo)</option>
                            <option value="ficha.kinesiologia.actualizacion">Editar Ficha kinesiologica</option>
                            <option value="Doctor.Creacion">Registro Doctor</option>
                            <option value="ficha.kinesiologia.creacion">Fichas Creadas</option>
                            <option value="pdf.kinesiologia">Subida de PDF(kinesiologia)</option>
                            <option value="eliminar.pdf">PDF Eliminado (Kinesiologia)</option>
                            <option value="sesion.edit">Sesiones Editadas</option>
                            <option value="sesion.finalizada">Sesion Finalizadas</option>
                            <option value="paciente.photo.removed">Foto Eliminada</option>
                            <option value="paciente.photo.uploaded">Foto Actualizada</option>
                            <option value="user.password.update">Actualización de contraseña</option>
                        </select>

                        <!-- Usuario -->
                        <select wire:model="user_id"  wire:change="resetPage"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-56">
                            <option value="">Usuario</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <!-- Fechas -->
                        <input wire:model="desde" type="date"  wire:change="resetPage"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-44">
                        <input wire:model="hasta" type="date"  wire:change="resetPage"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-44">
                    </div>
                </div>

                @if ($audits->isEmpty())
                    <div class="text-center text-xs uppercase px-4 py-3 text-white">
                        <p>No hay resultados para esta búsqueda.</p>
                    </div>
                @else
                    <!-- 🧾 Tabla -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-center text-gray-500">
                            <thead class="text-xs text-white uppercase bg-gray-900">
                                <tr class="text-[14px]">
                                    <th class="px-4 py-3">Fecha</th>
                                    <th class="px-4 py-3">Usuario</th>
                                    <th class="px-4 py-3">Acción</th>
                                    <th class="px-4 py-3">Descripción</th>
                                    <th class="px-4 py-3">Entidad</th>
                                    <th class="px-4 py-3">IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audits as $a)
                                    <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->created_at->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->user?->name ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->action_label }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->description ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->entity_label ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            {{ $a->ip_address ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- 📄 Paginación -->
                <div class="py-4 px-5">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
