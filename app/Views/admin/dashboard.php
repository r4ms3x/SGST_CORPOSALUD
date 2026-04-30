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
    .card.ticket-clickable.bloqueado {
        opacity: 0.6;
        cursor: not-allowed !important;
        pointer-events: none;
    }
    .card.ticket-clickable.bloqueado:hover {
        transform: none !important;
        box-shadow: none !important;
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
    @media (max-width: 1200px) {
        .card.ticket-clickable { width: 260px !important; }
    }
    @media (max-width: 992px) {
        .card.ticket-clickable { width: 240px !important; }
    }
    @media (max-width: 768px) {
        .card.ticket-clickable { width: 220px !important; }
    }
    .ticket-count {
        font-size: 1.2rem;
        padding: 5px 12px;
    }
    .badge-tecnico {
        font-size: 10px;
        margin: 2px;
        display: inline-block;
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
    <a href="<?= base_url('admin/tecnicos') ?>" class="nav-link">
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
        <span class="badge badge-warning ticket-count" id="contadorEspera">0</span>
    </h5>
    <div id="carruselEnEspera" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" id="ticketsEsperaContainer">
            <div class="carousel-item active">
                <div class="alert alert-info text-center m-3">
                    <i class="fas fa-spinner fa-spin"></i> Cargando tickets...
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carruselEnEspera" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselEnEspera" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>

    <!-- TICKETS EN REVISIÓN -->
    <h5 class="mt-4 mb-3">
        <i class="fas fa-sync-alt"></i> En Revisión 
        <span class="badge badge-primary ticket-count" id="contadorRevision">0</span>
    </h5>
    <div id="carruselRevision" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" id="ticketsRevisionContainer">
            <div class="carousel-item active">
                <div class="alert alert-info text-center m-3">
                    <i class="fas fa-spinner fa-spin"></i> Cargando tickets...
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carruselRevision" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselRevision" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>

    <!-- TICKETS COMPLETADOS (POR COMENTAR) -->
    <h5 class="mt-4 mb-3">
        <i class="fas fa-check-double"></i> Por Comentar
        <span class="badge badge-success ticket-count" id="contadorCompletados">0</span>
    </h5>
    <div id="carruselCompletado" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" id="ticketsCompletadosContainer">
            <div class="carousel-item active">
                <div class="alert alert-info text-center m-3">
                    <i class="fas fa-spinner fa-spin"></i> Cargando tickets...
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carruselCompletado" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carruselCompletado" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>
</div>

<!-- MODAL ASIGNAR TICKET (ESPERA) -->
<div class="modal fade" id="modalAsignarTicket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">Gestionar Ticket en Espera</h5>
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
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6 class="card-title">ARCHIVAR TICKET</h6>
                                <textarea  id="comentarioArchivo" class="form-control" rows="3" 
                                          placeholder="Motivo del archivo (obligatorio para archivar)..."></textarea>
                                <button type="button" class="btn btn-danger mt-2" id="btnArchivarTicketEspera">
                                    <i class="fas fa-archive"></i> Archivar Ticket (sin asignar)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAsignarTicket">Asignar y Mover a Revisión</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR REVISIÓN (Múltiples técnicos) -->
<div class="modal fade" id="modalEditarRevision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                    <strong>Usuario:</strong> <span id="editUsuarioNombre">-</span><br>
                    <strong>Cédula:</strong> <span id="editUsuarioCi">-</span><br>
                    <strong>Módulo:</strong> <span id="editModulo">-</span><br>
                    <strong>Problema:</strong> <span id="editProblematicaTitulo">-</span><br>
                    <strong>Clasificación:</strong> <span id="editClasificacion">-</span><br>
                    <strong>Técnicos asignados:</strong> <span id="editTecnicosAsignados">-</span><br>
                    <strong>Administrador que asignó:</strong> <span id="editAdminActual">-</span>
                </div>
                <hr>
                <form id="formEditarRevision">
                    <input type="hidden" name="ticket_id" id="editFormTicketId">
                    <div class="form-group">
                        <label><i class="fas fa-user-plus"></i> Agregar otro Técnico</label>
                        <select class="form-control" name="tecnico_id" id="editTecnicoSelect">
                            <option value="">Seleccione un técnico...</option>
                            <?php foreach ($tecnicos as $tecnico): ?>
                                <option value="<?= $tecnico['id'] ?>">
                                    <?= $tecnico['nombre'] ?> <?= $tecnico['apellido'] ?> (CI: <?= $tecnico['ci'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-info btn-block mb-2" id="btnAgregarTecnico">
                        <i class="fas fa-plus-circle"></i> Agregar Técnico
                    </button>
                    <button type="button" class="btn btn-primary btn-block mb-2" id="btnAsignarAdmin">
                        <i class="fas fa-user-shield"></i> Asignarme a mí como técnico (<?= session()->get('user_nombre') ?>)
                    </button>
                </form>
                <hr>
                <div id="listaTecnicosAsignados" class="mt-2">
                    <strong>Técnicos actuales:</strong>
                    <div id="tecnicosList" class="mt-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TICKET COMPLETADO (POR COMENTAR) -->
<div class="modal fade" id="modalTicketCompletado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Ticket Completado - Agregar Comentario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <strong>Ticket ID:</strong> <span id="completadoTicketId">-</span><br>
                    <strong>Usuario:</strong> <span id="completadoUsuarioNombre">-</span><br>
                    <strong>Cédula:</strong> <span id="completadoUsuarioCi">-</span><br>
                    <strong>Módulo:</strong> <span id="completadoModulo">-</span><br>
                    <strong>Problema:</strong> <span id="completadoProblematica">-</span><br>
                    <strong>Clasificación:</strong> <span id="completadoClasificacion">-</span><br>
                    <strong>Técnicos asignados:</strong> <span id="completadoTecnicos">-</span><br>
                    <strong>Administrador que asignó:</strong> <span id="completadoAdmin">-</span>
                </div>
                <form id="formComentarioFinal">
                    <input type="hidden" name="ticket_id" id="completadoFormTicketId">
                    <div class="form-group">
                        <label><i class="fas fa-comment-dots"></i> Solución / Observaciones</label>
                        <textarea  class="form-control" name="comentario" id="comentarioFinalTextarea" rows="4" 
                                  placeholder="Describe la solución aplicada..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnArchivarTicket">
                    <i class="fas fa-archive"></i> Guardar y Archivar (Mover a Historial)
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let updateInterval = null;
    let currentTicketId = null;
    let currentTipo = null;
    let isUpdating = false;
    
    // ========== FUNCIÓN: Limpiar textareas ==========
    function limpiarTextareas() {
        $('#comentarioArchivo').val('');
        $('#comentarioFinalTextarea').val('');
        $('#editTecnicoSelect').val('');
        $('#tecnicoSelect').val('');
        $('#tiempoEstimado').val('30');
    }
    
    // ========== FUNCIÓN: Recargar técnicos asignados en tiempo real ==========
    function recargarTecnicosAsignados(ticketId) {
        $.ajax({
            url: '<?= base_url("admin/getTecnicosAsignados") ?>',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.tecnicos) {
                    let tecnicosHtml = '';
                    if (response.tecnicos.length > 0) {
                        response.tecnicos.forEach(tec => {
                            tecnicosHtml += `<span class="badge badge-info badge-tecnico"><i class="fas fa-user-cog"></i> ${tec.nombre} ${tec.apellido}</span>`;
                        });
                        let nombresTecnicos = response.tecnicos.map(t => `${t.nombre} ${t.apellido}`).join(', ');
                        $('#editTecnicosAsignados').text(nombresTecnicos);
                    } else {
                        tecnicosHtml = '<span class="text-muted">No hay técnicos asignados</span>';
                        $('#editTecnicosAsignados').text('Ninguno');
                    }
                    $('#tecnicosList').html(tecnicosHtml);
                }
            },
            error: function() {
                console.error('Error al recargar técnicos');
            }
        });
    }
    
    // Función para cargar tickets desde el servidor
    function cargarTickets() {
        if (isUpdating) return;
        isUpdating = true;
        
        $.ajax({
            url: '<?= base_url("admin/getTicketsActualizados") ?>',
            type: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                isUpdating = false;
                
                if (response.success && response.tickets) {
                    $('#contadorEspera').text(response.tickets.espera ? response.tickets.espera.length : 0);
                    $('#contadorRevision').text(response.tickets.revision ? response.tickets.revision.length : 0);
                    $('#contadorCompletados').text(response.tickets.completados ? response.tickets.completados.length : 0);
                    
                    renderizarCarrusel('ticketsEsperaContainer', response.tickets.espera || [], 'espera');
                    renderizarCarrusel('ticketsRevisionContainer', response.tickets.revision || [], 'revision');
                    renderizarCarrusel('ticketsCompletadosContainer', response.tickets.completados || [], 'completados');
                }
            },
            error: function(xhr, status, error) {
                isUpdating = false;
                console.error('Error cargando tickets:', status, error);
            }
        });
    }
    
    function renderizarCarrusel(containerId, tickets, tipo) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        if (!tickets || tickets.length === 0) {
            container.innerHTML = '<div class="carousel-item active"><div class="alert alert-info text-center m-3"> No hay tickets</div></div>';
            return;
        }
        
        const chunks = [];
        for (let i = 0; i < tickets.length; i += 4) {
            chunks.push(tickets.slice(i, i + 4));
        }
        
        let html = '';
        chunks.forEach((chunk, index) => {
            html += `<div class="carousel-item ${index === 0 ? 'active' : ''}">`;
            html += '<div class="d-flex justify-content-center flex-wrap">';
            
            chunk.forEach(ticket => {
                let cardClass = '';
                let iconClass = '';
                let targetModal = '';
                let bloqueadoClass = ticket.bloqueado_por ? 'bloqueado' : '';
                let bloqueadoText = ticket.bloqueado_nombre ? `<div class="alert alert-warning p-1 small text-center"><i class="fas fa-lock"></i> Editando: ${ticket.bloqueado_nombre}</div>` : '';
                
                if (tipo === 'espera') {
                    cardClass = 'bg-info';
                    iconClass = 'fa-ticket-alt';
                    targetModal = 'modalAsignarTicket';
                } else if (tipo === 'revision') {
                    cardClass = 'bg-gradient-teal';
                    iconClass = 'fa-sync-alt fa-spin';
                    targetModal = 'modalEditarRevision';
                } else {
                    cardClass = 'bg-success';
                    iconClass = 'fa-check-double';
                    targetModal = 'modalTicketCompletado';
                }
                
                const ticketData = {
                    id: ticket.id,
                    usuario_nombre: ticket.usuario_nombre || '',
                    usuario_apellido: ticket.usuario_apellido || '',
                    usuario_ci: ticket.usuario_ci || 'N/A',
                    modulo_nombre: ticket.modulo_nombre || 'N/A',
                    problematica_titulo: ticket.problematica_titulo || 'ID: ' + ticket.id_problematica,
                    clasificacion: ticket.clasificacion || 'N/A',
                    tecnico_nombre: ticket.tecnico_nombre || '',
                    tecnico_apellido: ticket.tecnico_apellido || '',
                    tecnicos_asignados: ticket.tecnicos_asignados || 'Ninguno',
                    admin_nombre: ticket.admin_nombre || 'N/A',
                    admin_apellido: ticket.admin_apellido || '',
                    bloqueado_por: ticket.bloqueado_por || null,
                    bloqueado_nombre: ticket.bloqueado_nombre || null,
                    creacion_del_ticket: ticket.creacion_del_ticket
                };
                
                html += `<div class="card ${cardClass} ticket-clickable ${bloqueadoClass}" 
                               data-ticket='${JSON.stringify(ticketData).replace(/'/g, "&#39;")}'
                               data-tipo="${tipo}"
                               data-ticket-id="${ticket.id}"
                               data-target-modal="${targetModal}">`;
                html += '<div class="card-body">';
                html += `<div class="ticket-title"><i class="fas ${iconClass}"></i> <strong>#${String(ticket.id).padStart(4, '0')}</strong></div>`;
                html += bloqueadoText;
                html += `<div class="info-row"><i class="fas fa-user fa-fw"></i> ${ticket.usuario_nombre || 'ID: ' + ticket.id_usuario} ${ticket.usuario_apellido || ''}</div>`;
                
                if (tipo === 'espera') {
                    html += `<div class="info-row"><i class="fas fa-id-card fa-fw"></i> CI: ${ticket.usuario_ci || 'N/A'}</div>`;
                    html += `<div class="info-row"><i class="fas fa-layer-group fa-fw"></i> ${ticket.modulo_nombre || 'N/A'}</div>`;
                    html += `<div class="separator"></div>`;
                    html += `<div class="info-row"><i class="fas fa-exclamation-triangle fa-fw"></i> ${ticket.problematica_titulo || 'ID: ' + ticket.id_problematica}</div>`;
                    html += `<div class="info-row"><i class="fas fa-tag fa-fw"></i> ${ticket.clasificacion || 'N/A'}</div>`;
                } else if (tipo === 'revision') {
                    html += `<div class="separator"></div>`;
                    html += `<div class="info-row"><i class="fas fa-exclamation-triangle fa-fw"></i> ${ticket.problematica_titulo || 'ID: ' + ticket.id_problematica}</div>`;
                    html += `<div class="info-row"><i class="fas fa-tag fa-fw"></i> ${ticket.clasificacion || 'N/A'}</div>`;
                    html += `<div class="separator"></div>`;
                    html += `<div class="info-row"><i class="fas fa-users fa-fw"></i> Técnicos: ${ticket.tecnicos_asignados || 'No asignados'}</div>`;
                    html += `<div class="info-row"><i class="fas fa-user-shield fa-fw"></i> Admin: ${ticket.admin_nombre || 'N/A'} ${ticket.admin_apellido || ''}</div>`;
                } else {
                    html += `<div class="separator"></div>`;
                    html += `<div class="info-row"><i class="fas fa-exclamation-triangle fa-fw"></i> ${ticket.problematica_titulo || 'ID: ' + ticket.id_problematica}</div>`;
                    html += `<div class="separator"></div>`;
                    html += `<div class="info-row"><i class="fas fa-users fa-fw"></i> Técnicos: ${ticket.tecnicos_asignados || 'N/A'}</div>`;
                }
                
                html += `<div class="separator"></div>`;
                html += `<div class="info-row text-center"><small><i class="fas fa-calendar fa-fw"></i> ${new Date(ticket.creacion_del_ticket).toLocaleString()}</small></div>`;
                html += '</div></div>';
            });
            
            html += '</div></div>';
        });
        
        container.innerHTML = html;
    }
    
    // ========== FUNCIÓN: Verificar bloqueo huérfano ==========
    function verificarBloqueoHuerfano(ticketId) {
        let resultado = false;
        $.ajax({
            url: '<?= base_url("admin/verificarBloqueoHuerfano") ?>',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            async: false,
            success: function(response) {
                if (response.huérfano === true) {
                    resultado = true;
                }
            },
            error: function() {
                resultado = false;
            }
        });
        return resultado;
    }
    
    // ========== FUNCIÓN: Limpiar bloqueo huérfano ==========
    function limpiarBloqueoHuerfano(ticketId) {
        $.ajax({
            url: '<?= base_url("admin/limpiarBloqueoHuerfano") ?>',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            async: false
        });
    }
    
    // ========== FUNCIÓN: Verificar si el ticket está bloqueado (consulta al servidor) ==========
    function verificarBloqueo(ticketId) {
        let resultado = { bloqueado: false, bloqueado_por: null };
        $.ajax({
            url: '<?= base_url("admin/verificarBloqueo") ?>',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            async: false,
            success: function(response) {
                if (response.bloqueado === true) {
                    resultado.bloqueado = true;
                    resultado.bloqueado_por = response.bloqueado_por || 'Administrador desconocido';
                }
            },
            error: function() {
                resultado.bloqueado = true;
                resultado.bloqueado_por = 'Error al verificar';
            }
        });
        return resultado;
    }
    
    // ========== FUNCIÓN: Bloquear ticket ==========
    function bloquearTicket(ticketId) {
        let bloqueadoExitoso = true;
        $.ajax({
            url: '<?= base_url("admin/bloquearTicket") ?>',
            type: 'POST',
            data: { ticket_id: ticketId },
            dataType: 'json',
            async: false,
            success: function(response) {
                if (!response.success) {
                    bloqueadoExitoso = false;
                }
            },
            error: function() {
                bloqueadoExitoso = false;
            }
        });
        return bloqueadoExitoso;
    }
    
    // Función para desbloquear ticket
    function desbloquearTicket(ticketId) {
        if (ticketId) {
            $.ajax({
                url: '<?= base_url("admin/desbloquearTicket") ?>',
                type: 'POST',
                data: { ticket_id: ticketId },
                dataType: 'json',
                async: false
            });
        }
    }
    
    // ========== MANEJAR CLIC EN TICKETS ==========
    $(document).on('click', '.ticket-clickable', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $this = $(this);
        const ticketData = $this.data('ticket');
        const tipo = $this.data('tipo');
        const ticketId = $this.data('ticket-id');
        const targetModal = $this.data('target-modal');
        const adminActual = '<?= session()->get("user_nombre") ?> <?= session()->get("user_apellido") ?>';
        
        // Verificar y limpiar bloqueo huérfano
        if (verificarBloqueoHuerfano(ticketId)) {
            limpiarBloqueoHuerfano(ticketId);
        }
        
        // Si la tarjeta tiene la clase 'bloqueado' (CSS visual), verificar si es el mismo admin
        if ($this.hasClass('bloqueado')) {
            // Verificar en el servidor quién lo bloqueó realmente
            const bloqueoInfo = verificarBloqueo(ticketId);
            if (bloqueoInfo.bloqueado && bloqueoInfo.bloqueado_por !== adminActual) {
                Swal.fire('Ticket bloqueado', `Este ticket está siendo editado por: ${bloqueoInfo.bloqueado_por}`, 'warning');
                return false;
            }
        }
        
        if (!ticketData) {
            console.error('No hay datos del ticket');
            return false;
        }
        
        // Verificar en el servidor antes de intentar bloquear
        const bloqueoInfo = verificarBloqueo(ticketId);
        if (bloqueoInfo.bloqueado && bloqueoInfo.bloqueado_por !== adminActual) {
            Swal.fire('Ticket bloqueado', `Este ticket está siendo editado por: ${bloqueoInfo.bloqueado_por}`, 'warning');
            return false;
        }
        
        // Intentar bloquear el ticket
        const bloqueadoOk = bloquearTicket(ticketId);
        if (!bloqueadoOk) {
            Swal.fire('Ticket bloqueado', 'No se pudo bloquear el ticket porque otro administrador ya lo está editando', 'warning');
            return false;
        }
        
        // Guardar referencia
        currentTicketId = ticketId;
        currentTipo = tipo;
        
        // Cargar datos en el modal correspondiente
        if (tipo === 'espera') {
            $('#modalTicketId').text(ticketData.id);
            $('#modalUsuarioNombre').text((ticketData.usuario_nombre || '') + ' ' + (ticketData.usuario_apellido || ''));
            $('#modalUsuarioCi').text(ticketData.usuario_ci || 'N/A');
            $('#modalModulo').text(ticketData.modulo_nombre || 'N/A');
            $('#modalProblematicaTitulo').text(ticketData.problematica_titulo || 'N/A');
            $('#modalProblematicaClasificacion').text(ticketData.clasificacion || 'N/A');
            $('#formTicketId').val(ticketData.id);
            $('#modalAsignarTicket').modal('show');
            
        } else if (tipo === 'revision') {
            $('#editTicketId').text(ticketData.id);
            $('#editUsuarioNombre').text((ticketData.usuario_nombre || '') + ' ' + (ticketData.usuario_apellido || ''));
            $('#editUsuarioCi').text(ticketData.usuario_ci || 'N/A');
            $('#editModulo').text(ticketData.modulo_nombre || 'N/A');
            $('#editProblematicaTitulo').text(ticketData.problematica_titulo || 'N/A');
            $('#editClasificacion').text(ticketData.clasificacion || 'N/A');
            $('#editTecnicosAsignados').text(ticketData.tecnicos_asignados || 'Ninguno');
            $('#editAdminActual').text((ticketData.admin_nombre || 'N/A') + ' ' + (ticketData.admin_apellido || ''));
            $('#editFormTicketId').val(ticketData.id);
            
            // Mostrar lista de técnicos
            if (ticketData.tecnicos_asignados && ticketData.tecnicos_asignados !== 'Ninguno') {
                const tecnicosArray = ticketData.tecnicos_asignados.split(', ');
                let tecnicosHtml = '';
                tecnicosArray.forEach(tec => {
                    tecnicosHtml += `<span class="badge badge-info badge-tecnico"><i class="fas fa-user-cog"></i> ${tec}</span>`;
                });
                $('#tecnicosList').html(tecnicosHtml);
            } else {
                $('#tecnicosList').html('<span class="text-muted">No hay técnicos asignados</span>');
            }
            $('#modalEditarRevision').modal('show');
            
        } else if (tipo === 'completados') {
            $('#completadoTicketId').text(ticketData.id);
            $('#completadoUsuarioNombre').text((ticketData.usuario_nombre || '') + ' ' + (ticketData.usuario_apellido || ''));
            $('#completadoUsuarioCi').text(ticketData.usuario_ci || 'N/A');
            $('#completadoModulo').text(ticketData.modulo_nombre || 'N/A');
            $('#completadoProblematica').text(ticketData.problematica_titulo || 'N/A');
            $('#completadoClasificacion').text(ticketData.clasificacion || 'N/A');
            $('#completadoTecnicos').text(ticketData.tecnicos_asignados || 'Ninguno');
            $('#completadoAdmin').text((ticketData.admin_nombre || 'N/A') + ' ' + (ticketData.admin_apellido || ''));
            $('#completadoFormTicketId').val(ticketData.id);
            $('#modalTicketCompletado').modal('show');
        }
        
        return false;
    });
    
    // ========== DESBLOQUEAR Y LIMPIAR AL CERRAR MODAL ==========
    $('.modal').on('hidden.bs.modal', function() {
        if (currentTicketId) {
            // Desbloquear el ticket EN EL SERVIDOR
            $.ajax({
                url: '<?= base_url("admin/desbloquearTicket") ?>',
                type: 'POST',
                data: { ticket_id: currentTicketId },
                dataType: 'json',
                async: false,
                success: function(response) {
                    console.log('Ticket desbloqueado:', response);
                },
                error: function() {
                    console.error('Error al desbloquear ticket');
                }
            });
            currentTicketId = null;
            currentTipo = null;
            // Recargar tickets para actualizar el estado visual
            cargarTickets();
        }
        limpiarTextareas();
    });
    
    // Archivar ticket desde espera
    $('#btnArchivarTicketEspera').on('click', function() {
        let ticketId = $('#formTicketId').val();
        let comentario = $('#comentarioArchivo').val();
        
        if (!comentario) {
            Swal.fire('Error', 'Debes escribir un motivo para archivar el ticket', 'error');
            return;
        }
        
        Swal.fire({
            title: '¿Archivar este ticket?',
            text: "El ticket se archivará sin asignar técnico",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, archivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/archivarTicketEspera") ?>',
                    type: 'POST',
                    data: { ticket_id: ticketId, comentario: comentario },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Archivado', response.message, 'success');
                            desbloquearTicket(ticketId);
                            cargarTickets();
                            $('#modalAsignarTicket').modal('hide');
                            limpiarTextareas();
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
    
    // Asignar ticket (primer técnico)
    $('#btnAsignarTicket').on('click', function() {
        let formData = $('#formAsignarTicket').serialize();
        
        $.ajax({
            url: '<?= base_url("admin/asignarTicket") ?>',
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
                    });
                    desbloquearTicket($('#formTicketId').val());
                    cargarTickets();
                    $('#modalAsignarTicket').modal('hide');
                    limpiarTextareas();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar la solicitud', 'error');
            }
        });
    });
    
    // Agregar más técnicos (actualiza en tiempo real)
    $('#btnAgregarTecnico').on('click', function() {
        let ticketId = $('#editFormTicketId').val();
        let tecnicoId = $('#editTecnicoSelect').val();
        
        if (!tecnicoId) {
            Swal.fire('Error', 'Debes seleccionar un técnico', 'error');
            return;
        }
        
        $.ajax({
            url: '<?= base_url("admin/asignarTicket") ?>',
            type: 'POST',
            data: { ticket_id: ticketId, tecnico_id: tecnicoId, tiempo: null },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Técnico agregado!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    recargarTecnicosAsignados(ticketId);
                    cargarTickets();
                    $('#editTecnicoSelect').val('');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar la solicitud', 'error');
            }
        });
    });
    
    // Asignar admin actual como técnico
    $('#btnAsignarAdmin').on('click', function() {
        let ticketId = $('#editFormTicketId').val();
        let adminId = <?= session()->get('user_id') ?>;
        
        $.ajax({
            url: '<?= base_url("admin/asignarTicket") ?>',
            type: 'POST',
            data: { ticket_id: ticketId, tecnico_id: adminId, tiempo: null },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Te has asignado!',
                        text: 'Ahora eres técnico de este ticket',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    recargarTecnicosAsignados(ticketId);
                    cargarTickets();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });
    
    // Archivar ticket completado (mover a historial)
    // Archivar ticket completado (mover a historial)
$('#btnArchivarTicket').on('click', function() {
    let comentario = $('#comentarioFinalTextarea').val();
    let ticketId = $('#completadoFormTicketId').val();
    
    // VALIDACIÓN MANUAL
    if (!comentario || comentario.trim() === '') {
        Swal.fire('Error', 'Debes escribir una solución/observación', 'error');
        return; // Detener la ejecución
    }
    
    let formData = $('#formComentarioFinal').serialize();
    
    Swal.fire({
        title: '¿Archivar este ticket?',
        text: "Se moverá al historial",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, archivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/archivarTicket") ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Archivado!',
                            text: 'Ticket movido al historial',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        desbloquearTicket(ticketId);
                        cargarTickets();
                        $('#modalTicketCompletado').modal('hide');
                        limpiarTextareas();
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
    
    // Iniciar actualización automática cada 5 segundos
    cargarTickets();
    updateInterval = setInterval(cargarTickets, 5000);
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<?= $this->endSection() ?>