<x-app-layout>
    <div class="flex">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        {{-- CONTENT --}}
        <div class="w-full pb-12 bg-white dark:bg-gray-100 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if (session('info'))
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                        <p class="font-bold">Mensaje!!</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                @endif

                <div class="mb-4 ">
                    <form action="{{ route('admin-roles.update', $role) }}" method="post"
                        class="bg-gray-700 text-white shadow-lg border w-fit mx-auto py-5 px-10">
                        @method('put')
                        @csrf
                        <div class="grid grid-cols-2 w-fit mx-auto gap-x-12 gap-y-2">
                            <h1 class="text-lg"><strong>Lista de Permisos para: 
                                <input name="name" class="bg-gray-300 text-black font-medium px-4 py-1 rounded"
                                    value="{{ $role->name }}">
                                </input>
                                </strong>
                            </h1>
                            <div class="py-2 text-transparent"></div>
                            @foreach ($permissions as $permission)
                                <div>
                                    <label>
                                        <input class="mr-1 mb-2" type="checkbox" name="permissions[]"
                                            value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mx-auto mt-8">
                            <button
                                class="bg-blue-800 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                                type="submit">
                                Actualizar Roles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
