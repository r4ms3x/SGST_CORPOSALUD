<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>Inicio</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/gestion_tec') ?>" class="nav-link active">
      <i class="nav-icon fas fa-user-cog"></i>
      <p>Gestionar Técnicos</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>Gestionar Usuarios</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/reportes') ?>" class="nav-link">
      <i class="nav-icon fas fa-chart-line"></i>
      <p>Estadísticas</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-history"></i>
      <p>Historial</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-calendar-alt"></i>
      <p>Agenda</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-fingerprint"></i>
      <p>Auditoria</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
      <i class="nav-icon fas fa-book"></i>
      <p>Documentacion</p>
    </a>
  </li>

   <li class="nav-item">
    <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Cerrar Sesión</p>
    </a>
</li>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="container-fluid">
    <h1>Gestión de Técnicos</h1>
    
  </div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header border-transparent">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users-cog mr-2"></i> Gestión de Personal Técnico</h3>

                <div class="card-tools">
                    <button class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modalAgregarTecnico">
                        <i class="fas fa-plus"></i> Agregar Nuevo Técnico
                    </button>
                    
                    <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar cédula...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-valign-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Carlos</td>
                            <td>Ruiz</td>
                            <td>11.222.333</td>
                            <td><span class="badge badge-success">Activo</span></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditarTecnico">
                                         <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#modalCambioRol" 
                                    title="Cambiar Rol">
                                     <i class="fas fa-user-shield"></i> Rol
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#modalEliminarTecnico" 
                                            title="Eliminar de forma permanente">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>María</td>
                            <td>López</td>
                            <td>22.333.444</td>
                            <td><span class="badge badge-success">Activo</span></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditarTecnico">
                                         <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#modalCambioRol" 
                                    title="Cambiar Rol">
                                     <i class="fas fa-user-shield"></i> Rol
                                    </button>     
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#modalEliminarTecnico" 
                                            title="Eliminar de forma permanente">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>                  
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <small class="text-muted">Mostrando todos los técnicos activos en el sistema.</small>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarTecnico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Editar Información del Técnico</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarTecnico">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNombre">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" placeholder="Ej: Carlos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editApellido">Apellido</label>
                                <input type="text" class="form-control" id="editApellido" name="apellido" placeholder="Ej: Ruiz">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCedula">Cédula de Identidad</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="editCedula" name="cedula" placeholder="Ej: 11222333">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editEstado">Estado en el Sistema</label>
                        <select class="form-control custom-select" id="editEstado" name="estado">
                            <option value="1" class="text-success">Activo</option>
                            <option value="0" class="text-danger">Inactivo (Suspendido)</option>
                        </select>
                        <small class="text-muted">Si se marca como Inactivo, el técnico no podrá recibir nuevos tickets.</small>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCambioRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Confirmar Cambio de Rol
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="py-3">
                    <i class="fas fa-user-shield text-warning" style="font-size: 50px;"></i>
                </div>
                
                <p class="lead">¿Estás seguro de que deseas cambiar el rol de este usuario?</p>
                
                <div class="alert alert-secondary">
                    <strong>Usuario:</strong> <span id="nombreUsuarioRol">Carlos Ruiz</span><br>
                    <strong>Rol Actual:</strong> <span class="badge badge-info">Técnico</span>
                </div>

                <p class="text-muted">
                    Esta acción modificará los permisos de acceso al sistema inmediatamente.
                </p>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                
                <button type="button" class="btn btn-warning text-dark font-weight-bold">
                    <i class="fas fa-sync-alt mr-1"></i> Confirmar y Cambiar
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEliminarTecnico" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-trash-alt mr-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-circle fa-4x"></i>
                </div>
                
                <h4 class="font-weight-bold">¿Deseas eliminar a este técnico?</h4>
                <p class="text-muted">
                    Estás a punto de eliminar a <strong><span id="nombreTecnicoEliminar">Carlos Ruiz</span></strong>. 
                    Esta acción no se puede deshacer y ya no se podrá asignar este técnico a los tickets
                </p>

                <div class="alert alert-warning py-2">
                    <small><i class="fas fa-info-circle"></i> Los tickets asociados a este técnico quedarán en el historial pero ya no podrán ser editados por él.</small>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4 mr-2" data-dismiss="modal">No, cancelar</button>
                <button type="button" class="btn btn-danger px-4 shadow">
                    <i class="fas fa-check mr-1"></i> Sí, eliminar permanentemente
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAgregarTecnico" tabindex="-1" role="dialog" aria-labelledby="labelAgregar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-user-plus mr-2"></i> Registrar Nuevo Técnico
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregarTecnico">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevoNombre">Nombre</label>
                                <input type="text" class="form-control" id="nuevoNombre" name="nombre" placeholder="Ej: Carlos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevoApellido">Apellido</label>
                                <input type="text" class="form-control" id="nuevoApellido" name="apellido" placeholder="Ej: Ruiz" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nuevoCedula">Cédula de Identidad</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nuevoCedula" name="cedula" placeholder="Número de cédula sin puntos" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nuevoEstado">Estado Inicial</label>
                        <select class="form-control custom-select" id="nuevoEstado" name="estado">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <small class="text-muted">Por defecto, los nuevos técnicos se crean con estado "Activo".</small>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Registrar Técnico
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Hace que las celdas tengan un poco más de espacio vertical */
    .table td {
        vertical-align: middle !important;
        padding: 12px 8px !important;
    }

    /* Mejora el aspecto de los botones en grupo */
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 4px !important; /* Despegamos un poco los botones para que respiren */
    }

    /* Estilo para el badge de estado */
    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
    }
</style>
<?= $this->endSection() ?>