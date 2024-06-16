function actualizarEstado(idLlamada) {
    const fechaInicio = new Date().toISOString().slice(0, 19).replace('T', ' '); // Formato de fecha MySQL
    fetch('actualizar_estado.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id_llamada=${idLlamada}&fecha_inicio=${fechaInicio}`,
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        window.location.href = `crear_ticket.php?id_llamada=${idLlamada}&fecha_inicio=${fechaInicio}`;
      } else {
        alert('Error al actualizar el estado de la llamada.');
      }
    })
    .catch(error => console.error('Error:', error));
  }