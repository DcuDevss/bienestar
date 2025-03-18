<x-app-layout>
    <div class="py-5 bg-white dark:bg-gray-100 mt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-red-500 leading-tight">
                    {{ __('LISTAS DE ROLES: ') }}
                </h2>
            </x-slot>
            @if (session('info'))
                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <p class="font-bold">Mensaje!!</p>
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
            @endif
            <div class="float-right mb-3">
                <a href="{{ route('admin-roles.create') }}"
                    class="inline-block bg-slate-700 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    Nuevo rol
                </a>
            </div>

            <div class="mb-4">

                <label class="block text-blue-800 font-bold mb-2" for="inline-full-name">
                    Nombre
                </label>
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    id="inline-full-name" type="text" value="">
            </div>

            <div class="mb-4">

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Rol</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th colapsan="2">Accion-editar</th>
                            <th colapsan="2">Accion-borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="border px-4 py-2">{{ $role->id }}</td>
                                <td class="border px-4 py-2">{{ $role->name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('admin-roles.edit', $role) }}"
                                        class="inline-block bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-black font-bold py-2 px-4 rounded">
                                        Editar
                                    </a>

                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <form action="{{ route('admin-roles.destroy', $role) }}" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                        @method('delete')
                                        @csrf

                                        <div class="text-end">
                                            <button class="bg-red-600 hover:bg-red-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                                                Eliminar Rol
                                            </button>
                                        </div>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
