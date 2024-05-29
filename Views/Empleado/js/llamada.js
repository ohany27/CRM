// Función para actualizar la fecha final y deshabilitar los campos de select cuando cambia el estado
document.getElementById('id_estado').addEventListener('change', function() {
    var estadoSelect = document.getElementById('id_estado');
    var fechaFinalInput = document.getElementById('fecha_final');
    var urgenciaSelect = document.getElementById('urgencia');
    var tecnicoSelect = document.getElementById('tecnico');

    // Si el estado seleccionado es "Solucionado" (cuyo valor es 5)
    if (estadoSelect.value == 5) {
        // Obtener la fecha actual
        var fechaActual = new Date().toISOString().slice(0, 10); // Formato YYYY-MM-DD
        // Establecer la fecha actual en el campo de fecha final
        fechaFinalInput.value = fechaActual;

        // Deshabilitar el campo de urgencia
        urgenciaSelect.disabled = true;
        // Reiniciar el campo de urgencia a su valor predeterminado
        urgenciaSelect.value = urgenciaDefault;

        // Deshabilitar el campo de técnico
        tecnicoSelect.disabled = true;
        // Reiniciar el campo de técnico a su valor predeterminado
        tecnicoSelect.value = tecnicoDefault;
    } else {
        // Si el estado no es "Solucionado", dejar el campo de fecha final vacío
        fechaFinalInput.value = '';

        // Habilitar los campos de select de urgencia y técnico
        urgenciaSelect.disabled = false;
        tecnicoSelect.disabled = false;
    }
});

// Al cargar la página, almacenar los valores iniciales de los campos de urgencia y técnico
window.addEventListener('load', function() {
    var urgenciaSelect = document.getElementById('urgencia');
    var tecnicoSelect = document.getElementById('tecnico');
    // Almacenar los valores iniciales de los campos de urgencia y técnico
    urgenciaDefault = urgenciaSelect.value;
    tecnicoDefault = tecnicoSelect.value;
});
