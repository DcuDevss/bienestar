{{-- SIDE BAR --}}
        <div class="w-64 min-h-screen bg-gray-800 text-white flex flex-col">

            <div class="flex-1 overflow-y-auto">
                <div class="px-4 py-6">
                    <h2 class="text-lg font-semibold mb-4">Administrar</h2>
                    <nav class="space-y-1">
                        {{-- USUARIOS --}}
                        <a href="#proyecto1"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M3 12h18m-7 5h7" />
                            </svg>
                            USUARIOS
                        </a>
                        {{-- LISTA DE USUARIOS --}}
                        <a href="{{ route('users.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Lista de usuarios
                        </a>
                        {{-- NUEVO USUARIO --}}
                        <a href="{{ route('new-user') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Crear nuevo usuario
                        </a>
                        {{-- ROLES --}}
                        <a href="#proyecto1"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M3 12h18m-7 5h7" />
                            </svg>
                            ROLES
                        </a>
                        {{-- LISTA DE ROLES --}}
                        <a href="{{ route('admin-roles.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Lista de Roles
                        </a>
                        {{-- NUEVO ROL --}}
                        <a href="{{ route('admin-roles.create') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Crear nuevo rol
                        </a>
                    </nav>
                </div>
            </div>

        </div>