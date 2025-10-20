<style>
    .contenedorColumnas {
        display: grid;
        grid-template-columns: 380px 300px;
        /* Dos columnas con anchos específicos */
        gap: 0px;
        /* Espacio entre las columnas */
    }

    .imgTitulo {
        height: 50%;
    }

    .msj-error ul li {
        background-color: #80aedf !important;
        /* verde brillante */
        font-weight: bold;
    }

    @media (max-width: 900px) {
        .contenedorColumnas {
            display: grid;
            grid-template-columns: 390px;
            gap: 0px;
        }

        .titulo {
            height: fit-content;
        }

        .imgTitulo {
            height: 230px;
        }
    }
</style>
<x-guest-layout>
    <div class="grid grid-cols-1 gap-6">
        <section class="">
            <div class="relative h-screen mx-auto w-full scroll-mt-0 flex items-center" id="sec1">
                <img class="absolute inset-0 h-full w-full object-cover opacity-85" src="{{ asset('assets/cita_2.jpg') }}"
                    alt="{{ __('cita') }}">
                <div class="absolute inset-0 bg-gradient-to-tl from-blue-400 via-blue-900 to-transparent opacity-90">
                </div>

                <div
                    class="contenedorColumnas relative w-fit mx-auto text-center  py-16 pr-4 sm:py-20 sm:px-6 opacity-90 h-fit">

                    <div class="titulo flex flex-col items-center justify-center -mt-[71px] -ml-3">
                        <img class="imgTitulo" src="{{ asset('assets/newShield.png') }}" alt="">
                        <h2 class="text-3xl font-extrabold text-white sm:text-4xl items-start -mt-3">
                            <span class="block capitalize text-[34px] leading-[35px] ">
                                {{ __('Division Bienestar Policial') }}
                            </span>

                        </h2>
                    </div>
                    <!--  -->

                    <div class="father -ml-4 flex flex-col w-[90%] justify-center">

                        <div class="">
                            @if ($errors->any())
                                <script>
                                    window.onload = function() {
                                        alert("{{ implode('\n', $errors->all()) }}");
                                    };
                                </script>
                            @endif

                            @if (session('status'))
                                <div class=" mb-4 font-medium text-sm">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('login') }}" novalidate class="float-left">
                            @csrf

                            <div>
                                <span class=" text-white block text-[23px] mt-3 float-left">
                                    {{ __('Informacion del usuario:') }}
                                </span>
                                <x-label class="text-white w-fit" for="email" value="{{ __('Email:') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <x-label class="text-white w-fit" for="password" value="{{ __('Password:') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="current-password" />
                            </div>

                            {{--                             <div class="block mt-4  w-fit">
                                <label class="text-white" for="remember_me" class="flex items-center">
                                    <x-checkbox id="remember_me" name="remember" />
                                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                                </label>
                            </div> --}}

                            <div class="block mt-4 justify-center">
                                {{--   @if (Route::has('password.request'))
                                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif --}}

                                <x-button class="ms-4 px-6 py-3 text-lg">
                                    {{ __('Log in') }}
                                </x-button>
                            </div>
                        </form>
                    </div>


                    <!-- -->

                    <!-- <p class="mt-4 text-lg leading-6 text-gray-200">
                        {{-- __('Weareaquickandeasywaytomanageyourmedicalappointmentsandcontrolyourconsultationsandinterviews.') --}}
                    </p>
                    <div class="mt-4 max-w-sm mx-auto sm:max-w-none sm:justify-center">
                        <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-1 sm:gap-5">
                            <a href="#sec2"
                                class="text-white px-4 py-2 bg-red-600 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1">{{ __('empezar') }}</a>
                            @auth
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <a class="text-white px-4 py-2 bg-red-600 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1"
                                                    href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </a>
                                            </form>
@else
    <a href="{{ route('login') }}"
                                                class="text-white px-4 py-2 bg-blue-900 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1">{{ __('Login') }}</a>

                                            <a href="{{ route('register') }}"
                                                class="text-white px-4 py-2 bg-blue-900 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1">{{ __('register') }}</a>
                            @endauth

                        </div>
                    </div> -->

                </div>
            </div>
        </section>

        {{--  <section>
            <div class="relative h-screen bg-red-500 mx-auto w-full scroll-mt-0" id="sec2">
                <img class="absolute inset-0 h-full w-full object-cover opacity-85"
                    src="{{ asset('assets/cita_1.jpg') }}" alt="{{ __('cita') }}">
                <div class="absolute inset-0 bg-gradient-to-tl from-green-400 via-green-900 to-transparent opacity-90">
                </div>
                <div class="relative max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 opacity-90">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block capitalize">step one</span>
                        <span class="block capitalize">select a medical specialty or a doctor.</span>
                    </h2>
                    <p class="mt-4 text-lg leading-6 text-gray-100">You can choose from several doctors if you search
                        for them according to their specialty.
                        If you already have a doctor you trust, then request your appointment</p>
                    <div class="mt-4 max-w-sm mx-auto sm:max-w-none sm:justify-center">
                        <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-1 sm:gap-5">

                            <br>
                            <a href="#sec4"
                                class="text-white px-4 py-2 bg-red-700 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1">{{ __('doctor') }}</a>

                            <a href="#sec3"
                                class="text-white px-4 py-2 bg-red-700 hover:bg-green-600 flex items-center justify-center border text-base font-medium rounded-md shadow-sm sm:px-8 focus:ring focus:ring-offset-1">{{ __('specialties') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="sec4">
            @livewire('patient.patient-doctor')
        </section>
        <section id="sec3">
            @livewire('patient.patient-specialty')
        </section>

        <section id="sec5">
            @livewire('patient.patient-date')
        </section>
        @auth
        <section id="sec5">
            @livewire('patient.patient-info')
        </section>
        @endauth --}}
    </div>
    <footer
        class="text-center  py-6 bg-transparent font-semibold text-xs text-white shadow-lg m-0 p-0 fixed bottom-0 left-0 w-full ">
        <p class="text-xs">@ 2025 Policía de Tierra del Fuego, Antártida e Islas del Atlántico Sur.</p>
    </footer>

    @push('script')
        <script>
            window.addEventListener('load', event => {
                interval = localStorage.getItem('interval')
                doctor_id = localStorage.getItem('doctor_id')
                especialidade_id = localStorage.getItem('especialidade_id')
                day = localStorage.getItem('day')
                date = localStorage.getItem('date')
                price = localStorage.getItem('price')
                office = localStorage.getItem('office')

                if (interval !== null) {
                    Swal.fire({
                        title: 'Crear cita ?',
                        text: "Usted tiene una cita que no hemos registrado, ¿la registramos?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'si, crear la cita'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.dispatch('patient.patient-date', 'addAppoinment', interval,
                                doctor_id,
                                especialidade_id,
                                day,
                                date,
                                price,
                                office) //creamos la cita
                        } else {
                            localStorage.removeItem('interval')
                            localStorage.removeItem('doctor_id')
                            localStorage.removeItem('especialidade_id')
                            localStorage.removeItem('day')
                            localStorage.removeItem('date')
                            localStorage.removeItem('price')
                            localStorage.removeItem('office')
                        }
                    })

                }

            })
        </script>
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error al iniciar sesión',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            </script>
        @endif

    @endpush
</x-guest-layout>
