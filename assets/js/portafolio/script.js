document.addEventListener("DOMContentLoaded", function () {
    // Menú hamburguesa
    const menuToggle = document.querySelector(".menu-toggle");
    const mainNav = document.querySelector(".main-nav");
  
    menuToggle.addEventListener("click", () => {
      mainNav.classList.toggle("nav-open");
    });
  
    // Botón volver arriba
    const backToTopBtn = document.querySelector(".back-to-top");
  
    window.addEventListener("scroll", () => {
      if (window.scrollY > 300) {
        backToTopBtn.style.display = "flex";
      } else {
        backToTopBtn.style.display = "none";
      }
    });
  
    // Validación del formulario
    const form = document.getElementById("contact-form");
    const msg = document.getElementById("form-msg");
  
    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
  
        const nombreInput = document.getElementById("nombre");
        const correoInput = document.getElementById("correo");
        const mensajeInput = document.getElementById("mensaje");
  
        const nombre = nombreInput.value.trim();
        const correo = correoInput.value.trim();
        const mensaje = mensajeInput.value.trim();
  
        const correoValido = /^[^\s@]+@[^\s@]+\.(com|cl|net|org|edu|gov|es)$/i;
  
        // Resetear errores
        [nombreInput, correoInput, mensajeInput].forEach(input =>
          input.classList.remove("error")
        );
        msg.textContent = "";
  
        if (!nombre) {
          nombreInput.classList.add("error");
          nombreInput.focus();
          msg.textContent = "Por favor ingresa tu nombre.";
          msg.style.color = "var(--color-error)";
          return;
        }
  
        if (!correo) {
          correoInput.classList.add("error");
          correoInput.focus();
          msg.textContent = "Por favor ingresa tu correo.";
          msg.style.color = "var(--color-error)";
          return;
        }
  
        if (!correoValido.test(correo)) {
          correoInput.classList.add("error");
          correoInput.focus();
          msg.textContent =
            "Por favor ingresa un correo electrónico válido (ej: nombre@correo.com).";
          msg.style.color = "var(--color-error)";
          return;
        }
  
        if (!mensaje) {
          mensajeInput.classList.add("error");
          mensajeInput.focus();
          msg.textContent = "Por favor escribe un mensaje.";
          msg.style.color = "var(--color-error)";
          return;
        }
  
        msg.textContent = "Mensaje enviado correctamente. ¡Gracias!";
        msg.style.color = "var(--color-success)";
        form.reset();
      });
  
      // Eliminar error al escribir
      ["nombre", "correo", "mensaje"].forEach(id => {
        const input = document.getElementById(id);
        input.addEventListener("input", () => {
          input.classList.remove("error");
        });
      });
    }
  });
  