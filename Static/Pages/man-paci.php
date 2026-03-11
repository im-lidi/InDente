<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $cedula = $_POST["Cedula"] ?? "";
  $nombre = $_POST["Nombre"] ?? "";
  $apellido = $_POST["Apellido"] ?? "";
  $fecha = $_POST["FechaNacimiento"] ?? "";
  $sexo = $_POST["Sexo"] ?? "";
  $telefono = $_POST["Telefono"] ?? "";
  $correo = $_POST["Correo"] ?? "";
  $direccion = $_POST["Direccion"] ?? "";
  $condicion = $_POST["CondicionSalud"] ?? "";
  $seguro = $_POST["IdSeguro"] ?? "";
  $plan = $_POST["TipoPlan"] ?? "";
  $estado = $_POST["Estado"] ?? "";

  if ($_POST["editando"] == 0) {

      $stmt = $conn->prepare("INSERT INTO Pacientes 
      (Cedula, Nombre, Apellido, FechaNacimiento, Sexo, Telefono, Correo, Direccion, CondicionSalud, IdSeguro, TipoPlan, FechaRegistro, Estado)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)");

      $stmt->execute([$cedula,$nombre,$apellido,$fecha,$sexo,$telefono,$correo,$direccion,$condicion,$seguro,$plan,$estado]);

  } else {

      $stmt = $conn->prepare("UPDATE Pacientes SET 
      Nombre=?, Apellido=?, FechaNacimiento=?, Sexo=?, Telefono=?, Correo=?, Direccion=?, CondicionSalud=?, IdSeguro=?, TipoPlan=?, Estado=?
      WHERE Cedula=?");

      $stmt->execute([$nombre,$apellido,$fecha,$sexo,$telefono,$correo,$direccion,$condicion,$seguro,$plan,$estado,$cedula]);
  }

  header("Location: man-paci.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */
if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Pacientes WHERE Cedula=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: man-paci.php");
  exit();
}


/* =========================
   EDITAR
========================= */
$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Pacientes WHERE Cedula=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */
$stmt = $conn->query("SELECT * FROM Pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <a href="man-paci.php" class="active">Pacientes</a>
    <a href="man-doct.php">Doctores</a>
    <a href="man-empl.php">Empleados</a>
    <a href="man-usua.php">Usuarios</a>
    <a href="man-mate.php">Materiales</a>
    <a href="man-prov.php">Proveedores</a>
    <a href="man-trat.php">Tratamientos</a>
  </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Pacientes disponibles</h2>
        <p><?= count($pacientes) ?> pacientes registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Paciente</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="editando" value="<?= $editData ? 1 : 0 ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Cédula</label>
              <input type="text" name="Cedula" value="<?= $editData['Cedula'] ?? '' ?>"<?= $editData ? 'readonly' : '' ?>>
            </div>
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Apellido</label>
              <input type="text" name="Apellido" value="<?= $editData['Apellido'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Fecha Nacimiento</label>
              <input type="date" name="FechaNacimiento" value="<?= $editData['FechaNacimiento'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Sexo</label>
              <input type="text" name="Sexo" value="<?= $editData['Sexo'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Teléfono</label>
              <input type="text" name="Telefono" value="<?= $editData['Telefono'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Correo</label>
              <input type="text" name="Correo" value="<?= $editData['Correo'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Dirección</label>
              <input type="text" name="Direccion" value="<?= $editData['Direccion'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Condición Salud</label>
              <input type="text" name="CondicionSalud" value="<?= $editData['CondicionSalud'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>ID Seguro</label>
              <input type="number" name="IdSeguro" value="<?= $editData['IdSeguro'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Tipo Plan</label>
              <input type="text" name="TipoPlan" value="<?= $editData['TipoPlan'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Estado</label>
              <input type="text" name="Estado" value="<?= $editData['Estado'] ?? '' ?>">
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
          <th>Cédula</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Fecha Nacimiento</th>
          <th>Sexo</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Dirección</th>
          <th>Condición Salud</th>
          <th>ID Seguro</th>
          <th>Tipo Plan</th>
          <th>Fecha Registro</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($pacientes as $fila): ?>
      <tr>
        <td><?= $fila['Cedula'] ?></td>
        <td><?= $fila['Nombre'] ?></td>
        <td><?= $fila['Apellido'] ?></td>
        <td><?= $fila['FechaNacimiento'] ?></td>
        <td><?= $fila['Sexo'] ?></td>
        <td><?= $fila['Telefono'] ?></td>
        <td><?= $fila['Correo'] ?></td>
        <td><?= $fila['Direccion'] ?></td>
        <td><?= $fila['CondicionSalud'] ?></td>
        <td><?= $fila['IdSeguro'] ?></td>
        <td><?= $fila['TipoPlan'] ?></td>
        <td><?= $fila['FechaRegistro'] ?></td>
        <td><?= $fila['Estado'] ?></td>
        <td>
          <a href="?edit=<?= $fila['Cedula'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['Cedula'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['Cedula'] ?> ?')"> Delete </a>
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