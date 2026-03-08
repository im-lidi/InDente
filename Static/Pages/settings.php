<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>VetCRM - Settings</title>
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

    <!-- SIDEBAR -->
  <div class="sidebar">
    <h2>InDente</h2>
  <a href="home.php">Home</a>
  <a href="man-segu.php">Mantenimientos</a>
  <a href="con-paci.php">Consultas</a>
  <a href="pro-cons.php">Procesos</a>
  <a href="settings.php" class="active">Configuración</a>

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

 <!-- HEADER 
  <div class="header">
    <h1><a href="../../index.php">Dashboard</a></h1>
    <span class="fecha"><?php echo date('F d, Y'); ?></span>
  </div> -->

    <div class="header">
      <h1>Configuración</h1>
  </div>

  <div class="content">

<!-- PERFIL -->
    <div class="settings-section">
      <h3>Profile</h3>
      <div class="settings-card">
        <div class="profile-header">
          <div class="avatar avatar-large">JD</div>
          <div class="profile-info">
            <h4>John Doe</h4>
            <p>Administrator</p>
          </div>
        </div>
        <form class="settings-form">
          <div class="form-row">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" value="John">
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" value="Doe">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Email</label>
              <input type="email" value="john.doe@vetcrm.com">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="tel" value="555-0100">
            </div>
          </div>
          <div class="form-buttons">
            <button type="submit" class="btn btn-green">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <!-- CAMBIAR PASSWORD -->
    <div class="settings-section">
      <h3>Change Password</h3>
      <div class="settings-card">
        <form class="settings-form">
          <div class="form-row">
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" placeholder="Enter current password">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>New Password</label>
              <input type="password" placeholder="Enter new password">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" placeholder="Confirm new password">
            </div>
          </div>
          <div class="form-buttons">
            <button type="submit" class="btn btn-green">Update Password</button>
          </div>
        </form>
      </div>
    </div>

    <!-- CONFIGURACION CLINICA -->
    <div class="settings-section" >
      <h3>Clinic Information</h3>
      <div class="settings-card">
        <form class="settings-form">
          <div class="form-row">
            <div class="form-group">
              <label>Clinic Name</label>
              <input type="text" value="VetCRM Clinic">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="tel" value="555-1234">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Address</label>
              <input type="text" value="123 Main Street, City">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" value="contact@vetcrm.com">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Working Hours</label>
              <input type="text" value="Mon-Fri 8:00 AM - 6:00 PM">
            </div>
          </div>
          <div class="form-buttons">
            <button type="submit" class="btn btn-green">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <!-- NOTIFICACIONES -->
    <div class="settings-section" >
      <h3>Notifications</h3>
      <div class="settings-card">
        <div class="settings-option">
          <div>
            <strong>Email Notifications</strong>
            <p>Receive email alerts for new appointments</p>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>
        <div class="settings-option">
          <div>
            <strong>SMS Notifications</strong>
            <p>Receive SMS reminders for appointments</p>
          </div>
          <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
          </label>
        </div>
        <div class="settings-option">
          <div>
            <strong>Daily Summary</strong>
            <p>Receive daily summary of activities</p>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="../JS/app.js"></script>
</body>
</html>
