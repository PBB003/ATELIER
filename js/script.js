const formulario = document.getElementById("form-contacto");

const nombre = document.getElementById("nombre");
const email = document.getElementById("email");
const telefono = document.getElementById("telefono");
const asunto = document.getElementById("asunto");
const mensaje = document.getElementById("mensaje");

// Arreglo con los asuntos disponibles en el formulario
const asuntosPermitidos = [
    "pedido",
    "tallas",
    "devolucion",
    "otro"
];


// Verifica si un campo está vacío
function estaVacio(valor) {
    return valor.trim() === "";
}


// Verifica si el correo tiene un formato válido
function esEmailValido(valor) {
    const formatoEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return formatoEmail.test(valor.trim());
}


// Verifica si el teléfono contiene solamente números y tiene un formato válido 
function esTelefonoValido(valor) {
    const telefono = valor.replace(/\D/g, "");

    return /^(809|829|849)\d{7}$/.test(telefono);
}


// Verifica si el asunto seleccionado pertenece al arreglo
function esAsuntoValido(valor) {
    return asuntosPermitidos.includes(valor);
}


// Muestra un mensaje de error debajo del campo
function mostrarError(campo, texto) {
    campo.classList.add("is-invalid");

    let mensajeError = document.getElementById(`error-${campo.id}`);

    if (!mensajeError) {
        mensajeError = document.createElement("p");
        mensajeError.id = `error-${campo.id}`;
        mensajeError.classList.add("error-msg");
        campo.parentElement.appendChild(mensajeError);
    }

    mensajeError.textContent = texto;

    return true;
}


// Quita el error de un campo
function quitarError(campo) {
    campo.classList.remove("is-invalid");

    const mensajeError = document.getElementById(`error-${campo.id}`);

    if (mensajeError) {
        mensajeError.remove();
    }

    return true;
}


// Valida un campo individual
function validarCampo(campo) {

    if (campo === nombre) {

        if (estaVacio(nombre.value)) {
            mostrarError(nombre, "El nombre completo es obligatorio.");
            return false;
        }

        quitarError(nombre);
        return true;
    }


    if (campo === email) {

        if (estaVacio(email.value)) {
            mostrarError(email, "El correo electrónico es obligatorio.");
            return false;
        }

        if (!esEmailValido(email.value)) {
            mostrarError(email, "Ingresa un correo electrónico válido.");
            return false;
        }

        quitarError(email);
        return true;
    }


    if (campo === telefono) {

        if (!estaVacio(telefono.value) && !esTelefonoValido(telefono.value)) {
            mostrarError(
                telefono,
                "Ingresa un teléfono válido de 10 dígitos (809, 829 u 849)."
            );
            return false;
        }

        quitarError(telefono);
        return true;
    }


    if (campo === asunto) {

        if (!esAsuntoValido(asunto.value)) {
            mostrarError(asunto, "Debes seleccionar un asunto.");
            return false;
        }

        quitarError(asunto);
        return true;
    }


    if (campo === mensaje) {

        if (estaVacio(mensaje.value)) {
            mostrarError(mensaje, "El mensaje es obligatorio.");
            return false;
        }

        quitarError(mensaje);
        return true;
    }

    return true;
}


// Elimina el mensaje de confirmación anterior
function quitarConfirmacion() {
    const confirmacionAnterior = document.getElementById("mensaje-confirmacion");

    if (confirmacionAnterior) {
        confirmacionAnterior.remove();
    }

    return true;
}

// Elimina el mensaje de confirmación anterior
function quitarConfirmacion() {
    const confirmacionAnterior = document.getElementById("mensaje-confirmacion");

    if (confirmacionAnterior) {
        confirmacionAnterior.remove();
    }

    return true;
}

// Crea una tarjeta de confirmación dinámica
function mostrarConfirmacion(nombreUsuario) {

    const confirmacion = document.createElement("div");

    confirmacion.id = "mensaje-confirmacion";

    confirmacion.innerHTML = `
        <h2>Mensaje enviado correctamente</h2>
        <p>
            Gracias, <strong>${nombreUsuario}</strong>.
            Hemos recibido tu consulta y nos pondremos en contacto contigo.
        </p>
    `;

    formulario.parentElement.insertBefore(
        confirmacion,
        formulario
    );

    return confirmacion;
}


// Validación al enviar el formulario
formulario.addEventListener("submit", function (event) {

    event.preventDefault();
    quitarConfirmacion();

    const nombreValido = validarCampo(nombre);
    const emailValido = validarCampo(email);
    const telefonoValido = validarCampo(telefono);
    const asuntoValido = validarCampo(asunto);
    const mensajeValido = validarCampo(mensaje);

    const formularioValido =
        nombreValido &&
        emailValido &&
        telefonoValido &&
        asuntoValido &&
        mensajeValido;


    if (!formularioValido) {
        return;
    }


    // Guardamos el nombre antes de limpiar el formulario
    const nombreUsuario = nombre.value.trim();

    // Limpiamos el formulario
    formulario.reset();

    // Mostramos la confirmación dinámicamente
    mostrarConfirmacion(nombreUsuario);

    console.log("Formulario enviado correctamente");
});


// Validación mientras el usuario escribe
nombre.addEventListener("input", function () {
    validarCampo(nombre);
});

email.addEventListener("input", function () {
    validarCampo(email);
});

telefono.addEventListener("input", function () {
    telefono.value = telefono.value.replace(/\D/g, "").slice(0, 10);
    validarCampo(telefono);
});

mensaje.addEventListener("input", function () {
    validarCampo(mensaje);
});


// Validación cuando cambia el asunto
asunto.addEventListener("change", function () {
    validarCampo(asunto);
});