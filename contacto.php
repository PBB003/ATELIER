<?php
$titulo_pagina = "Contacto";
include "header.php";
?>
<style>
  .site-header #logo img {
    width: 135px;
    height: auto;
  }
  .error-msg {
    color: #B23A2E;
    font-size: 0.85rem;
    margin-top: 6px;
    margin-bottom: 0;
}

.is-invalid {
    border-color: #B23A2E !important;
    outline: 2px solid rgba(178, 58, 46, 0.12);
}

#mensaje-confirmacion {
    margin-bottom: 24px;
    padding: 20px 24px;
    border: 1px solid #3A7D44;
    background: rgba(58, 125, 68, 0.08);
    border-radius: 8px;
}

#mensaje-confirmacion h2 {
    margin: 0 0 8px;
    color: #3A7D44;
    font-size: 1.2rem;
}

#mensaje-confirmacion p {
    margin: 0;
}
</style>

<section>
  <?php if (isset($_GET["ok"])): ?>
    <p class="alert-success">&iexcl;Gracias! Tu mensaje fue enviado correctamente.</p>
  <?php endif; ?>

  <?php if (isset($_GET["error"])): ?>
    <p class="error-msg">Hubo un problema al enviar tu mensaje. Revisa los campos e int&eacute;ntalo de nuevo.</p>
  <?php endif; ?>
  <div class="contenedor form-layout">

      <div>
        <p class="hero-eyebrow" style="color:var(--accent-2); letter-spacing: .14em;">
  Estamos para ayudarte
</p>
        <h1>Hablemos de tu próxima pieza</h1>
        <p style="max-width: 500px; line-height: 1.7;">
  ¿Tienes dudas sobre una talla, un pedido o una devolución?
  Escríbenos y nuestro equipo estará encantado de ayudarte.
</p>

        <!-- MÉTODO 3 CSS EN LÍNEA -->
        <p style="font-family:var(--font-mono); font-size:.78rem; color:var(--ink-soft); border-left:2px solid var(--accent); padding-left:10px; margin-top:24px;">
          Todos los campos marcados con * son obligatorios.
        </p>

       <form id="form-contacto" method="POST" action="contacto-procesar.php" novalidate>

  <fieldset>
    <legend>Tus datos</legend>

    <div class="campo">
      <label for="nombre">Nombre completo *</label>
      <input 
        type="text" 
        id="nombre" 
        name="nombre" 
        placeholder="Ej. Ana Torres" 
        required
        style="border-radius: 8px;">
    </div>

    <div class="campo">
      <label for="email">Correo electrónico *</label>
      <input 
        type="email" 
        id="email" 
        name="email" 
        placeholder="tu@correo.com" 
        required
        style="border-radius: 8px;">
    </div>

    <div class="campo">
      <label for="telefono">Teléfono</label>
      <input 
        type="tel" 
        id="telefono" 
        name="telefono" 
        placeholder="Opcional"
        style="border-radius: 8px;">
      
      <p class="ayuda">Solo si prefieres que te llamemos.</p>
    </div>

  </fieldset>


  <fieldset>
    <legend>Tu consulta</legend>

    <div class="campo">
      <label for="asunto">Asunto *</label>

      <select 
        id="asunto" 
        name="asunto" 
        required 
        style="border-radius: 8px;">

        <option value="">Selecciona una opción</option>
        <option value="pedido">Estado de un pedido</option>
        <option value="tallas">Guía de tallas</option>
        <option value="devolucion">Cambios y devoluciones</option>
        <option value="otro">Otro</option>

      </select>
    </div>


    <div class="campo">
      <label>Prefiero que me respondan por</label>

      <div class="radio-grupo">

        <label style="border-radius: 25px;">
          <input 
            type="radio" 
            name="canal" 
            value="email" 
            checked>
          Correo
        </label>

        <label style="border-radius: 25px;">
          <input 
            type="radio" 
            name="canal" 
            value="telefono">
          Teléfono
        </label>

        <label style="border-radius: 25px;">
          <input 
            type="radio" 
            name="canal" 
            value="whatsapp">
          WhatsApp
        </label>

      </div>
    </div>


    <div class="campo">
      <label for="mensaje">Mensaje *</label>

      <textarea 
        id="mensaje" 
        name="mensaje" 
        placeholder="Cuéntanos en qué te podemos ayudar..." 
        required>
      </textarea>
    </div>


    <div class="campo">
      <div class="checkbox-grupo">

        <label>
          <input 
            type="checkbox" 
            name="boletin">
          Quiero recibir el boletín con novedades y descuentos
        </label>

      </div>
    </div>

  </fieldset>


  <button 
    type="submit" 
    class="btn btn-primario" 
    style="border-radius: 20px; padding: 10px 28px;">
    Enviar mensaje
  </button>
        
</form>
      </div>

      <aside class="form-resumen" style="
  padding: 32px;
  border: 1px solid rgba(179, 109, 11, 0.08);
  box-shadow: 0 6px 12px rgba(0,0,0,.04);
">
        <h2 style="
  font-size: 1.35rem;
  margin-bottom: 20px;
">
  Otras formas de contacto
</h2>
        <ul>
          <li>
  <span>Correo</span>
  <span style="width: 205px; text-align: left;">
    contacto@atelier.com
  </span>
</li>

<li>
  <span>Teléfono</span>
  <span style="width: 205px; text-align: left;">
    829 123 4567
  </span>
</li>
 <li>
  <span>Horario</span>

  <span style="text-align: left;">
    <span style="display: block;">
      Lun–Vie 9:00 a.m – 8:00 p.m
    </span>

    <span style="display: block;">
      Sáb 9:00 a.m – 2:00 p.m
    </span>
  </span>
</li>

  </span>
</li>
        </ul>
        <p style="font-size:.85rem;color:var(--ink-soft);">¿Buscas tu talla? Consulta primero nuestra <a href="#" style="text-decoration:underline;">guía de tallas</a>, resuelve la mayoría de las dudas al instante.</p>
      </aside>

    </div>
  </section>
  <script src="js/script.js"></script>

<?php include "footer.php"; ?>
