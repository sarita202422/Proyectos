// Función para confirmar si el usuario realmente quiere actualizar un proyecto
function confirmarActualizacion() {
    return confirm("¿Estás seguro de que deseas actualizar este proyecto?");
}

// Función para confirmar si el usuario realmente quiere eliminar un proyecto
function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar este proyecto?");
}

// Función asíncrona que se encarga de cargar los proyectos desde la API
async function cargarProyectos() {
    // Se obtiene el contenedor donde se van a mostrar los proyectos
    const contenedor = document.getElementById("proyectos");

    // Se muestra un mensaje temporal mientras se cargan los datos
    contenedor.innerHTML = "Cargando...";

    try {
        // Se hace la solicitud a la API (archivo PHP que devuelve los proyectos en formato JSON)
        const res = await fetch("../../API/proyectos.php");

        // Si la respuesta no fue exitosa (por ejemplo, error 500 o 404)
        if (!res.ok) {
            // Se intenta leer el mensaje de error que viene del backend
            const errorData = await res.json();
            // Lanza un error con el mensaje recibido o uno genérico
            throw new Error(errorData.error || "Error desconocido");
        }

        // Si todo va bien, convierte la respuesta a formato JSON
        const proyectos = await res.json();

        // Si no hay proyectos, muestra un mensaje indicándolo
        if (proyectos.length === 0) {
            contenedor.innerHTML = "<p>No hay proyectos para mostrar.</p>";
            return;
        }

        // Si hay proyectos, se limpian los elementos anteriores
        contenedor.innerHTML = "";

        // Recorre cada proyecto recibido y los muestra dinámicamente
        proyectos.forEach(p => {
            contenedor.innerHTML += `
                <div>
                  <h3>${p.titulo}</h3>
                  <p>${p.descripcion}</p>
                  ${p.url_github ? `<a href="${p.url_github}" target="_blank">GitHub</a>` : ''}
                  ${p.url_produccion ? ` | <a href="${p.url_produccion}" target="_blank">Ver online</a>` : ''}
                  ${p.imagen ? `<br><img src=" ../../uploads/${p.imagen}" alt="${p.titulo}" width="200"><br>` : ''}
                  <hr>
                </div>
            `;
        });

    } catch (error) {
        // Si ocurre un error (por ejemplo, el servidor no responde), se muestra un mensaje rojo
        contenedor.innerHTML = `<p style="color:red;">Error al cargar proyectos: ${error.message}</p>`;
    }
}

// Llama a la función cargarProyectos cuando todo el documento HTML ha sido cargado
document.addEventListener("DOMContentLoaded", cargarProyectos);
