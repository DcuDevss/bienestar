
    <!-- Formulario -->
    <form wire:submit.prevent="updateFichaKinesiologica" class="space-y-10">
        @csrf

       @include('livewire.kinesiologia.kinesiologia-form', ['isEdit' => true])


            <a href="{{ route('kinesiologia.ficha-kinesiologica-index', ['paciente' => $paciente->id]) }}"
                class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </form>
</div>


<script>
    document.addEventListener('livewire:load', function () {
        window.addEventListener('swal', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                timer: event.detail.timer,
                showConfirmButton: false
            });

            if (event.detail.redirect) {
                setTimeout(() => {
                    window.location.href = event.detail.redirect;
                }, event.detail.timer);
            }
        });
    });
</script>

