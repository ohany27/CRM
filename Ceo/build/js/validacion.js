function validarCodigo() {
    const codigoCorrecto = "cesar123";
    const codigoIngresado = document.getElementById("passwordInput").value;

    if (codigoIngresado === codigoCorrecto) {
        alert("¡Código de Confirmación Correcto! Acceso permitido.");
        document.getElementById("modal").style.display = "none";
        return true; // Devuelve verdadero si el código es correcto
    } else {
        alert("Código incorrecto. Acceso denegado.");
        return false; // Devuelve falso si el código es incorrecto
    }
}

// Mostrar el cuadro de diálogo automáticamente al cargar la página
window.onload = function() {
    document.getElementById("modal").style.display = "block";

    // Asignar evento al botón de cierre después de que el DOM esté completamente cargado
    document.getElementById("close").onclick = function() {
        // Verifica si el código es correcto antes de redirigir
        if (!validarCodigo()) {
            window.location.href = "./../index.php"; // Redirigir a la página principal
        } else {
            document.getElementById("modal").style.display = "none";
        }
    };
};
