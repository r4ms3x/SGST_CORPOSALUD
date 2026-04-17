<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('usuario/crear_ticket') ?>" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>Reportar Falla</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="<?= base_url('usuario/mis_tickets') ?>" class="nav-link">
      <i class="nav-icon fas fa-clipboard-list"></i>
      <p>Mis Solicitudes</p>
    </a>
  </li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <h1>Hola, ¿En qué podemos ayudarte hoy?</h1>
<?= $this->endSection() ?>