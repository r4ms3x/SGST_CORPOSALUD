<?= $this->extend('layouts/main_layout') ?>
<style>
    /* Forzar que las flechas siempre sean visibles y funcionales */
    .carousel-control-prev,
    .carousel-control-next {
        opacity: 0.8 !important; /* Que se vean claritas pero constantes */
        z-index: 5;
    }
.carousel-inner {
        padding-left: 40px;
        padding-right: 40px;
    } 
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1 !important; /* Que brillen al pasar el mouse */ 
        background: rgba(0,0,0,0.1); /* Un fondo sutil para saber que son botones */
    }
    /* Asegura que el carrusel no colapse si está vacío */
    .carousel-inner {
        min-height: 150px;
    }

    /* Mantiene las flechas visibles */ 
    .carousel-control-prev, .carousel-control-next {
        z-index: 10;
        opacity: 0.5;
    }
    
    .carousel-control-prev:hover, .carousel-control-next:hover {
        opacity: 1;
    }

</style>
<?php //--------------------------------- MENU DE OPCIONES ------------------------------------?>
<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('admin/tickets') ?>" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>Inicio</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>" class="nav-link">
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
<?php //------------------------------------CONTENIDO DE LA PAGINA----------------------------------  ?>
<?= $this->section('content') ?>
  <div class="container-fluid">
    <h1>Gestión de Tickets</h1>
    <p>Bienvenido al control total del soporte técnico.</p>
  </div>
  <div class="container-fluid">
    

    <h5 class="mt-4 mb-2">En espera</h5>
    <?php // ------------------------------CARRUSEL "EN ESPERA"--------------------------- ?>
<div id="carruselEnEspera" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        
        <div class="carousel-item active">
            <div class="d-flex justify-content-start">
                <div class="card bg-info m-2 ticket-clickable" style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                 data-toggle="modal" 
                 data-target="#modalAsignarTicket">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-ticket-alt"></i> Ticket #001</h5>
                        <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                        <div class="mb-2">
                            <small class="d-block"><i class="fas fa-user fa-fw"></i> Usuario: Juan P.</small>
                            <small class="d-block text-white-50"><i class="fas fa-layer-group fa-fw"></i> Módulo: Inventario</small>
                        </div>
                    </div>
                </div>
                <div class="card bg-warning m-2 ticket-clickable" style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                 data-toggle="modal" 
                 data-target="#modalAsignarTicket">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-ticket-alt"></i> Ticket #001</h5>
                        <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                        <div class="mb-2">
                            <small class="d-block"><i class="fas fa-user fa-fw"></i> Usuario: Juan P.</small>
                            <small class="d-block text-white-50"><i class="fas fa-layer-group fa-fw"></i> Módulo: Inventario</small>
                        </div>
                    </div>
                </div>
                <div class="card bg-info m-2 ticket-clickable" style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                 data-toggle="modal" 
                 data-target="#modalAsignarTicket">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-ticket-alt"></i> Ticket #001</h5>
                        <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                        <div class="mb-2">
                            <small class="d-block"><i class="fas fa-user fa-fw"></i> Usuario: Juan P.</small>
                            <small class="d-block text-white-50"><i class="fas fa-layer-group fa-fw"></i> Módulo: Inventario</small>
                        </div>
                    </div>
                </div>
                <div class="card bg-danger m-2 ticket-clickable" style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                 data-toggle="modal" 
                 data-target="#modalAsignarTicket">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-ticket-alt"></i> Ticket #001</h5>
                        <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                        <div class="mb-2">
                            <small class="d-block"><i class="fas fa-user fa-fw"></i> Usuario: Juan P.</small>
                            <small class="d-block text-white-50"><i class="fas fa-layer-group fa-fw"></i> Módulo: Inventario</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="d-flex justify-content-start">
                <div class="card bg-warning m-2 ticket-clickable" style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                 data-toggle="modal" 
                 data-target="#modalAsignarTicket">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-ticket-alt"></i> Ticket #001</h5>
                        <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                        <div class="mb-2">
                            <small class="d-block"><i class="fas fa-user fa-fw"></i> Usuario: Juan P.</small>
                            <small class="d-block text-white-50"><i class="fas fa-layer-group fa-fw"></i> Módulo: Inventario</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <a class="carousel-control-prev" href="#carruselEnEspera" role="button" data-slide="prev" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#carruselEnEspera" role="button" data-slide="next" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>

    <h5 class="mt-4 mb-2">En Revision</h5>
    <?php // --------------------------CARRUSEL "EN REVISION"------------------------------- ?>
