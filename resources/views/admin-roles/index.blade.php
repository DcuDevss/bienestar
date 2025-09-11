<x-app-layout>

    <head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    </head>
    <style>
        div.dt-container select.dt-input {
            min-width: 50px !important;
            height: 30px !important;
            font-size: 14px !important;
        }

        .dt-input {
            background-color: white !important;
            color: black !important;
        }

        div.dt-container .dt-length label {
            margin-left: 5px !important;
        }

        #dt-search-0 {
            border-radius: 10px !important;
            height: 30px !important;
        }

        .dt-paging-button {
            border: .5px solid white !important;
            margin: 0px 5px !important;
        }
    </style>
    <div class="flex">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        {{-- CONTENT --}}
        <div class="w-full px-4 mx-auto pb-12">
            {{-- TITULO --}}
            <div class=" text-center py-6">
                <h2 class="text-center text-2xl font-semibold " >
                    Lista de Roles
                </h2>
            </div>
            <div class="bg-gray-800 mx-auto p-4 rounded-md text-[12px] text-white w-[80%]">
                <div class="border-b border-gray-200 shadow">
                    {{-- MSJ VALIDACION --}}
                    @if (session('info'))
                        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3"
                            role="alert">
                            <p class="font-bold">Mensaje!!</p>
                            <p class="text-sm">{{ session('info') }}</p>
                        </div>
                    @endif
                    {{-- TABLA --}}
                    <div class="mb-4">
                        <table class="w-full text-left text-gray-500" id="miTabla">
                            <thead class="text-xs text-white uppercase bg-gray-900">
                                <tr class="teGead text-[14px]">
                                    <th class="py-3 w-fit" style="text-align: center;">Rol</th>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3 text-center mx-auto" style="text-align: center;">Accion-editar</th>
                                    <th scope="col" class="px-4 py-3 text-center mx-auto w-fit" style="text-align: center;">Accion-borrar</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800">
                                @foreach ($roles as $role)
                                    <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                        <td style="text-align: center;"
                                            class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-nowrap dark:text-white">
                                            {{ $role->id }}</td>
                                        <td
                                            class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-normal min-w-[200px] dark:text-white">
                                            {{ $role->name }}</td>
                                        <td class="tiBody px-4 py-1 text-[14px] text-gray-300 text-center mx-auto">
                                            <a href="{{ route('admin-roles.edit', $role) }}"
                                                class="inline-block text-center mx-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class=" text-[14px] text-gray-300">
                                            <form action="{{ route('admin-roles.destroy', $role) }}" method="post"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                                @method('delete')
                                                @csrf

                                                <div class="text-center ">
                                                    <button class="btn btn-danger" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-6 h-6 text-red-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });
        });
    </script>
</x-app-layout>
