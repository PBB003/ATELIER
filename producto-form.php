<?php
require_once "conexion.php";
require_once "auth.php";
requerirAdmin();

$id         = isset($_GET["id"]) ? (int) $_GET["id"] : (isset($_POST["id"]) ? (int) $_POST["id"] : 0);
$esEdicion  = $id > 0;
$error      = "";

$producto = [
    "nombre" => "", "descripcion" => "", "precio" => "",
    "stock" => "", "talla" => "", "color" => "", "categoria_id" => ""
];

// Si es edición y todavía no se ha enviado el formulario, cargamos los datos actuales
if ($esEdicion && $_SERVER["REQUEST_METHOD"] !== "POST") {
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $encontrado = $resultado->fetch_assoc();

    if (!$encontrado) {
        header("Location: productos.php");
        exit;
    }
    $producto = $encontrado;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre       = trim($_POST["nombre"] ?? "");
    $descripcion  = trim($_POST["descripcion"] ?? "");
    $precio       = (float) ($_POST["precio"] ?? 0);
    $stock        = (int)   ($_POST["stock"] ?? 0);
    $talla        = trim($_POST["talla"] ?? "");
    $color        = trim($_POST["color"] ?? "");
    $categoria_id = (int) ($_POST["categoria_id"] ?? 0);

    // Guardamos lo que el usuario escribió por si hay que re-mostrar el formulario con error
    $producto = compact("nombre", "descripcion", "precio", "stock", "talla", "color", "categoria_id");

    if ($nombre === "" || $categoria_id <= 0 || $precio < 0 || $stock < 0) {
        $error = "Nombre, categoría, precio y stock son obligatorios (precio y stock no pueden ser negativos).";
    } else {
        if ($esEdicion) {
            $stmt = $conexion->prepare(
                "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, talla=?, color=?, categoria_id=? WHERE id=?"
            );
            $stmt->bind_param(
                "ssdissii",
                $nombre, $descripcion, $precio, $stock, $talla, $color, $categoria_id, $id
            );
        } else {
            $stmt = $conexion->prepare(
                "INSERT INTO productos (nombre, descripcion, precio, stock, talla, color, categoria_id) VALUES (?,?,?,?,?,?,?)"
            );
            $stmt->bind_param(
                "ssdissi",
                $nombre, $descripcion, $precio, $stock, $talla, $color, $categoria_id
            );
        }
        $stmt->execute();
        header("Location: productos.php?ok=1");
        exit;
    }
}

$categorias = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre");

$titulo_pagina = $esEdicion ? "Editar producto" : "Nuevo producto";
include "header.php";
?>

<section>
  <div class="contenedor" style="max-width:560px; padding-top:48px; padding-bottom:56px;">
    <h1><?php echo $esEdicion ? "Editar producto" : "Nuevo producto"; ?></h1>

    <?php if ($error): ?>
      <p class="error-msg" style="margin-bottom:16px;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <?php if ($esEdicion): ?>
        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
      <?php endif; ?>

      <div class="campo">
        <label for="nombre">Nombre *</label>
        <input type="text" id="nombre" name="nombre" required
               value="<?php echo htmlspecialchars($producto['nombre']); ?>" style="border-radius:8px;">
      </div>

      <div class="campo">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($producto['descripcion'] ?? ""); ?></textarea>
      </div>

      <div class="campo">
        <label for="precio">Precio (RD$) *</label>
        <input type="number" step="0.01" min="0" id="precio" name="precio" required
               value="<?php echo htmlspecialchars((string) $producto['precio']); ?>" style="border-radius:8px;">
      </div>

      <div class="campo">
        <label for="stock">Stock *</label>
        <input type="number" min="0" id="stock" name="stock" required
               value="<?php echo htmlspecialchars((string) $producto['stock']); ?>" style="border-radius:8px;">
      </div>

      <div class="campo">
        <label for="talla">Talla</label>
        <input type="text" id="talla" name="talla"
               value="<?php echo htmlspecialchars($producto['talla'] ?? ""); ?>" style="border-radius:8px;">
      </div>

      <div class="campo">
        <label for="color">Color</label>
        <input type="text" id="color" name="color"
               value="<?php echo htmlspecialchars($producto['color'] ?? ""); ?>" style="border-radius:8px;">
      </div>

      <div class="campo">
        <label for="categoria_id">Categoría *</label>
        <select id="categoria_id" name="categoria_id" required style="border-radius:8px;">
          <option value="">Selecciona una categoría</option>
          <?php while ($c = $categorias->fetch_assoc()): ?>
            <option value="<?php echo (int) $c['id']; ?>"
              <?php echo ((string) $c['id'] === (string) ($producto['categoria_id'] ?? "")) ? "selected" : ""; ?>>
              <?php echo htmlspecialchars($c['nombre']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primario" style="border-radius:20px; padding:10px 28px;">
        <?php echo $esEdicion ? "Guardar cambios" : "Crear producto"; ?>
      </button>
      <a href="productos.php" style="margin-left:16px;">Cancelar</a>
    </form>
  </div>
</section>

<?php include "footer.php"; ?>
