<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= site_url('dashboard') ?>" class="nav-link active">
        <i class="fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fas fa-ticket-alt"></i>
        <p>Mis Tickets</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fas fa-history"></i>
        <p>Historial</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fas fa-user"></i>
        <p>Mi Perfil</p>
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
                            <option value="hardware">🔧 Problemas de hardware</option>
                            <option value="software">💻 Problemas de software</option>
                            <option value="red">🌐 Problemas de red y conectividad</option>
                            <option value="rendimiento">🐢 Problemas de rendimiento</option>
                        </select>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success" style="font-size: 1.3rem; padding: 12px 30px; border-radius: 50px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <i class="fas fa-arrow-right"></i> CONTINUAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR TICKET -->
<div class="modal fade" id="modalTicket" tabindex="-1" role="dialog" aria-labelledby="modalTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="modalTicketLabel">
                    <i class="fas fa-ticket-alt"></i> CONFIRMAR TICKET
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">NOMBRE Y APELLIDO</span>
                                <span class="info-box-number" id="modalNombre">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">CÉDULA</span>
                                <span class="info-box-number" id="modalCedula">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">MÓDULO</span>
                                <span class="info-box-number" id="modalModulo">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">FECHA DE CREACIÓN</span>
                                <span class="info-box-number" id="modalFecha">---</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">CATEGORÍA DEL PROBLEMA</span>
                                <span class="info-box-number" id="modalCategoria">---</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px; padding: 8px 25px;">
                    <i class="fas fa-arrow-left"></i> REGRESAR
                </button>
                <button type="button" class="btn btn-success" id="btnEnviarTicket" style="border-radius: 50px; padding: 8px 25px;">
                    <i class="fas fa-paper-plane"></i> ENVIAR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Usamos vanilla JavaScript para evitar conflictos con jQuery
document.addEventListener("DOMContentLoaded", function() {
    const categoriaSelect = document.getElementById('categoria');

    // Variables para almacenar datos del ticket temporalmente
    let ticketData = {};

    // Formulario CONTINUAR - abre el modal
    const form = document.getElementById('formProblema');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const categoria = categoriaSelect.value;

        if (!categoria) {
            alert("⚠️ Por favor, selecciona una categoría de problema.");
            categoriaSelect.focus();
            return;
        }

        // Obtener datos del usuario desde la sesión (vía PHP)
        const nombreCompleto = "<?= session()->get('user_nombre') ?? session()->get('nombre') ?? 'Usuario' ?> <?= session()->get('user_apellido') ?? session()->get('apellido') ?? '' ?>";
        const cedula = "<?= session()->get('user_cedula') ?? session()->get('cedula') ?? 'No registrada' ?>";
        const modulo = "<?= session()->get('user_modulo') ?? session()->get('modulo') ?? 'Soporte Técnico' ?>";
        
        // Obtener fecha actual
        const fechaActual = new Date();
        const fechaFormateada = fechaActual.toLocaleString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Guardar datos en el objeto temporal
        ticketData = {
            nombre: nombreCompleto,
            cedula: cedula,
            modulo: modulo,
            categoria: categoria,
            fecha: fechaFormateada
        };

        // Llenar el modal con los datos
        document.getElementById('modalNombre').textContent = ticketData.nombre;
        document.getElementById('modalCedula').textContent = ticketData.cedula;
        document.getElementById('modalModulo').textContent = ticketData.modulo;
        document.getElementById('modalFecha').textContent = ticketData.fecha;
        document.getElementById('modalCategoria').textContent = ticketData.categoria;

        // Abrir el modal usando jQuery (porque AdminLTE lo usa)
        $('#modalTicket').modal('show');
    });

    // Botón ENVIAR TICKET - guarda en la base de datos
    document.getElementById('btnEnviarTicket').addEventListener('click', function() {
        // Enviar via AJAX con fetch
        fetch('<?= site_url("UserDashboard/guardarProblema") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                categoria: ticketData.categoria,
                descripcion: '',
                titulo: ticketData.categoria
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cerrar modal
                $('#modalTicket').modal('hide');
                alert("✅ " + data.message);
                // Limpiar formulario
                document.getElementById('formProblema').reset();
                location.reload();
            } else {
                alert("❌ Error: " + data.message);
            }
        })
        .catch(error => {
            alert("❌ Error de conexión con el servidor. Intenta de nuevo.");
        });
    });

    // Botón HISTORIAL
    document.getElementById('btnHistorial').addEventListener('click', function() {
        alert("📋 Aquí puedes ver todo tu historial de reportes.");
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
</style>
<?= $this->endSection() ?>