<?php
include("conexion.php");

/* =========================
   INSERTAR / ACTUALIZAR
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $idUsuario       = $_POST["IdUsuario"] ?? "";
  $nombre          = $_POST["Nombre"] ?? "";
  $correo          = $_POST["Correo"] ?? "";
  $contrasena      = $_POST["Contrasena"] ?? "";
  $roles           = $_POST["Roles"] ?? "";
  $fechaNacimiento = $_POST["FechaNacimiento"] ?? "";
  $direccion       = $_POST["Direccion"] ?? "";
  $telefono        = $_POST["Telefono"] ?? "";
  $status          = $_POST["Status"] ?? "";

  if ($idUsuario == "") {

      $stmt = $conn->prepare("INSERT INTO Usuarios
      (Nombre,Correo,Contrasena,Roles,FechaCreacion,FechaNacimiento,Direccion,Telefono,Status)
      VALUES (?,?,?,?,GETDATE(),?,?,?,?)");

      $stmt->execute([
        $nombre,$correo,$contrasena,$roles,
        $fechaNacimiento,$direccion,$telefono,$status
      ]);

  } else {

      $stmt = $conn->prepare("UPDATE Usuarios SET
      Nombre=?,Correo=?,Contrasena=?,Roles=?,FechaNacimiento=?,Direccion=?,Telefono=?,Status=?
      WHERE IdUsuario=?");

      $stmt->execute([
        $nombre,$correo,$contrasena,$roles,
        $fechaNacimiento,$direccion,$telefono,$status,$idUsuario
      ]);
  }

  header("Location: man-usua.php");
  exit();
}


/* =========================
   ELIMINAR
========================= */

if (isset($_GET["delete"])) {

  $stmt = $conn->prepare("DELETE FROM Usuarios WHERE IdUsuario=?");
  $stmt->execute([$_GET["delete"]]);

  header("Location: man-usua.php");
  exit();
}


/* =========================
   EDITAR
========================= */

$editData = null;

if (isset($_GET["edit"])) {

  $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE IdUsuario=?");
  $stmt->execute([$_GET["edit"]]);

  $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}


/* =========================
   LISTAR
========================= */

$stmt = $conn->query("SELECT * FROM Usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="man-usua.php" class="active">Usuarios</a>
    <a href="man-mate.php">Materiales</a>
    <a href="man-prov.php">Proveedores</a>
    <a href="man-trat.php">Tratamientos</a>
  </div>

  <div class="content">

    <div class="dashboard-top">
      <div>
        <h2>Usuarios disponibles</h2>
        <p><?= count($usuarios) ?> usuarios registrados</p>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-green" onclick="abrirModal('modal-form')">+ Añadir</button>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay <?= $editData ? 'show' : '' ?>" id="modal-form">
      <div class="modal">
        <div class="modal-header">
          <h3>Añadir Usuario</h3>
          <button class="modal-close" onclick="cerrarModal('modal-form')">&times;</button>
        </div>

        <form method="POST">
          <input type="hidden" name="IdUsuario" value="<?= $editData['IdUsuario'] ?? '' ?>">

          <div class="form-row">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="Nombre" value="<?= $editData['Nombre'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Correo</label>
              <input type="text" name="Correo" value="<?= $editData['Correo'] ?? '' ?>">
            </div>
            <div class="form-group">
              <label>Rol</label>
              <input type="text" name="Roles" value="<?= $editData['Roles'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Teléfono</label>
              <input type="text" name="Telefono" value="<?= $editData['Telefono'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Dirección</label>
              <input type="text" name="Direccion" value="<?= $editData['Direccion'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Fecha Nacimiento</label>
              <input type="date" name="FechaNacimiento" value="<?= $editData['FechaNacimiento'] ?? '' ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Status</label>
              <input type="text" name="Status" value="<?= $editData['Status'] ?? '' ?>">
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
          <th>ID Usuario</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>Fecha Nacimiento</th>
          <th>Status</th>
          <th>Acciones</th>
        </tr>
      </thead>
    <tbody>

<?php foreach($usuarios as $fila): ?>
      <tr>
        <td><?= $fila['IdUsuario'] ?></td>
        <td><?= $fila['Nombre'] ?></td>
        <td><?= $fila['Correo'] ?></td>
        <td><?= $fila['Roles'] ?></td>
        <td><?= $fila['Telefono'] ?></td>
        <td><?= $fila['Direccion'] ?></td>
        <td><?= $fila['FechaNacimiento'] ?></td>
        <td><?= $fila['Status'] ?></td>
        <td>
          <a href="?edit=<?= $fila['IdUsuario'] ?>" class="btn btn-small btn-green" >Edit</a>
          <a href="?delete=<?= $fila['IdUsuario'] ?>" class="btn btn-small btn-red" onclick="return confirm('¿Deseas eliminar el registro correspondiente al siguiente id = <?= $fila['IdUsuario'] ?> ?')"> Delete </a>
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