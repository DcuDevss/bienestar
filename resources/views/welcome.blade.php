<style>
    .contenedorColumnas{
        display: grid;
        grid-template-columns: 380px 300px; /* Dos columnas con anchos específicos */
        gap: 0px; /* Espacio entre las columnas */
    }
    .imgTitulo{
        height: 50%;
    }
    @media (max-width: 900px) {
        .contenedorColumnas{
            display: grid;
            grid-template-columns: 390px;
            gap: 0px;
        }
        .titulo{
            height: fit-content;
        }
        .imgTitulo{
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

                <div class="contenedorColumnas relative w-fit mx-auto text-center  py-16 pr-4 sm:py-20 sm:px-6 opacity-90 h-fit">

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

                        <div>
                            <x-validation-errors class="mb-4" />
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="float-left">
                            @csrf

                            <div>
                                <span class=" text-white block text-[23px] mt-3 float-left">
                                    {{ __('Informacion del usuario:') }}
                                </span>
                                <x-label class="text-white w-fit" for="email" value="{{ __('Email:') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <x-label class="text-white w-fit" for="password" value="{{ __('Password:') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            </div>



                            <div class="block mt-4 justify-center">
                              

                                <x-button class="ms-4 px-6 py-3 text-lg">
                                    {{ __('Log in') }}
                                </x-button>
                            </div>
                        </form>
                    </div>


                

                </div>
            </div>
        </section>

             
    </div>



    <footer class="text-center  py-6 bg-transparent font-semibold text-xs text-white shadow-lg m-0 p-0 fixed bottom-0 left-0 w-full ">
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
    @endpush
</x-guest-layout>












