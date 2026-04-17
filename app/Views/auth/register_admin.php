<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Administrador</title>
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Soporte</b>Admin</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Registrar nuevo Administrador</p>

      <form action="<?= base_url('auth/save_admin') ?>" method="post">
        <input type="hidden" name="role" value="admin">

        <div class="input-group mb-3">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="number" name="cedula" class="form-control" placeholder="Cédula" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-id-card"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Registrar Administrador</button>
          </div>
        </div>
      </form>
      </form> <div class="text-center mt-3">
        <p class="mb-0">
          ¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-center">Inicia sesión aquí</a>
        </p>
      </div>
    </div> 
    </div>
  </div>
</div>
</body>
</html>