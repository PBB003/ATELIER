<?php
require_once "conexion.php";
require_once "auth.php";
requerirAdmin();

$titulo_pagina = "Productos";
include "header.php";

$productos = $conexion->query("
    SELECT p.id, p.nombre, p.precio, p.stock, c.nombre AS categoria
    FROM productos p
    JOIN categorias c ON c.id = p.categoria_id
    ORDER BY p.id DESC
");
?>

<section>
  <div class="contenedor" style="padding-top:48px; padding-bottom:56px;">
    <div class="section-titulo">
      <h1 style="margin:0;">Gestión de productos</h1>
      <a href="producto-form.php" class="btn btn-primario" style="border-radius:20px; padding:8px 20px;">
        + Nuevo producto
      </a>
    </div>

    <?php if (isset($_GET["ok"])): ?>
      <p class="alert-success">Cambios guardados correctamente.</p>
    <?php endif; ?>

    <?php if (isset($_GET["error"]) && $_GET["error"] === "csrf"): ?>
      <p class="error-msg">La solicitud no es válida. Inténtalo nuevamente.</p>
    <?php endif; ?>

    <?php if ($productos->num_rows === 0): ?>
      <p style="color:var(--ink-soft);">Todavía no hay productos. Crea el primero con el botón de arriba.</p>
    <?php else: ?>
      <div class="tabla-wrapper">
        <table class="tabla-materiales" style="width:100%;">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Categoría</th>
              <th scope="col">Precio</th>
              <th scope="col">Stock</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($p = $productos->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($p["categoria"]); ?></td>
                <td><?php echo number_format((float)$p["precio"], 2); ?></td>
                <td><?php echo (int)$p["stock"]; ?></td>
                <td>
                  <a href="producto-form.php?id=<?php echo (int) $p['id']; ?>">Editar</a>
                  &nbsp;|&nbsp;
                  <form method="POST" action="producto-eliminar.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo (int) $p['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo generarTokenCSRF(); ?>">
                    <button type="submit"
                            style="color:#B23A2E; background:none; border:none; padding:0; font:inherit; cursor:pointer;"
                            onclick="return confirm('¿Seguro que deseas eliminar «<?php echo htmlspecialchars(addslashes($p['nombre'])); ?>»? Esta acción no se puede deshacer.');">
                      Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include "footer.php"; ?>
