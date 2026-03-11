<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST["IdCita"] ?? "";
  $nombre = $_POST["Nombre"] ?? "";
  $apellido = $_POST["Apellido"] ?? "";
  $telefono = $_POST["Telefono"] ?? "";
  $fechaNacimiento = $_POST["FechaNacimiento"] ?? "";
  $cedula = $_POST["Cedula"] ?? "";
  $asegurado = $_POST["Asegurado"] ?? "";
  $doctor = $_POST["IdDoctor"] ?? "";
  $metodoPago = $_POST["MetodoPago"] ?? "";
  $observacion = $_POST["Observacion"] ?? "";
  $consulta = $_POST["IdConsulta"] ?? "";
  $fechaCita = $_POST["FechaCita"] ?? "";
  $horaCita = $_POST['HoraCita'] ?: null;

  if ($id == "") {

      $stmt = $conn->prepare("INSERT INTO Citas
      (Nombre,Apellido,Telefono,FechaNacimiento,Cedula,Asegurado,IdDoctor,MetodoPago,Observacion,IdConsulta,FechaCita,HoraCita)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

      /*var_dump($horaCita);
      exit;*/
      $stmt->execute([
        $nombre,
        $apellido,
        $telefono,
        $fechaNacimiento,
        $cedula,
        $asegurado,
        $doctor,
        $metodoPago,
        $observacion,
        $consulta,
        $fechaCita,
        $horaCita
      ]);

  } else {

      $stmt = $conn->prepare("UPDATE Citas SET
      Nombre=?,Apellido=?,Telefono=?,FechaNacimiento=?,Cedula=?,Asegurado=?,IdDoctor=?,MetodoPago=?,Observacion=?,IdConsulta=?,FechaCita=?,HoraCita=?
      WHERE IdCita=?");

      $stmt->execute([
        $nombre,
        $apellido,
        $telefono,
        $fechaNacimiento,
        $cedula,
        $asegurado,
        $doctor,
        $metodoPago,
        $observacion,
        $consulta,
        $fechaCita,
        $horaCita,
        $id
      ]);
  }

  header("Location: pro-cita.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Citas WHERE IdCita=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: pro-cita.php");
  exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Citas WHERE IdCita=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Citas");
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
      <a href="pro-diag.php">Diagnósticos</a>
      <a href="pro-cita.php" class="active">Citas</a>
      <a href="pro-coti.php">Cotizaciones</a>
    </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Citas disponibles</h2>
        <p><?= count($citas) ?> citas registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Cita</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdCita" value="<?= $editData['IdCita'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Apellido</label>
              <input type="text" name="Apellido" value="<?= $editData['Apellido'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Teléfono</label>
              <input type="text" name="Telefono" value="<?= $editData['Telefono'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Cédula</label>
              <input type="text" name="Cedula" value="<?= $editData['Cedula'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Fecha Nacimiento</label>
              <input type="date" name="FechaNacimiento" value="<?= $editData['FechaNacimiento'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Asegurado</label>
              <input type="text" name="Asegurado" value="<?= $editData['Asegurado'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>ID Doctor</label>
              <input type="number" name="IdDoctor" value="<?= $editData['IdDoctor'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>ID Consulta</label>
              <input type="number" name="IdConsulta" value="<?= $editData['IdConsulta'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Fecha Cita</label>
              <input type="date" name="FechaCita" value="<?= $editData['FechaCita'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Hora Cita</label>
              <input type="time" name="HoraCita" value="<?= $editData['HoraCita'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Método de Pago</label>
              <input type="text" name="MetodoPago" value="<?= $editData['MetodoPago'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Observación</label>
              <input type="text" name="Observacion" value="<?= $editData['Observacion'] ?? '' ?>">
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
          <th>ID</th>
          <th>Paciente</th>
          <th>Teléfono</th>
          <th>Cédula</th>
          <th>Doctor</th>
          <th>Consulta</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Método Pago</th>
          <th>Asegurado</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($citas as $fila): ?>
      <tr>
        <td><?= $fila['IdCita'] ?></td>
        <td><?= $fila['Nombre'] ?> <?= $fila['Apellido'] ?></td>
        <td><?= $fila['Telefono'] ?></td>
        <td><?= $fila['Cedula'] ?></td>
        <td><?= $fila['IdDoctor'] ?></td>
        <td><?= $fila['IdConsulta'] ?></td>
        <td><?= $fila['FechaCita'] ?></td>
        <td><?= $fila['HoraCita'] ?></td>
        <td><?= $fila['MetodoPago'] ?></td>
        <td><?= $fila['Asegurado'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdCita'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdCita'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdCitas'] ?> ?')"> Delete </a>
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