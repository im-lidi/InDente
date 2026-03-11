<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id = $_POST["IdCotizacion"] ?? "";
$cedula = $_POST["Cedula"] ?? "";
$idProceso = $_POST["IdProceso"] ?? "";
$monto = $_POST["MontoTotal"] ?? "";
$formaPago = $_POST["FormaPago"] ?? "";
$fechaPago = $_POST["FechaPago"] ?? null;

if ($id == "") {

$stmt = $conn->prepare("
INSERT INTO Cotizaciones
(Cedula, IdProceso, MontoTotal, FormaPago, FechaPago)
VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([$cedula,$idProceso,$monto,$formaPago,$fechaPago]);

} else {

$stmt = $conn->prepare("
UPDATE Cotizaciones
SET Cedula=?, IdProceso=?, MontoTotal=?, FormaPago=?, FechaPago=?
WHERE IdCotizacion=?
");

$stmt->execute([$cedula,$idProceso,$monto,$formaPago,$fechaPago,$id]);

}

header("Location: pro-coti.php");
exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

$stmt = $conn->prepare("DELETE FROM Cotizaciones WHERE IdCotizacion=?");
$stmt->execute([$_GET["delete"]]);

header("Location: pro-coti.php");
exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

$stmt = $conn->prepare("SELECT * FROM Cotizaciones WHERE IdCotizacion=?");
$stmt->execute([$_GET["edit"]]);

$editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Cotizaciones");
$cotizaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title> InDente - Procesos</title>
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

<div class="sidebar">
  <h2>InDente</h2>
  <a href="home.php">Home</a>
  <a href="man-segu.php">Mantenimientos</a>
  <a href="con-paci.php">Consultas</a>
  <a href="pro-cons.php" class="active">Procesos</a>
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
    <h1><a href="home.php">Dashboard </a>> Procesos</h1>
    <span class="fecha"><?php echo date('F d, Y'); ?></span>
  </div>

    <!-- MENU INTERNO -->
    <div class="tabs">
      <a href="pro-cons.php" >Consultas</a>
      <a href="pro-diag.php">Diagnósticos</a>
      <a href="pro-cita.php">Citas</a>
      <a href="pro-coti.php"class="active">Cotizaciones</a>
    </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Cotizaciones disponibles</h2>
        <p><?= count($cotizaciones) ?> cotizaciones registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Contización</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdCotizacion" value="<?= $editData['IdCotizacion'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Cédula</label>
              <input type="text" name="Cedula" value="<?= $editData['Cedula'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>ID Proceso</label>
              <input type="number" name="IdProceso" value="<?= $editData['IdProceso'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Monto Total</label>
              <input type="number" name="MontoTotal" value="<?= $editData['MontoTotal'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Forma de Pago</label>
              <input type="text" name="FormaPago" value="<?= $editData['FormaPago'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Fecha de Pago</label>
              <input type="date" name="FechaPago" value="<?= $editData['FechaPago'] ?? '' ?>">
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
          <th>Cédula</th>
          <th>Proceso</th>
          <th>Monto</th>
          <th>Forma Pago</th>
          <th>Fecha Pago</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($cotizaciones as $fila): ?>
      <tr>
        <td><?= $fila['IdCotizacion'] ?></td>
        <td><?= $fila['Cedula'] ?></td>
        <td><?= $fila['IdProceso'] ?></td>
        <td><?= $fila['MontoTotal'] ?></td>
        <td><?= $fila['FormaPago'] ?></td>
        <td><?= $fila['FechaPago'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdCotizacion'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdCotizacion'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdCotizacion'] ?> ?')"> Delete </a>
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