<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= site_url('usuario/dashboard') ?>" class="nav-link active">
        <i class="fas fa-tachometer-alt"></i>
        <p>Inicio</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('usuario/historial') ?>" class="nav-link" id="btnHistorial">
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
                    <i class="fas fa-exclamation-triangle"></i> 
                    SELECCIONA TU PROBLEMA
                </h3>
            </div>
            <div class="card-body">
                <form id="formProblema">
                    <div class="form-group">
                        <label for="categoria">
                            <i class="fas fa-list" style="color: #007bff;"></i> 
                            <strong>Categoría principal</strong>
                        </label>
                        <select class="form-control form-control-lg" id="categoria" required>
                            <option value="">-- Selecciona una categoría --</option>
                            <?php foreach ($problematicas as $problema): ?>
                                <option value="<?= $problema['clasificacion'] ?>">
                                    <?= $problema['clasificacion'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success" id="btnContinuar" style="font-size: 1.3rem; padding: 12px 30px; border-radius: 50px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <i class="fas fa-arrow-right"></i> CONTINUAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PREVIEW - Confirmación antes de guardar -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list"></i> CONFIRMA TUS DATOS
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">NOMBRE Y APELLIDO</span>
                                <span class="info-box-number" id="previewNombre">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">CÉDULA</span>
                                <span class="info-box-number" id="previewCedula">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">MÓDULO</span>
                                <span class="info-box-number" id="previewModulo">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">FECHA DE CREACIÓN</span>
                                <span class="info-box-number" id="previewFecha">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">CATEGORÍA DEL PROBLEMA</span>
                                <span class="info-box-number" id="previewCategoria">---</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelarPreview">
                    <i class="fas fa-times"></i> CANCELAR
                </button>
                <button type="button" class="btn btn-primary" id="btnConfirmarEnviar">
                    <i class="fas fa-paper-plane"></i> ENVIAR TICKET
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE SEGUIMIENTO - Después de enviar el ticket -->
<div class="modal fade" id="modalSeguimiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt"></i> SEGUIMIENTO DE TICKET
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCloseSeguimientoModal" style="display: none;">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="cargandoTicket" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2">Guardando tu ticket...</p>
                </div>
                
                <div id="contenidoSeguimiento">
                    <div class="alert alert-info" id="mensajeEspera">
                        <i class="fas fa-hourglass-half"></i> <strong>Ticket enviado!</strong> En espera de asignación de técnico...
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">NOMBRE Y APELLIDO</span>
                                    <span class="info-box-number" id="seguimientoNombre">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">CÉDULA</span>
                                    <span class="info-box-number" id="seguimientoCedula">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">MÓDULO</span>
                                    <span class="info-box-number" id="seguimientoModulo">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">FECHA DE CREACIÓN</span>
                                    <span class="info-box-number" id="seguimientoFecha">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted">CATEGORÍA DEL PROBLEMA</span>
                                    <span class="info-box-number" id="seguimientoCategoria">---</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12" id="seccionTecnico" style="display: none;">
                            <div class="info-box bg-info">
                                <div class="info-box-content">
                                    <span class="info-box-text text-white"><i class="fas fa-user-cog"></i> TÉCNICO ASIGNADO</span>
                                    <span class="info-box-number text-white" id="seguimientoTecnico">---</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12" id="seccionTiempo" style="display: none;">
                            <div class="info-box bg-warning">
                                <div class="info-box-content">
                                    <span class="info-box-text"><i class="fas fa-clock"></i> TIEMPO ESTIMADO</span>
                                    <span class="info-box-number" id="seguimientoTiempo">---</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 text-center" id="seccionBotonFinalizar" style="display: none;">
                            <button type="button" class="btn btn-lg btn-success" id="btnFinalizarTicket" style="border-radius: 50px; padding: 12px 40px; font-size: 1.2rem;">
                                <i class="fas fa-check-circle"></i> FINALIZAR TICKET
                            </button>
                        </div>
                        
                        <div class="col-md-12 text-center" id="seccionCompletado" style="display: none;">
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> <strong>¡Ticket completado!</strong> El soporte ha sido finalizado exitosamente.
                                <br><small>Gracias por usar nuestro sistema.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCerrarSeguimientoModal" style="border-radius: 50px; padding: 8px 25px;">
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const categoriaSelect = document.getElementById('categoria');
    let currentTicketId = null;
    let updateInterval = null;
    let previewData = {};

    // ==============================================
    // PASO 1: Formulario - Muestra PREVIEW
    // ==============================================
    const form = document.getElementById('formProblema');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const categoria = categoriaSelect.value;

        if (!categoria) {
            alert("⚠️ Por favor, selecciona una categoría de problema.");
            categoriaSelect.focus();
            return;
        }

        // Obtener datos del usuario desde la sesión
       // Obtener datos del usuario desde la sesión Y EL NOMBRE DEL MÓDULO DESDE PHP
const nombreCompleto = "<?= session()->get('user_nombre') ?? session()->get('nombre') ?? 'Usuario' ?> <?= session()->get('user_apellido') ?? session()->get('apellido') ?? '' ?>";
const cedula = "<?= session()->get('user_ci') ?? session()->get('ci') ?? 'No registrada' ?>";
const modulo = "<?= $modulo_nombre ?? 'Soporte Técnico' ?>";  // ← CAMBIAR ESTA LÍNEA

const fechaActual = new Date();
const fechaFormateada = fechaActual.toLocaleString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
});

        // Guardar datos para enviar después
        previewData = {
            nombre: nombreCompleto,
            cedula: cedula,
            modulo: modulo,
            categoria: categoria,
            fecha: fechaFormateada
        };

        // Llenar modal preview
        document.getElementById('previewNombre').textContent = previewData.nombre;
        document.getElementById('previewCedula').textContent = previewData.cedula;
        document.getElementById('previewModulo').textContent = previewData.modulo;
        document.getElementById('previewFecha').textContent = previewData.fecha;
        document.getElementById('previewCategoria').textContent = previewData.categoria;

        // Abrir modal preview
        $('#modalPreview').modal('show');
    });

    // ==============================================
    // PASO 2: Confirmar ENVÍO - Guardar en BD
    // ==============================================
    document.getElementById('btnConfirmarEnviar').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ENVIANDO...';
        
        // Cerrar modal preview
        $('#modalPreview').modal('hide');
        
        // Abrir modal seguimiento con loading
        document.getElementById('cargandoTicket').style.display = 'block';
        document.getElementById('contenidoSeguimiento').style.display = 'none';
        $('#modalSeguimiento').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        
        // Guardar en BD
        fetch('<?= site_url("usuario/guardarProblema") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                categoria: previewData.categoria,
                descripcion: '',
                titulo: previewData.categoria
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('cargandoTicket').style.display = 'none';
            
            if (data.success) {
                currentTicketId = data.ticket_id;
                
                // Llenar datos en modal de seguimiento
                document.getElementById('seguimientoNombre').textContent = previewData.nombre;
                document.getElementById('seguimientoCedula').textContent = previewData.cedula;
                document.getElementById('seguimientoModulo').textContent = previewData.modulo;
                document.getElementById('seguimientoFecha').textContent = previewData.fecha;
                document.getElementById('seguimientoCategoria').textContent = previewData.categoria;
                
                // Ocultar secciones que no deben mostrarse aún
                document.getElementById('seccionTecnico').style.display = 'none';
                document.getElementById('seccionTiempo').style.display = 'none';
                document.getElementById('seccionBotonFinalizar').style.display = 'none';
                document.getElementById('seccionCompletado').style.display = 'none';
                document.getElementById('btnCloseSeguimientoModal').style.display = 'none';
                
                // Mostrar contenido y empezar polling
                document.getElementById('contenidoSeguimiento').style.display = 'block';
                document.getElementById('mensajeEspera').style.display = 'block';
                startTicketPolling();
                
                // Resetear botón
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> ENVIAR TICKET';
            } else {
                Swal.fire('Error', data.message, 'error');
                $('#modalSeguimiento').modal('hide');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> ENVIAR TICKET';
            }
        })
        .catch(error => {
            document.getElementById('cargandoTicket').style.display = 'none';
            $('#modalSeguimiento').modal('hide');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> ENVIAR TICKET';
            Swal.fire('Error', 'Error de conexión. Intenta de nuevo.', 'error');
            console.error('Error:', error);
        });
    });

    // Cancelar preview
    document.getElementById('btnCancelarPreview').addEventListener('click', function() {
        $('#modalPreview').modal('hide');
    });

    // ==============================================
    // POLLING - Actualizar estado del ticket en tiempo real
    // ==============================================
    function startTicketPolling() {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
        updateInterval = setInterval(function() {
            if (currentTicketId) {
                actualizarEstadoTicket();
            }
        }, 3000);
        actualizarEstadoTicket();
    }
    
    function actualizarEstadoTicket() {
        fetch('<?= site_url("usuario/getTicketEstado") ?>/' + currentTicketId, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.ticket) {
                const ticket = data.ticket;
                
                // Ocultar mensaje de espera cuando se asigna técnico
                if (ticket.id_tecnico) {
                    document.getElementById('mensajeEspera').style.display = 'none';
                }
                
                // Mostrar técnico asignado
                if (ticket.id_tecnico && ticket.tecnico_nombre) {
                    const nombreTecnico = ticket.tecnico_nombre + ' ' + (ticket.tecnico_apellido || '');
                    document.getElementById('seguimientoTecnico').textContent = nombreTecnico;
                    document.getElementById('seccionTecnico').style.display = 'block';
                }
                
                // Mostrar tiempo estimado
                if (ticket.tiempo_estimado) {
                    let tiempoTexto = ticket.tiempo_estimado;
                    if (tiempoTexto === '15') tiempoTexto = '15 minutos';
                    else if (tiempoTexto === '30') tiempoTexto = '30 minutos';
                    else if (tiempoTexto === '60') tiempoTexto = '1 hora';
                    else if (tiempoTexto === '120') tiempoTexto = '2 horas';
                    else if (tiempoTexto === 'urgente') tiempoTexto = 'URGENTE - Atención inmediata';
                    
                    document.getElementById('seguimientoTiempo').textContent = tiempoTexto;
                    document.getElementById('seccionTiempo').style.display = 'block';
                }
                
                // Mostrar botón FINALIZAR TICKET (solo si tiene técnico y tiempo, y no está completado)
                if (ticket.id_tecnico && ticket.tiempo_estimado && !ticket.estado_completado) {
                    document.getElementById('seccionBotonFinalizar').style.display = 'block';
                }
                
                // Ticket completado
                if (ticket.estado_completado) {
                    document.getElementById('seccionCompletado').style.display = 'block';
                    document.getElementById('seccionBotonFinalizar').style.display = 'none';
                    document.getElementById('btnCloseSeguimientoModal').style.display = 'block';
                    
                    if (updateInterval) {
                        clearInterval(updateInterval);
                        updateInterval = null;
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error al actualizar ticket:', error);
        });
    }
    
    // ==============================================
    // FINALIZAR TICKET (AHORA SOLO EL USUARIO)
    // ==============================================
    document.getElementById('btnFinalizarTicket').addEventListener('click', function() {
        if (!currentTicketId) return;
        
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PROCESANDO...';
        
        fetch('<?= site_url("usuario/completarTicket") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ ticket_id: currentTicketId })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> FINALIZAR TICKET';
            
            if (data.success) {
                actualizarEstadoTicket();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> FINALIZAR TICKET';
            Swal.fire('Error', 'Error de conexión', 'error');
        });
    });
    
    // ==============================================
    // CERRAR MODAL DE SEGUIMIENTO
    // ==============================================
    document.getElementById('btnCerrarSeguimientoModal').addEventListener('click', function() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        $('#modalSeguimiento').modal('hide');
        document.getElementById('formProblema').reset();
        currentTicketId = null;
    });
    
    // ==============================================
    // HISTORIAL
    // ==============================================
    document.getElementById('btnHistorial').addEventListener('click', function() {
        $('#modalHistorial').modal('show');
        
        // Cargar historial
        fetch('<?= site_url("usuario/getHistorial") ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.tickets) {
                let html = '<div class="table-responsive"><table class="table table-bordered">';
                html += '<thead><tr><th>ID</th><th>Problema</th><th>Técnico</th><th>Estado</th><th>Fecha</th></tr></thead><tbody>';
                
                data.tickets.forEach(ticket => {
                    let estado = '';
                    if (ticket.estado_completado) {
                        estado = '<span class="badge badge-success">Completado</span>';
                    } else if (ticket.id_tecnico) {
                        estado = '<span class="badge badge-primary">En proceso</span>';
                    } else {
                        estado = '<span class="badge badge-warning">Pendiente</span>';
                    }
                    
                    html += `<tr>
                        <td>#${String(ticket.id).padStart(4, '0')}</td>
                        <td>${ticket.clasificacion || 'N/A'}</td>
                        <td>${ticket.tecnico_nombre || 'No asignado'} ${ticket.tecnico_apellido || ''}</td>
                        <td>${estado}</td>
                        <td>${new Date(ticket.creacion_del_ticket).toLocaleString()}</td>
                    </tr>`;
                });
                
                html += '</tbody></table></div>';
                document.getElementById('historialContent').innerHTML = html;
            } else {
                document.getElementById('historialContent').innerHTML = '<div class="alert alert-info">No hay tickets en el historial</div>';
            }
        })
        .catch(error => {
            document.getElementById('historialContent').innerHTML = '<div class="alert alert-danger">Error al cargar el historial</div>';
        });
    });
});
</script>

<style>
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    .btn-success:hover {
        background-color: #1e7e34 !important;
        border-color: #1e7e34 !important;
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
    .modal-header .close {
        color: white;
        opacity: 0.8;
    }
    .modal-header .close:hover {
        opacity: 1;
    }
    .bg-info .info-box-number, .bg-info .info-box-text {
        color: white !important;
    }
    #cargandoTicket {
        padding: 40px;
    }
</style>
<?= $this->endSection() ?>