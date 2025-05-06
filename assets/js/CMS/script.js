document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const titulo = document.getElementById('titulo');
    const contenido = document.getElementById('contenido');

    // Crear un contenedor para mensajes
    const mensajeDiv = document.createElement('div');
    form.appendChild(mensajeDiv);

    form.addEventListener('submit', (e) => {
        mensajeDiv.innerHTML = '';
        mensajeDiv.style.marginTop = '10px';

        // Validación
        if (titulo.value.trim() === '' || contenido.value.trim() === '') {
            e.preventDefault();
            mensajeDiv.textContent = 'Por favor, completa todos los campos.';
            mensajeDiv.style.color = 'red';
        } else {
            mensajeDiv.textContent = 'Publicación enviada correctamente.';
            mensajeDiv.style.color = 'green';
        }
    });
});
