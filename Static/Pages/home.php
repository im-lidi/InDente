<?php
include("conexion.php");

/* =========================
   LISTAR CITAS PENDIENTES
========================= */
$stmt = $conn->query("SELECT * FROM Citas WHERE CAST(FechaCita AS DATE) = CAST(GETDATE() AS DATE);");
$cita = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   LISTAR USUARIOS Status
========================= */
$stmt = $conn->query("SELECT * FROM Usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM Usuarios WHERE Status = 'Activo'");
$status = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   LISTAR PACIENTES CONFIRMADOS
========================= */
$stmt = $conn->query("SELECT * FROM pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM pacientes WHERE Estado = 'Activo'");
$estado = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   LISTAR PACIENTES PENDIENTES
========================= */
$stmt = $conn->query("SELECT * FROM pacientes WHERE Estado = 'Pendiente'");
$pendiente = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>InDente - Dashboard</title>
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

    <!-- SIDEBAR -->
  <div class="sidebar">
    <h2>InDente</h2>
    <a href="home.php" class="active">Home</a>
    <a href="man-segu.php">Mantenimientos</a>
    <a href="con-paci.php">Consultas</a>
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
    <h1><!--<a href="index.php">Dashboard </a>> -->Dashboard</h1>
    <span class="fecha"><?php echo date('F d, Y'); ?></span>
  </div>


  <div class="content">

    <!-- TITULO Y BOTONES -->
    <div class="dashboard-top">
      <div>
        <h2>Bienvenid@, <span>Lidiana Salazar</span></h2>
        <p>Esto es lo que esta pasando en tu clinica el dia de hoy.</p>
      </div>
      <div class="dashboard-buttons">
        <a class="btn btn-search" href="con-paci.php">Buscar</a>
        <button class="btn btn-green" onclick="abrirModal('modal-cita')">+ Añadir cita</button>
      </div>
    </div>

    <!-- TARJETAS -->
    <div class="cards">
      <a href="pro-cita.php" class="card">
        <h3>Citas de Hoy</h3>
        <p class="card-number"><?= count($cita) ?></p>
        <span class="card-desc">Por confirmar</span>
      </a>
      <a href="man-usua.php" class="card">
        <h3>Cantidad de usuarios</h3>
        <p class="card-number"><?= count($usuarios) ?></p>
        <span class="card-desc">+<?= count($status) ?> activos</span>
      </a>
      <a href="man-paci.php" class="card">
        <h3>Pacientes Registrados</h3>
        <p class="card-number"><?= count($pacientes) ?></p>
        <span class="card-desc"><?= count($estado) ?> confirmados</span>
      </a>
      <a href="con-paci.php" class="card card-warning">
        <h3>Pacientes Pendientes</h3>
        <p class="card-number"><?= count($pendiente) ?></p>
        <span class="card-desc">Esperando por atención</span>
      </a>
    </div>

    <!-- CALENDARIO Y CITAS DEL DIA 
    <div class="dashboard-grid">
      
        CALENDARIO 
      <div class="calendario-box">
        <div class="calendario-header">
          <button class="btn-nav" onclick="mesAnterior()">&lt;</button>
          <h3 id="mes-año">Marzo 2026</h3>
          <button class="btn-nav" onclick="mesSiguiente()">&gt;</button>
        </div>
        <table class="calendario" id="calendario">
          <thead>
            <tr>
              <th>Dom</th><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sab</th>
            </tr>
          </thead>
          <tbody id="calendario-body">
             JS genera las filas 
          </tbody>
        </table>
      </div> 

       CITAS DEL DIA  
      <div class="citas-hoy"> 
        <h3>Citas de hoy</h3>
        <div class="cita-item" onclick="verCita(1)">
          <span class="cita-hora">09:00</span>
          <div class="cita-info">
            <strong>Manuel Menendez</strong> - Chequeo 
            <small>Carlos Mendez</small>
          </div>
          <span class="badge badge-blue">Pendiente</span>
        </div>
        <div class="cita-item" onclick="verCita(2)">
          <span class="cita-hora">10:30</span>
          <div class="cita-info">
            <strong>Laura Pimentel</strong> - Vacunación
            <small>Maria Garcia</small>
          </div>
          <span class="badge badge-blue">Pendiente</span>
        </div>
        <div class="cita-item" onclick="verCita(3)">
          <span class="cita-hora">11:00</span>
          <div class="cita-info">
            <strong>Ronaldo Pérez</strong> - Operación
            <small>Juan Perez</small>
          </div>
          <span class="badge badge-yellow">En proceso</span>
        </div>
        <div class="cita-item" onclick="verCita(4)">
          <span class="cita-hora">14:00</span>
          <div class="cita-info">
            <strong>Aylin del Monte</strong> - Chequeo
            <small>Ana Torres</small>
          </div>
          <span class="badge badge-green">Completo</span>
        </div>
        <div class="cita-item" onclick="verCita(5)">
          <span class="cita-hora">15:30</span>
          <div class="cita-info">
            <strong>Melisa</strong> - Chequeo
            <small>Sofia Herrera</small>
          </div>
          <span class="badge badge-blue">Pendiente</span>
        </div>
      </div>

    </div>

  </div>
