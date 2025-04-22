// Esperar a que el documento esté listo
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("spaceForm");
  
    // Capturamos los campos del formulario
    const nombre = document.getElementById("nombre");
    const edad = document.getElementById("edad");
    const correo = document.getElementById("correo");
    const pais = document.getElementById("pais");
    const motivo = document.getElementById("motivo");
  
    // Capturamos los contenedores de error
    const errores = {
      nombre: document.getElementById("error-nombre"),
      edad: document.getElementById("error-edad"),
      correo: document.getElementById("error-correo"),
      pais: document.getElementById("error-pais"),
      motivo: document.getElementById("error-motivo")
    };
  
    // Función para validar el correo con regex
    function validarCorreo(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }
  
    // Función principal de validación
    function validarFormulario(e) {
      e.preventDefault(); // Prevenir envío
  
      let valido = true;
  
      // Limpiar errores anteriores
      Object.values(errores).forEach(span => {
        span.innerHTML = "";
      });
  
      // Validaciones
      if (nombre.value.trim() === "") {
        errores.nombre.innerHTML = "Por favor, ingresa tu nombre.";
        valido = false;
      }
  
      if (edad.value.trim() === "" || edad.value < 18 || edad.value > 65) {
        errores.edad.innerHTML = "Ingresa una edad válida entre 18 y 65 años.";
        valido = false;
      }
  
      if (correo.value.trim() === "" || !validarCorreo(correo.value)) {
        errores.correo.innerHTML = "Correo electrónico no válido.";
        valido = false;
      }
  
      if (pais.value === "") {
        errores.pais.innerHTML = "Selecciona un país.";
        valido = false;
      }
  
      if (motivo.value.trim() === "") {
        errores.motivo.innerHTML = "Escribe por qué quieres viajar al espacio.";
        valido = false;
      }
  
      // Si todo está bien, mostrar mensaje de éxito
      if (valido) {
        form.innerHTML = `<p class="success-message">¡Gracias por postular! Te contactaremos pronto para tu aventura espacial. 🚀</p>`;
      }
    }
  
    // Evento submit
    form.addEventListener("submit", validarFormulario);
  
    // Validación en tiempo real (opcional)
    [nombre, edad, correo, pais, motivo].forEach(input => {
      input.addEventListener("input", () => {
        errores[input.id].innerHTML = "";
      });
    });
  });
  