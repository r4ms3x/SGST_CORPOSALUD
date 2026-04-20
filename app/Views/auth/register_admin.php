<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario</title>
  
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>SGST</b> Corposalud</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Registro de Usuario</p>

      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <?php if(isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger">
          <?php foreach($errors as $error): ?>
            <p class="mb-0"><?= $error ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/save_user') ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?= old('nombre') ?>" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" name="apellido" class="form-control" placeholder="Apellido" value="<?= old('apellido') ?>" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <input type="number" name="cedula" class="form-control" placeholder="Cédula" value="<?= old('cedula') ?>" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-id-card"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <select name="modulo_id" class="form-control" required>
            <option value="">Seleccione su módulo</option>
            <?php if(isset($modulos) && !empty($modulos)): ?>
              <?php foreach($modulos as $modulo): ?>
                <option value="<?= $modulo['id'] ?>" <?= old('modulo_id') == $modulo['id'] ? 'selected' : '' ?>>
                  <?= $modulo['nombre'] ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-building"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Contraseña (mínimo 6 caracteres)" minlength="6" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar Contraseña" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
          </div>
        </div>
      </form>

      <div class="text-center mt-3">
        <p class="mb-0">
          ¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-center">Inicia sesión aquí</a>
        </p>
      </div>
    </div> 
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>