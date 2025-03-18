<x-app-layout class="">
    <!-- START -->
    <section class=" h-[200px] bg-[#009999]">
        
    <h1 class="text-center text-[28px] font-bold text-white pt-5">Psicología</h1>
    
    </section>
    <!-- TABLA -->
    <section class="-mt-[120px] w-full">
        <!-- Table responsive wrapper -->
        <div class="overflow-x-auto bg-white w-[80%] mx-auto rounded-md  px-[35px]">

            <!-- Search input -->
            <div class="relative m-[2px] mb-3 mt-2 mr-5 float-right">
                <input id="inputSearch" type="text" placeholder="Buscar..." class="block w-64 rounded-lg border dark:border-none bg-gray-100 py-2 pl-10 pr-4 text-sm focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-400" />
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-4 w-4 font-extrabold text-[#009999] ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
            </div>

            <!-- Table -->
            <table class="w-[95%] mx-auto text-left text-sm whitespace-nowrap">

                <!-- Table head -->
                <thead class="uppercase tracking-wider  border-b border-t border-[#009999] bg-white text-[#009999]">
                    <tr>
                        <th class="py-3">
                            N°
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Nombre y Apellido
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Dni
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Legajo
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Escalafon
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Dependencia
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Jerarquia
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            GyF.S
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Estado
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Telefono
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Email
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                        <th class="py-3">
                            Entrevista
                            <a href="" class="inline">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512"
                                    class="w-[0.75rem] h-[0.75rem] inline ml-1 text-neutral-500 dark:text-neutral-200 mb-[1px]"
                                    fill="currentColor"
                                    >
                                    {/* Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. */}
                                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z" />
                                </svg>
                            </a>
                        </th>
                    </tr>
                </thead>

                <!-- Table body -->
                <tbody class="text-gray-600">
                    @foreach($pacientes as $paciente)
                    <tr class="border-b border-gray-300">
                        <!-- <th scope="row" class="px-6 py-3">
                            Handbag
                        </th> -->
                        <td class="py-3">{{ $paciente->id}}</td>
                        <td class="pt-3 pb-3"><p class="">{{ $paciente->apellido_nombre}}</p></td>
                        <td class="py-3">{{ $paciente->dni}}</td>
                        <td class="py-3 text-center">{{ $paciente->legajo}}</td>
                        <td class="py-3">{{ $paciente->escalafon}}</td>
                        <td class="py-3">{{ $paciente->destino_actual}}</td>
                        <td class="py-3">{{ $paciente->jerarquia}}</td>
                        <td class="text-[13px] w-fit">0 +</td>
                        <td class="py-3">{{ $paciente->status ? 'Activo': 'Inactivo'}}</td>
                        <td class="py-3">{{ $paciente->telefono}}</td>
                        <td class="py-3"></td>
                        <td class="py-3">
                            <a class="ml-6 px-4 py-1 rounded-md bg-[#009999] text-white hover:text-black hover:bg-[#008080]"
                                href="{{ route('interviews.index', ['paciente' => $paciente->id]) }}">
                                {{ __('Ir') }}
                            </a>
                            @can('psicologa')
                            <a class="ml-6 px-4 py-1 rounded-md bg-[#009999] text-white hover:text-black hover:bg-[#008080]"
                            href="{{ route('interviews.index', ['paciente' => $paciente->id]) }}">
                            {{ __('Ir') }}
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <!-- Pagination -->
        <nav class="w-[80%] mx-auto mt-2 pb-5 flex items-center justify-between text-sm text-[#009999]" aria-label="Page navigation example">
            
            <p>Mostrando <strong>1-5</strong> of <strong>10</strong></p>

            <ul class="list-style-none flex">
                <li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-[#009999] transition-all duration-300 hover:bg-[#009999] dark:hover:text-white"
                    href="#!">
                    Previous</a>
                </li>
                <li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-[#009999] transition-all duration-300 hover:bg-[#009999] dark:hover:text-white"
                    href="#!">
                    1</a>
                </li>
                <li>
                    <a class="relative block rounded bg-[#009999] px-3 py-1.5 text-sm font-medium text-white transition-all duration-300"
                    href="#!">
                    2
                    <span class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]">
                    (current)
                    </span>
                </a>
                </li>
                <li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-[#009999] transition-all duration-300 hover:bg-[#009999] dark:hover:text-white"
                    href="#!">
                    3
                </a>
                </li>
                <li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-[#009999] transition-all duration-300 hover:bg-[#009999] dark:hover:text-white"
                    href="#!">
                    Next
                    </a>
                </li>
            </ul>
        </nav>
    </section>

</x-app-layout>
