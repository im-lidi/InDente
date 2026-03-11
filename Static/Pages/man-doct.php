<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $idDoctor     = $_POST["IdDoctor"] ?? "";
  $nombre       = $_POST["Nombre"] ?? "";
  $apellido     = $_POST["Apellido"] ?? "";
  $telefono     = $_POST["Telefono"] ?? "";
  $correo       = $_POST["Correo"] ?? "";
  $direccion    = $_POST["Direccion"] ?? "";
  $estado       = $_POST["Estado"] ?? "";
  $especialidad = $_POST["Especialidad"] ?? "";
  $fechaIngreso = $_POST["FechaIngreso"] ?? "";
  $idPersonal   = $_POST["IdPersonal"] ?? "";
  $idHorario    = $_POST["IdHorario"] ?? "";

  if ($idDoctor == "") {

      $stmt = $conn->prepare("INSERT INTO Doctores
      (Nombre,Apellido,Telefono,Correo,Direccion,Estado,Especialidad,FechaIngreso,IdPersonal,IdHorario)
      VALUES (?,?,?,?,?,?,?,?,?,?)");

      $stmt->execute([
        $nombre,$apellido,$telefono,$correo,$direccion,
        $estado,$especialidad,$fechaIngreso,$idPersonal,$idHorario
      ]);

  } else {

      $stmt = $conn->prepare("UPDATE Doctores SET
      Nombre=?,Apellido=?,Telefono=?,Correo=?,Direccion=?,Estado=?,Especialidad=?,FechaIngreso=?,IdPersonal=?,IdHorario=?
      WHERE IdDoctor=?");

      $stmt->execute([
        $nombre,$apellido,$telefono,$correo,$direccion,
        $estado,$especialidad,$fechaIngreso,$idPersonal,$idHorario,$idDoctor
      ]);
  }

  header("Location: man-doct.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Doctores WHERE IdDoctor=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: man-doct.php");
  exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Doctores WHERE IdDoctor=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Doctores");
$doctores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <p><?= count($doctores) ?> doctores registrados</p>
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
          <input type="hidden" name="IdDoctor" value="<?= $editData['IdSeguro'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label> Apellido</label>
              <input type="text" name="Apellido" value="<?= $editData['Apellido'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Teléfono</label>
              <input type="text" name="Telefono" value="<?= $editData['Telefono'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Correo</label>
              <input type="text" name="Correo" value="<?= $editData['Correo'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Dirección</label>
              <input type="text" name="Direccion" value="<?= $editData['Direccion'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Estado</label>
              <input type="text" name="Estado" value="<?= $editData['Estado'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Especialidad</label>
              <input type="text" name="Especialidad" value="<?= $editData['Especialidad'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Fecha Ingreso</label>
              <input type="date" name="FechaIngreso" value="<?= $editData['FechaIngreso'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>ID Personal</label>
              <input type="number" name="IdPersonal" value="<?= $editData['IdPersonal'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>ID Horario</label>
              <input type="number" name="IdHorario" value="<?= $editData['IdHorario'] ?? '' ?>">
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
    <div class="tabla-scroll">
    <table class="tablapaci">
      <thead>
        <tr>
          <th>ID Doctor</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Dirección</th>
          <th>Estado</th>
          <th>Especialidad</th>
          <th>Fecha Ingreso</th>
          <th>ID Personal</th>
          <th>ID Horario</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($doctores as $fila): ?>
      <tr>
        <td><?= $fila['IdDoctor'] ?></td>
        <td><?= $fila['Nombre'] ?></td>
        <td><?= $fila['Apellido'] ?></td>
        <td><?= $fila['Telefono'] ?></td>
        <td><?= $fila['Correo'] ?></td>
        <td><?= $fila['Direccion'] ?></td>
        <td><?= $fila['Estado'] ?></td>
        <td><?= $fila['Especialidad'] ?></td>
        <td><?= $fila['FechaIngreso'] ?></td>
        <td><?= $fila['IdPersonal'] ?></td>
        <td><?= $fila['IdHorario'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdDoctor'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdDoctor'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdDoctor'] ?> ?')"> Delete </a>
        </td>
      </tr>
<?php endforeach; ?>
    </tbody>
    </table>
    </div>
  </div>
</div>
<script src="../JS/app.js"></script>
</body>
</html>