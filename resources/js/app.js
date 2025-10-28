import './bootstrap';
// resources/js/app.js o donde centralices tu lógica JS
import Swal from 'sweetalert2';

// Hacemos que Swal esté disponible globalmente si lo necesitas en otros archivos
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {
    // Escucha todos los botones con la clase 'delete-confirm'
    document.querySelectorAll('.delete-confirm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Detiene el envío del formulario inmediatamente
            
            const itemId = this.getAttribute('data-item-id');
            const formId = `delete-form-${itemId}`;

            Swal.fire({
                title: '¿Está Seguro?',
                text: "¡El registro será borrado (lógicamente)!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Rojo para confirmar el borrado
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, ¡Borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si confirma, envía el formulario real a Laravel
                    document.getElementById(formId).submit();
                }
            });
        });
    });
});