<div class="p-4 text-center">
  <button
    x-data
    @click.prevent="
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción recalculará los días de todas las licencias del año en curso.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, resetear',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
      }).then((r) => { if (r.isConfirmed) { $wire.resetAll() } })
    "
    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
    wire:loading.attr="disabled"
  >
    Resetear licencias del año en curso
  </button>
</div>
{{-- sweet alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('livewire:init', () => {
    Livewire.on('swal', (payload = {}) => {
      const { title = 'Listo', text = '', icon = 'success', toast = true } = payload;
      Swal.fire({
        title, text, icon,
        toast,
        position: toast ? 'top-end' : 'center',
        timer: toast ? 3000 : undefined,
        showConfirmButton: !toast,
        timerProgressBar: toast,
      });
    });
  });
</script>