<div id="carruselRevision" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        
        <div class="carousel-item active">
            <div class="d-flex justify-content-start">

                <div class="card bg-gradient-teal m-2 ticket-clickable" 
                     style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                    data-toggle="modal" 
                    data-target="#modalEditarRevision"> <div class="card-body text-dark"> <h5 class="card-title mb-3"><i class="fas fa-sync-alt fa-spin"></i> Ticket #001</h5>
                       <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                   <div class="mt-2">
                      <small class="d-block"><strong>Técnicos:</strong> Carlos R., María L.</small>
                     <small class="d-block"><strong>Tiempo:</strong> 30 min</small>
                 </div>
                                                  </div>
                  </div>

                <div class="card bg-gradient-teal m-2 ticket-clickable" 
                     style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                    data-toggle="modal" 
                    data-target="#modalEditarRevision"> <div class="card-body text-dark"> <h5 class="card-title mb-3"><i class="fas fa-sync-alt fa-spin"></i> Ticket #001</h5>
                       <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                   <div class="mt-2">
                      <small class="d-block"><strong>Técnicos:</strong> Carlos R., María L.</small>
                     <small class="d-block"><strong>Tiempo:</strong> 30 min</small>
                 </div>
                                                  </div>
                  </div>

                <div class="card bg-gradient-teal m-2 ticket-clickable" 
                     style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                    data-toggle="modal" 
                    data-target="#modalEditarRevision"> <div class="card-body text-dark"> <h5 class="card-title mb-3"><i class="fas fa-sync-alt fa-spin"></i> Ticket #001</h5>
                       <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                   <div class="mt-2">
                      <small class="d-block"><strong>Técnicos:</strong> Carlos R., María L.</small>
                     <small class="d-block"><strong>Tiempo:</strong> 30 min</small>
                 </div>
                                                  </div>
                  </div>

                <div class="card bg-gradient-teal m-2 ticket-clickable" 
                     style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                    data-toggle="modal" 
                    data-target="#modalEditarRevision"> <div class="card-body text-dark"> <h5 class="card-title mb-3"><i class="fas fa-sync-alt fa-spin"></i> Ticket #001</h5>
                       <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                   <div class="mt-2">
                      <small class="d-block"><strong>Técnicos:</strong> Carlos R., María L.</small>
                     <small class="d-block"><strong>Tiempo:</strong> 30 min</small>
                 </div>
                                                  </div>
                  </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="d-flex justify-content-start">
                <div class="card bg-gradient-teal m-2 ticket-clickable" 
                     style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                    data-toggle="modal" 
                    data-target="#modalEditarRevision"> <div class="card-body text-dark"> <h5 class="card-title mb-3"><i class="fas fa-sync-alt fa-spin"></i> Ticket #001</h5>
                       <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                   <div class="mt-2">
                      <small class="d-block"><strong>Técnicos:</strong> Carlos R., María L.</small>
                     <small class="d-block"><strong>Tiempo:</strong> 30 min</small>
                 </div>
                                                  </div>
                  </div>
            </div>
        </div>

    </div>

    <a class="carousel-control-prev" href="#carruselRevision" role="button" data-slide="prev" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#carruselRevision" role="button" data-slide="next" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>

    <h5 class="mt-4 mb-2">Completado</h5>
    <?php // --------------------------CARRUSEL "COMPLETADO" -----------------------------?>
