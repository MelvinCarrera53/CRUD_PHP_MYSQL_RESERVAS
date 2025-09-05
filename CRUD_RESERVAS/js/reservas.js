/* js/app.js */

// Helpers cortos
const $  = (sel, ctx=document) => ctx.querySelector(sel);
const $$ = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));

// =============== DataTables ===============
document.addEventListener('DOMContentLoaded', function () {
  const tabla = $('#tabla-reservas');
  if (tabla && typeof window.jQuery !== 'undefined' && typeof window.jQuery.fn.DataTable === 'function') {
    window.jQuery(tabla).DataTable({
      pageLength: 10,
      lengthChange: false
      // language: { url: 'ruta/a/es-ES.json' } // si luego agregas idioma
    });
  }

  // =============== SweetAlert2 (mensajes flash) ===============
  if (window.FLASH_SUCCESS) {
    Swal.fire({ icon: 'success', title: 'Reserva creada', text: window.FLASH_SUCCESS, timer: 3200, showConfirmButton: false });
  }
  if (Array.isArray(window.FLASH_ERRORS) && window.FLASH_ERRORS.length) {
    Swal.fire({
      icon: 'error',
      title: 'Revisa los datos',
      html: '<ul style="text-align:left;margin:0;padding-left:18px;">' +
        window.FLASH_ERRORS.map(e => `<li>${e}</li>`).join('') +
        '</ul>'
    });
  }

  // =============== Formulario flotante ===============
  const overlay = $('#form-flotante');
  const btnOpen  = $('#abrir-form');
  const btnClose = $('#cerrar-form');

  const inputMesa   = $('#res-mesa');
  const inputFecha  = $('#res-fecha');
  const inputHora   = $('#res-hora');
  const inputNombre = $('#res-nombre');
  const inputTel    = $('#res-telefono');
  const inputEmail  = $('#res-email');
  const inputNotas  = $('#res-notas');

  function openForm({ mesa = '', fecha = '', hora = '12:00' } = {}) {
    if (inputMesa)  inputMesa.value  = mesa || '';
    if (inputFecha) inputFecha.value = fecha || ( $('input[name="fecha_disp"]')?.value || $('input[name="fecha_listado"]')?.value || new Date().toISOString().slice(0,10) );
    if (inputHora)  inputHora.value  = hora || ( $('input[name="hora_disp"]')?.value || '12:00' );
    if (inputNombre) inputNombre.value = '';
    if (inputTel)    inputTel.value    = '';
    if (inputEmail)  inputEmail.value  = '';
    if (inputNotas)  inputNotas.value  = '';

    overlay.style.display = 'block';
    // accesibilidad
    overlay.setAttribute('aria-hidden', 'false');
    // foco inicial
    setTimeout(() => inputNombre?.focus(), 10);
  }

  function closeForm() {
    overlay.style.display = 'none';
    overlay.setAttribute('aria-hidden', 'true');
  }

  // Botón "Nueva reserva"
  btnOpen?.addEventListener('click', () => openForm({}));

  // Click en una mesa disponible del grid (prellenado)
  $$('.abrir-modal-reserva').forEach(btn => {
    btn.addEventListener('click', () => {
      const mesa  = btn.getAttribute('data-mesa') || '';
      const fecha = btn.getAttribute('data-fecha') || '';
      const hora  = btn.getAttribute('data-hora')  || '12:00';
      openForm({ mesa, fecha, hora });
    });
  });

  // Cerrar con la X
  btnClose?.addEventListener('click', closeForm);

  // Cerrar al hacer clic fuera del contenido
  overlay?.addEventListener('click', (e) => {
    if (e.target === overlay) closeForm();
  });

  // Cerrar con ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay?.style.display === 'block') closeForm();
  });
});
