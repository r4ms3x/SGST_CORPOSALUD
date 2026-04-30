<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= site_url('usuario/dashboard') ?>" class="nav-link">
        <i class="fas fa-tachometer-alt"></i>
        <p>Inicio</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('usuario/historial') ?>" class="nav-link active">
        <i class="fas fa-history"></i>
        <p>Historial</p>
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
<div class="row">
    <div class="col-md-12">
        <div class="card" style="border-top: 4px solid #ffc107;">
            <div class="card-header" style="background-color: #007bff; color: white;">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> 
                    HISTORIAL DE REPORTES
                </h3>
            </div>
            <div class="card-body">
                <!-- Pestañas Activos / Completados -->
                <ul class="nav nav-tabs" id="historialTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab" aria-controls="activos" aria-selected="true" style="color: #007bff; font-weight: bold;">
                            <i class="fas fa-play-circle" style="color: #28a745;"></i> ACTIVOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completados-tab" data-toggle="tab" href="#completados" role="tab" aria-controls="completados" aria-selected="false" style="color: #007bff; font-weight: bold;">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i> COMPLETADOS
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- TAB ACTIVOS -->
                    <div class="tab-pane fade show active" id="activos" role="tabpanel" aria-labelledby="activos-tab">
                        <?php if (!empty($activos) && is_array($activos)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background-color: #007bff; color: white;">
                                        <tr>
                                            <th>Numero de ticket</th>
                                            <th>Categoría</th>
                                            <th>Fecha de creación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($activos as $ticket): ?>
                                            <tr>
                                                <td>#<?= str_pad($ticket['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                                <td>
                                                    <span class="badge badge-warning" style="background-color: #ffc107; color: #212529;">
                                                        <?= ucfirst($ticket['categoria']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($ticket['creacion_del_ticket'])) ?></td>
                                                <td>
                                                    <span class="badge badge-success" style="background-color: #17a2b8;">
                                                        <i class="fas fa-play"></i> En proceso
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info btn-ver-ticket" data-id="<?= $ticket['id'] ?>" data-estado="activo" style="border-radius: 20px;">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                 </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center" style="background-color: #fff3cd; border-left: 5px solid #ffc107;">
                                <i class="fas fa-info-circle" style="color: #ffc107;"></i>
                                <strong>NO HAY REPORTES ACTIVOS</strong>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- TAB COMPLETADOS -->
                    <div class="tab-pane fade" id="completados" role="tabpanel" aria-labelledby="completados-tab">
                        <?php if (!empty($completados) && is_array($completados)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background-color: #28a745; color: white;">
                                        <tr>
                                            <th>Numero de ticket</th>
                                            <th>Categoría</th>
                                            <th>Fecha de creación</th>
                                            <th>Fecha de cierre</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($completados as $ticket): ?>
                                            <tr>
                                                <td>#<?= str_pad($ticket['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        <?= ucfirst($ticket['categoria']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($ticket['creacion_del_ticket'])) ?></td>
                                                <td><?= date('d/m/Y H:i', strtotime($ticket['estado_completado'])) ?></td>
                                                <td>
                                                    <span class="badge badge-success" style="background-color: #28a745;">
                                                        <i class="fas fa-check"></i> Completado
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info btn-ver-ticket" data-id="<?= $ticket['id'] ?>" data-estado="completado" style="border-radius: 20px;">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                 </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                <strong>NO HAY REPORTES COMPLETADOS</strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE DEL TICKET -->
<div class="modal fade" id="modalDetalleTicket" tabindex="-1" role="dialog" aria-labelledby="modalDetalleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="modalDetalleLabel">
                    <i class="fas fa-ticket-alt"></i> DETALLE DEL TICKET
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDetalleBody">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando detalles del ticket...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px; padding: 8px 25px;">
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    let currentTicketId = null;
    let pollingInterval = null;
    
    // Función para abrir el modal con el detalle del ticket
    function abrirDetalleTicket(ticketId) {
        console.log('Abriendo ticket ID:', ticketId);
        currentTicketId = ticketId;
        
        // Limpiar y mostrar loading en el modal
        $('#modalDetalleBody').html(`
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Cargando detalles del ticket...</p>
            </div>
        `);
        
        // Abrir el modal
        $('#modalDetalleTicket').modal('show');
        
        // Cargar datos iniciales
        cargarDetalleTicket(ticketId);
        
        // Iniciar polling para actualizar en tiempo real (solo para tickets activos)
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
        pollingInterval = setInterval(function() {
            if (currentTicketId) {
                cargarDetalleTicket(currentTicketId);
            }
        }, 5000);
    }
    
    // Función para cargar el detalle del ticket
    function cargarDetalleTicket(ticketId) {
        const url = '/usuario/detalleTicket/' + ticketId;
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(data) {
                if (data.success) {
                    actualizarModal(data);
                    
                    // Si el ticket ya está completado, detener el polling
                    if (data.ticket.estado === 'completado') {
                        if (pollingInterval) {
                            clearInterval(pollingInterval);
                            pollingInterval = null;
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error cargando detalle:', error);
            }
        });
    }
    
    // Función para actualizar el modal con los datos del ticket
    function actualizarModal(data) {
        let tiempoTexto = data.ticket.tiempo_estimado;
        if (tiempoTexto === '15') tiempoTexto = '15 minutos';
        else if (tiempoTexto === '30') tiempoTexto = '30 minutos';
        else if (tiempoTexto === '60') tiempoTexto = '1 hora';
        else if (tiempoTexto === '120') tiempoTexto = '2 horas';
        else if (tiempoTexto === 'urgente') tiempoTexto = 'URGENTE - Atención inmediata';
        
        let botonFinalizarHTML = '';
        if (data.ticket.mostrar_boton_finalizar && data.ticket.estado === 'activo') {
            botonFinalizarHTML = `
                <div class="col-md-12 text-center mt-3">
                    <button type="button" class="btn btn-lg btn-success" id="btnFinalizarTicketHistorial" style="border-radius: 50px; padding: 12px 40px; font-size: 1.2rem;">
                        <i class="fas fa-check-circle"></i> FINALIZAR TICKET
                    </button>
                </div>
            `;
        }
        
        let estadoBadge = data.ticket.estado === 'activo' ? 
            '<span class="badge" style="background-color: #17a2b8; color: white; padding: 5px 10px;">EN PROCESO</span>' : 
            '<span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px;">COMPLETADO</span>';
        
        $('#modalDetalleBody').html(`
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">NUMERO DE TICKET</span>
                            <span class="info-box-number">#${String(data.ticket.id).padStart(4, '0')}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">ESTADO</span>
                            <span class="info-box-number">${estadoBadge}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">CATEGORÍA</span>
                            <span class="info-box-number">${data.ticket.categoria}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">TIEMPO ESTIMADO</span>
                            <span class="info-box-number">${tiempoTexto}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">FECHA DE CREACIÓN</span>
                            <span class="info-box-number">${data.ticket.fecha}</span>
                        </div>
                    </div>
                </div>
                ${data.ticket.fecha_cierre ? `
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">FECHA DE CIERRE</span>
                            <span class="info-box-number">${data.ticket.fecha_cierre}</span>
                        </div>
                    </div>
                </div>
                ` : ''}
                <div class="col-md-12">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">TÉCNICO ASIGNADO</span>
                            <span class="info-box-number">${data.ticket.tecnico}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-muted">DESCRIPCIÓN DEL PROBLEMA</span>
                            <span class="info-box-number">${data.ticket.descripcion}</span>
                        </div>
                    </div>
                </div>
                ${botonFinalizarHTML}
            </div>
        `);
        
        // Remover eventos anteriores y agregar nuevo
        $('#btnFinalizarTicketHistorial').off('click').on('click', function() {
            finalizarTicket(currentTicketId);
        });
    }
    
    // Usar event delegation para los botones
    $(document).on('click', '.btn-ver-ticket', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const ticketId = $(this).data('id');
        const estado = $(this).data('estado');
        
        console.log('Botón clickeado - Ticket ID:', ticketId, 'Estado:', estado);
        
        if (ticketId) {
            abrirDetalleTicket(ticketId);
        } else {
            console.error('No se encontró ticket ID');
            Swal.fire('Error', 'No se pudo identificar el ticket', 'error');
        }
    });
    
    // Función para finalizar ticket
    function finalizarTicket(ticketId) {
        Swal.fire({
            title: '¿Finalizar ticket?',
            text: "¿Estás seguro que el problema ha sido resuelto?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, finalizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Finalizando ticket',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/usuario/completarTicket',
                    type: 'POST',
                    data: { ticket_id: ticketId },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Ticket finalizado!',
                                text: 'El ticket ha sido completado exitosamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error de conexión: ' + error, 'error');
                    }
                });
            }
        });
    }
    
    // Limpiar polling cuando se cierra el modal
    $('#modalDetalleTicket').on('hidden.bs.modal', function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        currentTicketId = null;
    });
});
</script>

<style>
    .nav-tabs .nav-link.active {
        border-top: 3px solid #ffc107 !important;
        border-bottom: none !important;
        color: #007bff !important;
        font-weight: bold;
    }
    .nav-tabs .nav-link:hover {
        border-top: 3px solid #28a745 !important;
    }
    .table th {
        font-weight: 600;
    }
    .btn-ver-ticket {
        background-color: #007bff;
        color: white;
        border: none;
        transition: all 0.2s;
    }
    .btn-ver-ticket:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .info-box {
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .info-box-number {
        font-size: 14px;
        font-weight: normal;
        word-break: break-word;
    }
</style>
<?= $this->endSection() ?>