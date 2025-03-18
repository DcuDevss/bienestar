<div class="bg-gradient-to-tr from-blue-800 via-gray-600 to-blue-600">
    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
        <div class="max-w-xl mb-10 md:mx-auto sm:text-center lg:max-w-2xl md:mb-12">
            <div>
                <p
                    class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-white uppercase rounded-full bg-teal-accent-400">
                    {{ __('informacion del paciente') }}
                </p>
            </div>
            <h2
                class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-white sm:text-4xl md:mx-auto">
                <span class="relative inline-block">
                    <svg viewBox="0 0 52 24" fill="currentColor"
                        class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 text-blue-gray-100 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block">
                        <defs>
                            <pattern id="27df4f81-c854-45de-942a-fe90f7a300f9" x="0" y="0" width=".135" height=".30">
                                <circle cx="1" cy="1" r=".7"></circle>
                            </pattern>
                        </defs>
                        <rect fill="url(#27df4f81-c854-45de-942a-fe90f7a300f9)" width="52" height="24"></rect>
                    </svg>
                    <span class="relative text-white">{{ auth()->user()->name }}</span>
                </span>
            </h2>
            <p class="text-base text-white md:text-lg">
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque rem aperiam, eaque
                ipsa quae.
            </p>
        </div>
        <div class="grid max-w-screen-lg gap-8 row-gap-10 mx-auto lg:grid-cols-2">
            <div class="flex flex-col max-w-md sm:mx-auto sm:flex-row">
                <div class="mr-4">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-indigo-50">
                        <svg class="w-10 h-10 text-deep-purple-accent-400" stroke="currentColor" viewBox="0 0 52 52">
                            <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                        </svg>
                    </div>
                </div>
                <div>
                    <h6 class="mb-3 text-xl font-bold leading-5 text-white">{{ __('appoinments') }}</h6>
                    @forelse($appoinments  as $a)
                        <div class="text-sm text-white">
                            <span>{{ $a->doctor->name }},</span>
                            <span>{{ $a->specialty->name }},</span>
                            <br>
                            <span>{{ $a->oficina->address }},</span>
                            <span>{{ $a->oficina->local }},</span>
                            <span>{{ $a->oficina->email }},</span>
                            <span>{{ $a->oficina->phone }},</span>
                            <br>
                            <span>{{ $a->date instanceof \DateTime ? $a->date->format('d-m-Y') : '' }},</span>
                            <span>{{ $a->hour instanceof \DateTime ? $a->hour->format('g:i a') : '' }},</span>

                            <hr>
                            <br>
                        </div>
                    @empty
                        <span>{{ __('no hay citas registradas') }},</span>
                    @endforelse
                </div>
            </div>
            <div class="flex flex-col max-w-md sm:mx-auto sm:flex-row">
                <div class="mr-4">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-indigo-50">
                        <svg class="w-10 h-10 text-deep-purple-accent-400" stroke="currentColor" viewBox="0 0 52 52">
                            <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                        </svg>
                    </div>
                </div>
                <div>
                    <h6 class="mb-3 text-xl font-bold leading-5 text-white">{{ __('intervenciones') }}</h6>
                    @forelse($interviews  as $items)
                        <div class="text-sm text-white">
                            <span>{{ $items->doctor }},</span>
                            <div x-data="{ open: false }" class="border p-4">
                                <h1 class="w-full px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-900 hover:text-white"
                                    x-on:click="open=!open">{{ __('sospecha') }}</h1>
                                <span>{{ $items->suspicion }},</span>
                                <h1 class="w-full px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-900 hover:text-white"
                                    x-on:click="open=!open">{{ __('diagnosticos') }}</h1>
                                <span x-show="open">{{ $items->diagnosis }},</span>
                            </div>
                            <span>{{ $items->created_at instanceof \DateTime ? $items->created_at->format('d-m-Y') : '' }},</span>

                            <hr>
                            <br>
                        </div>
                    @empty
                        <span>{{ __('no registra intervenciones ') }},</span>
                    @endforelse
                </div>
            </div>
            <div class="flex flex-col max-w-md sm:mx-auto sm:flex-row">
                <div class="mr-4">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-indigo-50">
                        <svg class="w-10 h-10 text-deep-purple-accent-400" stroke="currentColor" viewBox="0 0 52 52">
                            <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                        </svg>
                    </div>
                </div>
                <div>
                    <h6 class="mb-3 text-xl font-bold leading-5 text-white">{{ __('filas') }}</h6>
                    <ul class=" w-full bg-white flex flex-col">
                        @forelse($files  as $m)
                            <li class="w-full border shadow px-4 py-2">
                                <a class="cursor-pointer px-4 py-2 text-gray-500">
                                    <figure class="flex justify-between items-center">


                                        @if ($m->extension !== 'pdf')
                                            <img src="{{ asset($m->url) }}" alt="{{ $m->name }}"
                                                class="h-20 w-20 object-cover mx-auto my-3">
                                        @else
                                            <a href="{{ asset($m->url) }}" target="blak">
                                                <img src="{{ asset('assets/pdf.png') }}" alt="{{ $m->name }}"
                                                    class="h-20 w-20 object-cover mx-auto my-3 rounded-lg shadow-sm">
                                                {{ __('see more...') }}
                                            </a>
                                        @endif
                                        <div class="mx-2">
                                            <h1 class="text-gray-800 font-bold text-sm">{{ $m->name }}</h1>
                                            <p>{{ Str::limit($m->observation, 50) }}</p>
                                        </div>

                                    </figure>
                                </a>
                            </li>
                        @empty
                            <span>{{ __('no register files ') }},</span>
                        @endforelse
                    </ul>
                    <div class="bg-white p-2 text-sm my-1">
                        {{ $files->links() }}
                    </div>
                </div>
            </div>
            <div class="flex flex-col max-w-md sm:mx-auto sm:flex-row">
                <div class="mr-4">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-indigo-50">
                        <svg class="w-10 h-10 text-deep-purple-accent-400" stroke="currentColor" viewBox="0 0 52 52">
                            <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                        </svg>
                    </div>
                </div>
                <div class="bg-indigo-500 p-4">
                    <h6 class="mb-3 text-xl font-bold leading-5 text-white">{{ __('medicines') }}</h6>
                    @forelse($medicines  as $items)
                        <div class="text-sm text-white">
                            <span>{{ $items->name }},</span>
                            <div x-data="{ open: false }" class="border p-4">
                                <h1 class="w-full px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-900 hover:text-white"
                                    x-on:click="open=!open">{{ __('dosage') }}</h1>
                                <span>{{ $items->pivot->dosage.$items->id }},</span>
                                <h1 class="w-full px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-900 hover:text-white"
                                    x-on:click="open=!open">{{ __('instruction') }}</h1>
                                <span x-show="open">{{ $items->pivot->instruction }},</span>
                            </div>
                            <span>{{ $items->created_at->format('d-m-Y') }},</span>
                            <hr>
                            <br>
                        </div>
                    @empty
                        <span>{{ __('no registra medicinas ') }},</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