<div id="carruselCompletado" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        
        <div class="carousel-item active">
            <div class="d-flex justify-content-start">

                <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>

                <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>

                  <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>

                <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>

                <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="d-flex justify-content-start">
                <div class="card bg-success m-2 ticket-clickable" 
                      style="width: 18rem; flex: 0 0 auto; border-radius: 10px;"
                       data-toggle="modal" 
                      data-target="#modalTicketCompletado">
                      <div class="card-body">
                          <h5 class="card-title mb-3"><i class="fas fa-check-double"></i> Ticket #001</h5>
                          <p class="card-text mb-1"><strong>Falla:</strong> Falla Impresora</p>
                              <div class="mt-2">
                                 <small class="d-block text-white-50">Completado por usuario: 14:30 PM</small>
                              </div>
                      </div>
                  </div>
            </div>
        </div>

    </div>

    <a class="carousel-control-prev" href="#carruselCompletado" role="button" data-slide="prev" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#carruselCompletado" role="button" data-slide="next" style="width: 5%; background: rgba(0,0,0,0.1);">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>
        </div>
</div>
<?php // ------------------------------------------------INICIO MODALES ----------------------------------------------------?>

<?php //------------------------------- MODAL DE EN ESPERA---------------------- ?>
<div class="modal fade" id="modalAsignarTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel text-white">Detalles del Ticket #001</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6"><strong>Falla:</strong> <span id="infoFalla">Falla Impresora</span></div>
                    <div class="col-6"><strong>Módulo:</strong> <span id="infoModulo">Inventario</span></div>
                    <div class="col-6 mt-2"><strong>Usuario:</strong> <span id="infoUsuario">Juan Pérez</span></div>
                </div>

                <hr>

                <form id="formAsignar">
                    <div class="form-group">
    <label><i class="fas fa-user-cog"></i> Asignar Técnicos</label>
    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
        
        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec1" name="tecnicos[]" value="1">
            <label for="tec1" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>Carlos Ruiz</span>
            </label>
        </div>

        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec2" name="tecnicos[]" value="2">
            <label for="tec2" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>María López</span>
            </label>
        </div>

        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec3" name="tecnicos[]" value="3">
            <label for="tec3" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>José García</span>
            </label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec4" name="tecnicos[]" value="4">
            <label for="tec4" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>Fulanito</span>
            </label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec5" name="tecnicos[]" value="5">
            <label for="tec5" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>Tiana Maria</span>
            </label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec6" name="tecnicos[]" value="6">
            <label for="tec6" class="custom-control-label d-flex justify-content-between align-items-center">
                <span> Geovanny Vasquez</span>
            </label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input class="custom-control-input" type="checkbox" id="tec7" name="tecnicos[]" value="7">
            <label for="tec7" class="custom-control-label d-flex justify-content-between align-items-center">
                <span>Pibble</span>
            </label>
        </div>
    </div>
    <small class="text-muted">Puedes seleccionar uno o varios técnicos para este caso.</small>
</div>

                    <div class="form-group">
                        <label for="tiempo"><i class="fas fa-clock"></i> Tiempo estimado de atención</label>
                        <select class="form-control" id="tiempo" name="tiempo">
                            <option>15 minutos</option>
                            <option>30 minutos</option>
                            <option>1 hora</option>
                            <option>2 horas</option>
                            <option>Urgente (Atención inmediata)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Asignar y Mover a Revisión</button>
            </div>
        </div>
    </div>
</div>

