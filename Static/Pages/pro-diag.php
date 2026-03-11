<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST["IdDiagnostico"] ?? "";
  $cedula = $_POST["Cedula"] ?? "";
  $doctor = $_POST["IdDoctor"] ?? "";
  $tratamiento = $_POST["IdTratamiento"] ?? "";
  $proceso = $_POST["IdProceso"] ?? "";
  $descripcion = $_POST["Descripcion"] ?? "";

  if ($id == "") {

      $stmt = $conn->prepare("INSERT INTO Diagnosticos
      (Cedula,IdDoctor,IdTratamiento,IdProceso,Descripcion)
      VALUES (?,?,?,?,?)");

      $stmt->execute([
        $cedula,
        $doctor,
        $tratamiento,
        $proceso,
        $descripcion
      ]);

  } else {

      $stmt = $conn->prepare("UPDATE Diagnosticos SET
      Cedula=?,IdDoctor=?,IdTratamiento=?,IdProceso=?,Descripcion=?
      WHERE IdDiagnostico=?");

      $stmt->execute([
        $cedula,
        $doctor,
        $tratamiento,
        $proceso,
        $descripcion,
        $id
      ]);
  }

  header("Location: pro-diag.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Diagnosticos WHERE IdDiagnostico=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: pro-diag.php");
  exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Diagnosticos WHERE IdDiagnostico=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Diagnosticos");
$diagnosticos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
      <a href="pro-cons.php">Consultas</a>
      <a href="pro-diag.php" class="active">Diagnósticos</a>
      <a href="pro-cita.php">Citas</a>
      <a href="pro-coti.php">Cotizaciones</a>
    </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Diagnósticos disponibles</h2>
        <p><?= count($diagnosticos) ?> diagnósticos registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Diagnóstico</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdDiagnostico" value="<?= $editData['IdDiagnostico'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Cédula Paciente</label>
              <input type="text" name="Cedula" value="<?= $editData['Cedula'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>ID Doctor</label>
              <input type="number" name="IdDoctor" value="<?= $editData['IdDoctor'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>ID Tratamiento</label>
              <input type="number" name="IdTratamiento" value="<?= $editData['IdTratamiento'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>ID Proceso</label>
              <input type="number" name="IdProceso" value="<?= $editData['IdProceso'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Descripción</label>
              <input type="text" name="Descripcion" value="<?= $editData['Descripcion'] ?? '' ?>">
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
          <th>Doctor</th>
          <th>Tratamiento</th>
          <th>Proceso</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($diagnosticos as $fila): ?>
      <tr>
        <td><?= $fila['IdDiagnostico'] ?></td>
        <td><?= $fila['Cedula'] ?></td>
        <td><?= $fila['IdDoctor'] ?></td>
        <td><?= $fila['IdTratamiento'] ?></td>
        <td><?= $fila['IdProceso'] ?></td>
        <td><?= $fila['Descripcion'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdDiagnostico'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdDiagnostico'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdDiagnostico'] ?> ?')"> Delete </a>
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