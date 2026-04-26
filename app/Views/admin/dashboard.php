<?= $this->extend('layouts/main_layout') ?>

<style>
    .carousel-control-prev,
    .carousel-control-next {
        opacity: 0.8 !important;
        z-index: 5;
        width: 5%;
        background: rgba(0,0,0,0.1);
    }
    .carousel-inner {
        padding-left: 60px;
        padding-right: 60px;
    } 
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1 !important;
        background: rgba(0,0,0,0.2);
    }
    .carousel-inner {
        min-height: 400px;
    }
    .carousel-item {
        text-align: center;
    }
    .carousel-item .d-flex {
        justify-content: center !important;
        flex-wrap: wrap;
    }
    .card.ticket-clickable {
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        position: relative !important;
        display: block !important;
        width: 280px !important;
        min-width: 260px;
        max-width: 280px;
        margin: 10px !important;
        flex: 0 0 auto;
    }
    .card.ticket-clickable:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 12px 24px rgba(0,0,0,0.5) !important;
        z-index: 9999 !important;
        filter: brightness(1.15) !important;
    }
    .custom-control-input:checked ~ .custom-control-label {
        color: #007bff !important;
        font-weight: bold;
    }
    .bg-gradient-teal {
        background: linear-gradient(135deg, #20c997 0%, #0dcaf0 100%);
        color: white;
    }
    .info-row {
        font-size: 12px;
        margin-bottom: 6px;
        text-align: left;
        padding: 3px 0;
    }
    .ticket-title {
        font-size: 16px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid rgba(255,255,255,0.3);
        text-align: center;
    }
    .badge-tiempo {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .card-body {
        padding: 15px;
    }
    .separator {
        border-top: 1px solid rgba(255,255,255,0.2);
        margin: 8px 0;
    }
    .card .info-row i {
        width: 20px;
    }
    /* Responsive */
    @media (max-width: 1200px) {
        .card.ticket-clickable {
            width: 260px !important;
        }
    }
    @media (max-width: 992px) {
        .card.ticket-clickable {
            width: 240px !important;
        }
    }
    @media (max-width: 768px) {
        .card.ticket-clickable {
            width: 220px !important;
        }
    }
</style>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('admin/gestion_tec') ?>" class="nav-link ">
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
    <a href="<?= base_url('admin/historial') ?>" class="nav-link">
        <i class="nav-icon fas fa-history"></i>
        <p>Historial</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('admin/agenda') ?>" class="nav-link">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Agenda</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('admin/auditoria') ?>" class="nav-link">
        <i class="nav-icon fas fa-fingerprint"></i>
        <p>Auditoria</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('admin/documentacion') ?>" class="nav-link">
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
    <div class="row">
        <div class="col-12">
            <h1>Gestión de Tickets</h1>
            <p>Bienvenido <strong><?= session()->get('user_nombre') ?> <?= session()->get('user_apellido') ?></strong> al control total del soporte técnico.</p>
        </div>
    </div>

    <!-- TICKETS EN ESPERA -->
    <h5 class="mt-4 mb-3">
        <i class="fas fa-clock"></i> En espera 
        <span class="badge badge-warning badge-lg"><?= count($ticketsEspera) ?></span>
    </h5>
    <div id="carruselEnEspera" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            <?php if (empty($ticketsEspera)): ?>
                <div class="carousel-item active">
                    <div class="alert alert-info text-center m-3">No hay tickets en espera</div>
                </div>
            <?php else: ?>
                <?php 
                // Mostrar 4 tarjetas por slide (máximo)
                $chunks = array_chunk($ticketsEspera, 4);
                foreach ($chunks as $index => $chunk): 
                ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="d-flex justify-content-center flex-wrap">
                        <?php foreach ($chunk as $ticket): ?>
                            <div class="card bg-info ticket-clickable" 
                                 data-ticket-id="<?= $ticket['id'] ?>"
                                 data-ticket-usuario-nombre="<?= $ticket['usuario_nombre'] ?? '' ?>"
                                 data-ticket-usuario-apellido="<?= $ticket['usuario_apellido'] ?? '' ?>"
                                 data-ticket-usuario-ci="<?= $ticket['usuario_ci'] ?? '' ?>"
                                 data-ticket-modulo="<?= $ticket['modulo_nombre'] ?? 'N/A' ?>"
                                 data-ticket-problema-titulo="<?= $ticket['problematica_titulo'] ?? '' ?>"
                                 data-ticket-problema-clasificacion="<?= $ticket['clasificacion'] ?? '' ?>"
                                 data-toggle="modal" 
                                 data-target="#modalAsignarTicket">
                                <div class="card-body">
                                    <div class="ticket-title">
                                        <i class="fas fa-ticket-alt"></i> 
                                        <strong>#<?= str_pad($ticket['id'], 4, '0', STR_PAD_LEFT) ?></strong>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-user fa-fw"></i> 
                                        <?= $ticket['usuario_nombre'] ?? 'ID: '.$ticket['id_usuario'] ?> <?= $ticket['usuario_apellido'] ?? '' ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-id-card fa-fw"></i> 
                                        CI: <?= $ticket['usuario_ci'] ?? 'N/A' ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-layer-group fa-fw"></i> 
                                        <?= $ticket['modulo_nombre'] ?? 'N/A' ?>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="info-row">
                                        <i class="fas fa-exclamation-triangle fa-fw"></i> 
                                        <?= $ticket['problematica_titulo'] ?? 'ID: '.$ticket['id_problematica'] ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-tag fa-fw"></i> 
                                        <?= $ticket['clasificacion'] ?? 'N/A' ?>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="info-row text-center">
                                        <small>
                                            <i class="fas fa-calendar fa-fw"></i> 
                                            <?= date('d/m/Y H:i', strtotime($ticket['creacion_del_ticket'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (count($ticketsEspera) > 4): ?>
        <a class="carousel-control-prev" href="#carruselEnEspera" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselEnEspera" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
        <?php endif; ?>
    </div>

    <!-- TICKETS EN REVISIÓN -->
    <h5 class="mt-4 mb-3">
        <i class="fas fa-sync-alt"></i> En Revisión 
        <span class="badge badge-primary badge-lg"><?= count($ticketsRevision) ?></span>
    </h5>
    <div id="carruselRevision" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            <?php if (empty($ticketsRevision)): ?>
                <div class="carousel-item active">
                    <div class="alert alert-info text-center m-3">No hay tickets en revisión</div>
                </div>
            <?php else: ?>
                <?php 
                $chunks = array_chunk($ticketsRevision, 4);
                foreach ($chunks as $index => $chunk): 
                ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="d-flex justify-content-center flex-wrap">
                        <?php foreach ($chunk as $ticket): ?>
                            <div class="card bg-gradient-teal ticket-clickable" 
                                 data-ticket-id="<?= $ticket['id'] ?>"
                                 data-ticket-tecnico-nombre="<?= $ticket['tecnico_nombre'] ?? '' ?>"
                                 data-ticket-tecnico-apellido="<?= $ticket['tecnico_apellido'] ?? '' ?>"
                                 data-toggle="modal" 
                                 data-target="#modalEditarRevision">
                                <div class="card-body">
                                    <div class="ticket-title">
                                        <i class="fas fa-sync-alt fa-spin"></i> 
                                        <strong>#<?= str_pad($ticket['id'], 4, '0', STR_PAD_LEFT) ?></strong>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-user fa-fw"></i> 
                                        <?= $ticket['usuario_nombre'] ?? 'ID: '.$ticket['id_usuario'] ?> <?= $ticket['usuario_apellido'] ?? '' ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-id-card fa-fw"></i> 
                                        CI: <?= $ticket['usuario_ci'] ?? 'N/A' ?>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="info-row">
                                        <i class="fas fa-exclamation-triangle fa-fw"></i> 
                                        <?= $ticket['problematica_titulo'] ?? 'ID: '.$ticket['id_problematica'] ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-tag fa-fw"></i> 
                                        <?= $ticket['clasificacion'] ?? 'N/A' ?>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="info-row">
                                        <i class="fas fa-user-cog fa-fw"></i> 
                                        <?= $ticket['tecnico_nombre'] ?? 'No asignado' ?> <?= $ticket['tecnico_apellido'] ?? '' ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-hourglass-half fa-fw"></i> 
                                        <?= date('d/m/Y H:i', strtotime($ticket['estado_en_proceso'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (count($ticketsRevision) > 4): ?>
        <a class="carousel-control-prev" href="#carruselRevision" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselRevision" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
        <?php endif; ?>
    </div>

    <!-- TICKETS COMPLETADOS -->
    <h5 class="mt-4 mb-3">
        <i class="fas fa-check-double"></i> Por Comentar
        <span class="badge badge-success badge-lg"><?= count($ticketsCompletados) ?></span>
    </h5>
    <div id="carruselCompletado" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            <?php if (empty($ticketsCompletados)): ?>
                <div class="carousel-item active">
                    <div class="alert alert-info text-center m-3">No hay tickets completados</div>
                </div>
            <?php else: ?>
                <?php 
                $chunks = array_chunk($ticketsCompletados, 4);
                foreach ($chunks as $index => $chunk): 
                ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="d-flex justify-content-center flex-wrap">
                        <?php foreach ($chunk as $ticket): ?>
                            <div class="card bg-success ticket-clickable" 
                                 data-ticket-id="<?= $ticket['id'] ?>"
                                 data-ticket-usuario-nombre="<?= $ticket['usuario_nombre'] ?? '' ?>"
                                 data-ticket-usuario-apellido="<?= $ticket['usuario_apellido'] ?? '' ?>"
                                 data-ticket-tecnico-nombre="<?= $ticket['tecnico_nombre'] ?? '' ?>"
                                 data-ticket-tecnico-apellido="<?= $ticket['tecnico_apellido'] ?? '' ?>"
                                 data-toggle="modal" 
                                 data-target="#modalTicketCompletado">
                                <div class="card-body">
                                    <div class="ticket-title">
                                        <i class="fas fa-check-double"></i> 
                                        <strong>#<?= str_pad($ticket['id'], 4, '0', STR_PAD_LEFT) ?></strong>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-user fa-fw"></i> 
                                        <?= $ticket['usuario_nombre'] ?? 'ID: '.$ticket['id_usuario'] ?> <?= $ticket['usuario_apellido'] ?? '' ?>
                                    </div>
                                    <div class="info-row">
                                        <i class="fas fa-exclamation-triangle fa-fw"></i> 
                                        <?= $ticket['problematica_titulo'] ?? 'ID: '.$ticket['id_problematica'] ?>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="info-row">
                                        <i class="fas fa-user-cog fa-fw"></i> 
                                        <?= $ticket['tecnico_nombre'] ?? 'N/A' ?> <?= $ticket['tecnico_apellido'] ?? '' ?>
                                    </div>
                                    <div class="info-row text-center">
                                        <small>
                                            <i class="fas fa-calendar-check"></i> 
                                            <?= date('d/m/Y H:i', strtotime($ticket['estado_completado'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (count($ticketsCompletados) > 4): ?>
        <a class="carousel-control-prev" href="#carruselCompletado" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselCompletado" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL ASIGNAR TICKET (EN ESPERA) -->
<div class="modal fade" id="modalAsignarTicket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">Asignar Ticket</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Ticket ID:</strong> <span id="modalTicketId">-</span><br>
                    <strong>Usuario:</strong> <span id="modalUsuarioNombre">-</span><br>
                    <strong>Cédula:</strong> <span id="modalUsuarioCi">-</span><br>
                    <strong>Módulo:</strong> <span id="modalModulo">-</span><br>
                    <strong>Problema:</strong> <span id="modalProblematicaTitulo">-</span><br>
                    <strong>Clasificación:</strong> <span id="modalProblematicaClasificacion">-</span>
                </div>
                <hr>
                <form id="formAsignarTicket">
                    <input type="hidden" name="ticket_id" id="formTicketId">
                    <div class="form-group">
                        <label><i class="fas fa-user-cog"></i> Asignar Técnico</label>
                        <select class="form-control" name="tecnico_id" id="tecnicoSelect" required>
                            <option value="">Seleccione un técnico...</option>
                            <?php foreach ($tecnicos as $tecnico): ?>
                                <option value="<?= $tecnico['id'] ?>">
                                    <?= $tecnico['nombre'] ?> <?= $tecnico['apellido'] ?> (CI: <?= $tecnico['ci'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Tiempo estimado de atención</label>
                        <select class="form-control" name="tiempo" id="tiempoEstimado">
                            <option value="15">15 minutos</option>
                            <option value="30" selected>30 minutos</option>
                            <option value="60">1 hora</option>
                            <option value="120">2 horas</option>
                            <option value="urgente">Urgente (Atención inmediata)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAsignarTicket">Asignar y Mover a Revisión</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR REVISIÓN -->
<div class="modal fade" id="modalEditarRevision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark">Gestionar Revisión</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border">
                    <strong>Ticket ID:</strong> <span id="editTicketId">-</span><br>
                    <strong>Técnico actual:</strong> <span id="editTecnicoActual">-</span>
                </div>
                <hr>
                <form id="formEditarRevision">
                    <input type="hidden" name="ticket_id" id="editFormTicketId">
                    <div class="form-group">
                        <label><i class="fas fa-user-edit"></i> Reasignar Técnico</label>
                        <select class="form-control" name="tecnico_id" id="editTecnicoSelect">
                            <option value="">Seleccione un técnico...</option>
                            <?php foreach ($tecnicos as $tecnico): ?>
                                <option value="<?= $tecnico['id'] ?>">
                                    <?= $tecnico['nombre'] ?> <?= $tecnico['apellido'] ?> (CI: <?= $tecnico['ci'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnActualizarTicket">Reasignar Técnico</button>
                <button type="button" class="btn btn-success" id="btnFinalizarTicket">Finalizar Ticket</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TICKET COMPLETADO -->
<div class="modal fade" id="modalTicketCompletado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Ticket Completado</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <strong>Ticket ID:</strong> <span id="completadoTicketId">-</span><br>
                    <strong>Usuario:</strong> <span id="completadoUsuario">-</span><br>
                    <strong>Técnico:</strong> <span id="completadoTecnico">-</span>
                </div>
                <form id="formComentarioFinal">
                    <input type="hidden" name="ticket_id" id="completadoFormTicketId">
                    <div class="form-group">
                        <label><i class="fas fa-comment-dots"></i> Solución / Observaciones</label>
                        <textarea class="form-control" name="comentario" rows="4" 
                                  placeholder="Describe la solución aplicada..."></textarea>
                        <small class="form-text text-muted">
                            Este comentario quedará registrado en el historial.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnArchivarTicket">
                    <i class="fas fa-archive"></i> Guardar y Archivar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // ========== TICKET EN ESPERA - Cargar datos en el modal ==========
    $('.card[data-target="#modalAsignarTicket"]').on('click', function() {
        let ticketId = $(this).data('ticket-id');
        let usuarioNombre = $(this).data('ticket-usuario-nombre') || '';
        let usuarioApellido = $(this).data('ticket-usuario-apellido') || '';
        let usuarioCi = $(this).data('ticket-usuario-ci') || 'N/A';
        let modulo = $(this).data('ticket-modulo') || 'N/A';
        let problemaTitulo = $(this).data('ticket-problema-titulo') || 'N/A';
        let problemaClasificacion = $(this).data('ticket-problema-clasificacion') || 'N/A';
        
        $('#modalTicketId').text(ticketId);
        $('#modalUsuarioNombre').text(usuarioNombre + ' ' + usuarioApellido);
        $('#modalUsuarioCi').text(usuarioCi);
        $('#modalModulo').text(modulo);
        $('#modalProblematicaTitulo').text(problemaTitulo);
        $('#modalProblematicaClasificacion').text(problemaClasificacion);
        $('#formTicketId').val(ticketId);
    });

    // ========== TICKET EN REVISIÓN - Cargar datos ==========
    $('.card[data-target="#modalEditarRevision"]').on('click', function() {
        let ticketId = $(this).data('ticket-id');
        let tecnicoNombre = $(this).data('ticket-tecnico-nombre') || 'No asignado';
        let tecnicoApellido = $(this).data('ticket-tecnico-apellido') || '';
        
        $('#editTicketId').text(ticketId);
        $('#editTecnicoActual').text(tecnicoNombre + ' ' + tecnicoApellido);
        $('#editFormTicketId').val(ticketId);
    });

    // ========== TICKET COMPLETADO - Cargar datos ==========
    $('.card[data-target="#modalTicketCompletado"]').on('click', function() {
        let ticketId = $(this).data('ticket-id');
        let usuario = $(this).data('ticket-usuario-nombre') || 'N/A';
        let tecnico = $(this).data('ticket-tecnico-nombre') || 'N/A';
        
        $('#completadoTicketId').text(ticketId);
        $('#completadoUsuario').text(usuario);
        $('#completadoTecnico').text(tecnico);
        $('#completadoFormTicketId').val(ticketId);
    });

    // ========== ASIGNAR TICKET ==========
    $('#btnAsignarTicket').on('click', function() {
        let formData = $('#formAsignarTicket').serialize();
        
        $.ajax({
            url: '<?= base_url("admin/api/tickets/asignar") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Asignado!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar la solicitud', 'error');
            }
        });
    });

    // ========== ACTUALIZAR TICKET (REASIGNAR) ==========
    $('#btnActualizarTicket').on('click', function() {
        let formData = $('#formEditarRevision').serialize();
        
        $.ajax({
            url: '<?= base_url("admin/api/tickets/actualizar") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar la solicitud', 'error');
            }
        });
    });

    // ========== FINALIZAR TICKET ==========
    $('#btnFinalizarTicket').on('click', function() {
        Swal.fire({
            title: '¿Finalizar este ticket?',
            text: "El ticket pasará a completado",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, finalizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let ticketId = $('#editFormTicketId').val();
                
                $.ajax({
                    url: '<?= base_url("admin/api/tickets/finalizar") ?>',
                    type: 'POST',
                    data: { ticket_id: ticketId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Finalizado!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al procesar la solicitud', 'error');
                    }
                });
            }
        });
    });

    // ========== ARCHIVAR TICKET ==========
    $('#btnArchivarTicket').on('click', function() {
        let formData = $('#formComentarioFinal').serialize();
        
        Swal.fire({
            title: '¿Archivar este ticket?',
            text: "Se guardará en el historial",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, archivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/api/tickets/archivar") ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Archivado!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al procesar la solicitud', 'error');
                    }
                });
            }
        });
    });
});

// SweetAlert
if (typeof Swal === 'undefined') {
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);
}
</script>

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<?= $this->endSection() ?>