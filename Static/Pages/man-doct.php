<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id        = $_POST["IdSeguro"] ?? "";
  $nombre    = $_POST["Nombre"] ?? "";
  $tipoPlan  = $_POST["TipoPlan"] ?? "";
  $cobertura = $_POST["CoberturaPorcentaje"] ?? "";
  $telefono  = $_POST["Telefono"] ?? "";

  if ($id == "") {
      $stmt = $conn->prepare("INSERT INTO seguros (Nombre, TipoPlan, CoberturaPorcentaje, Telefono) VALUES (?, ?, ?, ?)");
      $stmt->execute([$nombre, $tipoPlan, $cobertura, $telefono]);
  } else {
      $stmt = $conn->prepare("UPDATE seguros SET Nombre=?, TipoPlan=?, CoberturaPorcentaje=?, Telefono=? WHERE IdSeguro=?");
      $stmt->execute([$nombre, $tipoPlan, $cobertura, $telefono, $id]);
  }

  header("Location: man-segu.php");
  exit();
}



/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {
  $stmt = $conn->prepare("DELETE FROM seguros WHERE IdSeguro=?");
  $stmt->execute([$_GET["delete"]]);
  header("Location: man-segu.php");
  exit();
}



/* =========================
   EDITAR
========================= */
$editData = null;

if (isset($_GET["edit"])) {
  $stmt = $conn->prepare("SELECT * FROM seguros WHERE IdSeguro=?");
  $stmt->execute([$_GET["edit"]]);
  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}



/* =========================
   LISTAR
========================= */
$stmt = $conn->query("SELECT * FROM seguros");
$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title> InDente - Mantenimientos</title>
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

<div class="sidebar">
  <h2>InDente</h2>
  <a href=".">Home</a>
  <a href="man-segu.php" class="active">Mantenimientos</a>
  <a href="con-paci.php">Consultas</a>
  <a href="pro-cons.php">Procesos</a>
  <a href="settings.php">Configuración</a>

  <div class="sidebar-avatar">
    <div class="avatar">LS</div>
    <div class="avatar-info">
      <span class="avatar-name">Lidiana Salazar</span>
      <span class="avatar-role">Admin</span>
    </div>
  </div>
</div>

<div class="main">

 <!-- HEADER -->
  <div class="header">
    <h1><a href="home.php">Dashboard </a>> Mantenimientos</h1>
    <span class="fecha"><?php echo date('F d, Y'); ?></span>
  </div>

  <div class="tabs">
    <a href="man-segu.php">Seguros</a>
    <a href="man-paci.php">Pacientes</a>
    <a href="man-doct.php" class="active">Doctores</a>
    <a href="man-empl.php">Empleados</a>
    <a href="man-usua.php">Usuarios</a>
    <a href="man-mate.php">Materiales</a>
    <a href="man-prov.php">Proveedores</a>
    <a href="man-trat.php">Tratamientos</a>
  </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Doctores disponibles</h2>
        <p><?= count($seguros) ?> doctores registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Doctor</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdSeguro" value="<?= $editData['IdSeguro'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Tipo Plan</label>
              <input type="text" name="TipoPlan" value="<?= $editData['TipoPlan'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Cobertura</label>
              <input type="number" name="CoberturaPorcentaje" value="<?= $editData['CoberturaPorcentaje'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Teléfono</label>
              <input type="text" name="Telefono" value="<?= $editData['Telefono'] ?? '' ?>">
            </div>
          </div>

          <div class="form-buttons">
            <button type="button" class="btn btn-gray" onclick="cerrarModal('modal-form')">Cancel</button>
            <button type="submit" class="btn btn-green">Save</button>
          </div>
        </form>
      </div>
    </div>

    <!-- TABLA -->
    <table class="tabla">
      <thead>
        <tr>
          <th>Código de Seguro</th>
          <th>Nombre</th>
          <th>Tipo Plan</th>
          <th>Cobertura</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($seguros as $fila): ?>
      <tr>
        <td><?= $fila['IdSeguro'] ?></td>
        <td><?= $fila['Nombre'] ?></td>
        <td><?= $fila['TipoPlan'] ?></td>
        <td><?= $fila['CoberturaPorcentaje'] ?></td>
        <td><?= $fila['Telefono'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdSeguro'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdSeguro'] ?>" class="btn btn-small btn-red" onclick="return confirm('Are you sure you want to delete this record?')"> Delete </a>
        </td>
      </tr>
<?php endforeach; ?>
    </tbody>
    </table>
  </div>
</div>
<script src="../JS/app.js"></script>
</body>
</html>