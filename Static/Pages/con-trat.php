<?php
include("conexion.php");

/* =========================
   LISTAR SEGUROS
========================= */
$stmt = $conn->query("SELECT * FROM seguros");
$seguros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>InDente - Consultas</title>
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h2>InDente</h2>
    <a href="home.php">Home</a>
    <a href="man-segu.php">Mantenimientos</a>
    <a href="con-paci.php" class="active">Consultas</a>
    <a href="pro-cons.php">Procesos</a>
    <a href="settings.php">Configuración</a>

          <!-- AVATAR ABAJO -->
  <div class="sidebar-avatar">
    <div class="avatar">LS</div>
    <div class="avatar-info">
      <span class="avatar-name">Lidiana Salazar</span>
      <span class="avatar-role">Admin</span>
    </div>
  </div>
  </div>
  

  <!-- CONTENIDO -->
  <div class="main">

 <!-- HEADER -->
  <div class="header">
    <h1><a href="home.php">Dashboard </a>> Consultas</h1>
    <span class="fecha"><?php echo date('F d, Y'); ?></span>
  </div>

    <!-- MENU INTERNO -->
    <div class="tabs">
      <a href="con-paci.php">Pacientes</a>
      <a href="con-trat.php" class="active">Tratamientos</a>
      <a href="con-diag.php">Diagnosticos</a>
      <a href="con-mate.php">Materiales</a>
      <a href="con-cita.php">Citas</a>
      <a href="con-doct.php">Doctores</a>
      <a href="con-hist.php">Historiales</a>
      <a href="con-coti.php">Cotizaciones</a>
    </div>

    <div class="content">

            <!-- TITULO Y BOTONES  -->
    <div class="dashboard-top">
      <div>
        <h2>Tratamientos disponibles</h2>
        <p><?= count($seguros) ?> tratamientos registrados</p>
   
      </div>
      <div class="toolbar">
        <input type="text" id="buscar" placeholder="Search..." onkeyup="buscar()">
      </div>
    </div>

      
      <!-- TABLA OWNERS -->
      <table class="tabla">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Pets</th>
          </tr>
        </thead>
        <tbody>

        <?php foreach($seguros as $fila): ?>

        <tr>
          <td><?= $fila['IdSeguro'] ?></td>
          <td><?= $fila['Nombre'] ?></td>
          <td><?= $fila['TipoPlan'] ?></td>
          <td><?= $fila['CoberturaPorcentaje'] ?>%</td>
          <td><?= $fila['Telefono'] ?></td>
        </tr>

        <?php endforeach; ?>

        </tbody>
      </table>      

    </div>
  </div>

  <script src="../JS/app.js"></script>
</body>
</html>
