<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('admin/tickets') ?>" class="nav-link">
      <i class="nav-icon fas fa-tools"></i>
      <p>Todos los Tickets</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-user-shield"></i>
      <p>Gestionar Técnicos</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="<?= base_url('admin/reportes') ?>" class="nav-link">
      <i class="nav-icon fas fa-chart-pie"></i>
      <p>Estadísticas</p>
    </a>
  </li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="container-fluid">
    <h1>Panel de Administración</h1>
    <p>Bienvenido al control total del soporte técnico.</p>
  </div>
<?= $this->endSection() ?>