<?php //--------------------------- MODAL DE REVISION ----------------------------?>
<div class="modal fade" id="modalEditarRevision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark font-weight-bold">Gestionar Revisión: Ticket #001</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border">
                    <div class="row">
                        <div class="col-6"><strong>Falla:</strong> <p>Falla Impresora</p></div>
                        <div class="col-6"><strong>Módulo:</strong> <p>Inventario</p></div>
                        <div class="col-12"><strong>Usuario:</strong> <p>Juan Pérez</p></div>
                    </div>
                </div>

                <hr>

                <form id="formEditarRevision">
                    <div class="form-group">
                        <label class="text-primary"><i class="fas fa-user-edit"></i> Modificar Técnicos Asignados</label>
                        <div class="border rounded p-3 bg-white" style="max-height: 150px; overflow-y: auto;">
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec1" name="tecnicos[]" checked>
                                <label for="editTec1" class="custom-control-label">Carlos Ruiz</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec2" name="tecnicos[]" checked>
                                <label for="editTec2" class="custom-control-label">María López</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec3" name="tecnicos[]">
                                <label for="editTec3" class="custom-control-label">José García</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec4" name="tecnicos[]">
                                <label for="editTec4" class="custom-control-label">Tiana Maria</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec5" name="tecnicos[]">
                                <label for="editTec5" class="custom-control-label">Geovanny Vasquez</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec6" name="tecnicos[]">
                                <label for="editTec6" class="custom-control-label">Pibble</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="editTec7" name="tecnicos[]">
                                <label for="editTec7" class="custom-control-label">Fulanito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="text-primary"><i class="fas fa-hourglass-half"></i> Actualizar Tiempo Estimado</label>
                        <select class="form-control" name="tiempo">
                            <option>15 minutos</option>
                            <option selected>30 minutos</option> <option>1 hora</option>
                            <option>2 horas</option>
                            <option>Retrasado (Más de 3 horas)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <div>
                    <button type="submit" form="formEditarRevision" class="btn btn-warning text-dark font-weight-bold">Actualizar Datos</button>
                    <button type="button" class="btn btn-success ml-2">Finalizar Ticket</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php // ---------------MODAL DE COMPLETADO ---------------- ?>
<div class="modal fade" id="modalTicketCompletado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Resumen de Finalización: Ticket #001</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row border-bottom pb-3 mb-3">
                    <div class="col-md-4">
                        <label class="text-muted">Información Básica</label>
                        <p><strong>Usuario:</strong> Juan Pérez</p>
                        <p><strong>Módulo:</strong> Inventario</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted">Resolución</label>
                        <p><strong>Técnicos:</strong> Carlos R., María L.</p>
                        <p><strong>Tiempo total:</strong> 45 min</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="badge badge-success p-2">
                            <i class="fas fa-clock"></i> Finalizado: 17/04/2026 14:30
                        </div>
                    </div>
                </div>

                <form id="formComentarioFinal">
                    <div class="form-group">
                        <label for="comentarioAdmin" class="text-success">
                            <i class="fas fa-comment-dots"></i> Añadir Comentario Técnico / Observaciones
                        </label>
                        <textarea class="form-control" id="comentarioAdmin" name="comentario" rows="4" 
                                  placeholder="Escribe aquí los detalles finales del soporte prestado..."></textarea>
                        <small class="form-text text-danger font-italic">
                            * Al subir este comentario, el ticket se archivará permanentemente en el historial.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" form="formComentarioFinal" class="btn btn-success">
                    <i class="fas fa-archive"></i> Subir Comentario y Archivar
                </button>
            </div>
        </div>
    </div>
</div>
<?php // -----------------------ESTILOS CSS---------------------- ?>
<style>
    /* Usamos el nombre de la clase de la tarjeta para mayor fuerza */
    .card.ticket-clickable {
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        position: relative !important;
        display: block !important;
    }

    .card.ticket-clickable:hover {
        /* Aumentamos el tamaño y lo traemos al frente */
        transform: scale(1.08) !important; 
        -webkit-transform: scale(1.08) !important; /* Para navegadores Chrome/Safari antiguos */
        
        box-shadow: 0 12px 24px rgba(0,0,0,0.5) !important;
        z-index: 9999 !important; /* Esto lo pone por encima de todo */
        filter: brightness(1.15) !important;
    }
    .custom-control-input:checked ~ .custom-control-label {
        color: #007bff !important;
        font-weight: bold;
    }

    /* Contenedor con scroll por si hay muchos técnicos */
    .tecnicos-container {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
        background: #fff;
    }
</style>
<?= $this->endSection() ?>