</div> 
-->

<!-- MODAL AGREGAR CITA 
<div class="modal-overlay" id="modal-cita">
  <div class="modal">
    <div class="modal-header">
      <h3>New Appointment</h3>
      <button class="modal-close" onclick="cerrarModal('modal-cita')">&times;</button>
    </div>
    <form>
      <div class="form-row">
        <div class="form-group">
          <label>Pet Name</label>
          <input type="text" placeholder="e.g. Max">
        </div>
        <div class="form-group">
          <label>Owner</label>
          <input type="text" placeholder="e.g. Carlos Mendez">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Date</label>
          <input type="date">
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="time">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Type</label>
          <select>
            <option>Checkup</option>
            <option>Vaccination</option>
            <option>Surgery</option>
            <option>Emergency</option>
            <option>Grooming</option>
          </select>
        </div>
        <div class="form-group">
          <label>Veterinarian</label>
          <input type="text" placeholder="e.g. Dr. Rodriguez">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group" style="flex:1;">
          <label>Notes</label>
          <textarea rows="2" placeholder="Additional notes..."></textarea>
        </div>
      </div>
      <div class="form-buttons">
        <button type="button" class="btn btn-gray" onclick="cerrarModal('modal-cita')">Cancel</button>
        <button type="submit" class="btn btn-green">Save Appointment</button>
      </div>
    </form>
  </div>
</div>-->

<!-- MODAL VER CITA 
<div class="modal-overlay" id="modal-ver-cita">
  <div class="modal">
    <div class="modal-header">
      <h3>Appointment Details</h3>
      <button class="modal-close" onclick="cerrarModal('modal-ver-cita')">&times;</button>
    </div>
    <div class="cita-detalle">
      <p><strong>Pet:</strong> <span id="det-pet">Max</span></p>
      <p><strong>Owner:</strong> <span id="det-owner">Carlos Mendez</span></p>
      <p><strong>Date:</strong> <span id="det-date">March 3, 2026</span></p>
      <p><strong>Time:</strong> <span id="det-time">09:00 AM</span></p>
      <p><strong>Type:</strong> <span id="det-type">Checkup</span></p>
      <p><strong>Status:</strong> <span id="det-status" class="badge badge-blue">Scheduled</span></p>
      <p><strong>Veterinarian:</strong> <span id="det-vet">Dr. Rodriguez</span></p>
      <p><strong>Notes:</strong> <span id="det-notes">Regular checkup appointment</span></p>
    </div>
    <div class="form-buttons">
      <button class="btn btn-gray" onclick="cerrarModal('modal-ver-cita')">Close</button>
      <button class="btn btn-green" onclick="editarCita()">Edit</button>
      <button class="btn btn-red" onclick="eliminarCita()">Delete</button>
    </div>
  </div>
</div>-->

<script src="Static/JS/app.js"></script>
</body>
</html>
