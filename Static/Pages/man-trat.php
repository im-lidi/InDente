<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST["IdTratamiento"] ?? "";
  $nombre = $_POST["Nombre"] ?? "";
  $descripcion = $_POST["Descripcion"] ?? "";
  $costo = $_POST["Costo"] ?? "";
  $duracion = $_POST["DuracionMinutos"] ?? "";

  if ($id == "") {

      $stmt = $conn->prepare("INSERT INTO Tratamientos
      (Nombre,Descripcion,Costo,DuracionMinutos)
      VALUES (?,?,?,?)");

      $stmt->execute([
        $nombre,
        $descripcion,
        $costo,
        $duracion
      ]);

  } else {

      $stmt = $conn->prepare("UPDATE Tratamientos SET
      Nombre=?,Descripcion=?,Costo=?,DuracionMinutos=?
      WHERE IdTratamiento=?");

      $stmt->execute([
        $nombre,
        $descripcion,
        $costo,
        $duracion,
        $id
      ]);
  }

  header("Location: man-trat.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Tratamientos WHERE IdTratamiento=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: man-trat.php");
  exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Tratamientos WHERE IdTratamiento=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Tratamientos");
$tratamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  <a href="home.php">Home</a>
  <a href="man-segu.php" class="active">Mantenimientos</a>
  <a href="con-paci.php">Consultas</a>
  <a href="pro-cons.php">Procesos</a>
  <a href="settings.php">Configuración</a>

    <!-- AVATAR ABAJO -->
    <div style="margin-top:auto;">
      <a href="../../../../Index.html" class="down">Come back</a>
        <div class="sidebar-avatar">
          <div class="avatar">LS</div>
          <div class="avatar-info">
            <span class="avatar-name">Lidiana Salazar</span>
            <span class="avatar-role">Admin</span>
          </div>
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
    <a href="man-doct.php">Doctores</a>
    <a href="man-empl.php">Empleados</a>
    <a href="man-usua.php">Usuarios</a>
    <a href="man-mate.php">Materiales</a>
    <a href="man-prov.php">Proveedores</a>
    <a href="man-trat.php" class="active">Tratamientos</a>
  </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Tratamientos disponibles</h2>
        <p><?= count($tratamientos) ?> tratamientos registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Tratamiento</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdTratamiento" value="<?= $editData['IdTratamiento'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Costo</label>
              <input type="number" name="Costo" value="<?= $editData['Costo'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Descripción</label>
              <input type="text" name="Descripcion" value="<?= $editData['Descripcion'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Duración (Minutos)</label>
              <input type="number" name="DuracionMinutos" value="<?= $editData['DuracionMinutos'] ?? '' ?>">
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
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Costo</th>
          <th>Duración (min)</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($tratamientos as $fila): ?>
      <tr>
        <td><?= $fila['IdTratamiento'] ?></td>
        <td><?= $fila['Nombre'] ?></td>
        <td><?= $fila['Descripcion'] ?></td>
        <td><?= $fila['Costo'] ?></td>
        <td><?= $fila['DuracionMinutos'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdTratamiento'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdTratamiento'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdTratamiento'] ?> ?')"> Delete </a>
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