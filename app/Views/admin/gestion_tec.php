<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>Dashboard</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/gestion-tecnicos') ?>" class="nav-link active">
      <i class="nav-icon fas fa-user-cog"></i>
      <p>Gestionar Técnicos</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/gestion_user') ?>" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>Gestionar Usuarios</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/estadisticas') ?>" class="nav-link">
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
    <a href="<?= base_url('admin/modulo') ?>" class="nav-link">
      <i class="nav-icon fas fa-calendar-alt"></i>
      <p>Modulo</p>
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
    <h1 class="mb-4">Gestión de Técnicos</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header border-transparent">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users-cog mr-2"></i> Gestión de Personal Técnico</h3>

                <div class="card-tools">
                    <button class="btn btn-success btn-sm mr-2" id="btnAgregarTecnico">
                        <i class="fas fa-plus"></i> Agregar Nuevo Técnico
                    </button>
                    
                    <div class="input-group input-group-sm" style="width: 150px; display: inline-flex;">
                        <input type="text" id="buscarCedula" class="form-control float-right" placeholder="Buscar cédula...">
                        <div class="input-group-append">
                            <button type="button" id="btnBuscar" class="btn btn-default">
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
                    <tbody id="tablaTecnicos">
                        <tr>
                            <td colspan="5" class="text-center">Cargando técnicos...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <small class="text-muted">Mostrando todos los técnicos registrados en el sistema.</small>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL AGREGAR TÉCNICO -->
<!-- ============================================ -->
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
                                <label for="nuevoNombre">Nombre *</label>
                                <input type="text" class="form-control" id="nuevoNombre" name="nombre" placeholder="Ej: Carlos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevoApellido">Apellido *</label>
                                <input type="text" class="form-control" id="nuevoApellido" name="apellido" placeholder="Ej: Ruiz" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nuevoCedula">Cédula de Identidad *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nuevoCedula" name="cedula" placeholder="Número de cédula sin puntos" required>
                        </div>
                        <small class="text-muted">La contraseña predeterminada será su número de cédula.</small>
                    </div>

                    <div class="form-group">
                        <label for="nuevoEstado">Estado Inicial</label>
                        <select class="form-control custom-select" id="nuevoEstado" name="estado">
                            <option value="0" selected>Activo</option>
                            <option value="1">Inactivo (Suspendido)</option>
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

<!-- ============================================ -->
<!-- MODAL EDITAR TÉCNICO (CORREGIDO) -->
<!-- ============================================ -->
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
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNombre">Nombre *</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" placeholder="Ej: Carlos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editApellido">Apellido *</label>
                                <input type="text" class="form-control" id="editApellido" name="apellido" placeholder="Ej: Ruiz" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCedula">Cédula de Identidad *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="editCedula" name="cedula" placeholder="Ej: 11222333" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editEstado">Estado en el Sistema</label>
                        <select class="form-control custom-select" id="editEstado" name="estado">
                            <option value="0" class="text-success">Activo</option>
                            <option value="1" class="text-danger">Inactivo (Suspendido)</option>
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

<<!-- ============================================ -->
<!-- MODAL CAMBIO DE ROL (ACTUALIZADO) -->
<!-- ============================================ -->
<!-- MODAL CAMBIO DE ROL (CORREGIDO) -->
<div class="modal fade" id="modalCambioRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Cambiar Rol del Técnico
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="fas fa-user-shield text-warning" style="font-size: 50px;"></i>
                </div>
                
                <p class="lead text-center">¿A qué rol deseas cambiar este usuario?</p>
                
                <div class="alert alert-secondary">
                    <strong>Usuario:</strong> <span id="nombreUsuarioRol"></span><br>
                    <strong>Rol Actual:</strong> <span class="badge badge-info">Técnico (ID: 2)</span>
                </div>

                <div class="form-group">
                    <label for="nuevoRol">Seleccionar Nuevo Rol:</label>
                    <select class="form-control" id="nuevoRol">
                        <option value="">-- Seleccione un rol --</option>
                        <option value="1">Administrador (Acceso total - Rol ID: 1)</option>
                        <option value="3">Usuario Normal (Solo crear tickets - Rol ID: 3)</option>
                    </select>
                    <small class="text-muted">Selecciona el nuevo rol para este usuario</small>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Información de Roles:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Administrador (ID: 1):</strong> Podrá gestionar técnicos, tickets y todo el sistema.</li>
                        <li><strong>Técnico (ID: 2):</strong> Rol actual del usuario.</li>
                        <li><strong>Usuario Normal (ID: 3):</strong> Solo podrá crear y ver sus propios tickets.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning text-dark font-weight-bold" id="btnConfirmarCambioRol">
                    <i class="fas fa-sync-alt mr-1"></i> Confirmar Cambio de Rol
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR TÉCNICO (ACTUALIZADO) -->
<div class="modal fade" id="modalEliminarTecnico" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-trash-alt mr-2"></i> Confirmar Ocultar Técnico
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-circle fa-4x"></i>
                </div>
                
                <h4 class="font-weight-bold">¿Deseas ocultar a este técnico?</h4>
                <p class="text-muted">
                    Estás a punto de ocultar a <strong><span id="nombreTecnicoEliminar"></span></strong>. 
                    Esta acción no elimina el registro de la base de datos, solo lo oculta del sistema.
                </p>

                <div class="alert alert-warning py-2">
                    <small><i class="fas fa-info-circle"></i> El técnico oculto no aparecerá en la lista, pero sus datos permanecen en la base de datos y pueden ser restaurados posteriormente.</small>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4 mr-2" data-dismiss="modal">No, cancelar</button>
                <button type="button" class="btn btn-danger px-4 shadow" id="btnConfirmarEliminar">
                    <i class="fas fa-eye-slash mr-1"></i> Sí, ocultar técnico
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .table td {
        vertical-align: middle !important;
        padding: 12px 8px !important;
    }

    .btn-group .btn {
        margin: 0 2px;
        border-radius: 4px !important;
    }

    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Variable global para almacenar el técnico seleccionado
    var selectedTecnico = null;
    
    // Cargar técnicos al iniciar
    cargarTecnicos();
    
    // Función para cargar técnicos
    function cargarTecnicos(buscar = '') {
        $('#tablaTecnicos').html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin mr-2"></i>Cargando técnicos...</td></tr>');
        
        $.ajax({
            url: '<?= base_url("admin/api/tecnicos/listar") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    mostrarTecnicos(response.data, buscar);
                } else {
                    $('#tablaTecnicos').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar técnicos: ' + response.message + '</td></tr>');
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#tablaTecnicos').html('<tr><td colspan="5" class="text-center text-danger">Error de conexión con el servidor</td></tr>');
                Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
            }
        });
    }
    
    // Función para mostrar técnicos en la tabla
    function mostrarTecnicos(tecnicos, buscar) {
        if (tecnicos.length === 0) {
            $('#tablaTecnicos').html('<tr><td colspan="5" class="text-center">No hay técnicos registrados</td></tr>');
            return;
        }
        
        // Filtrar por cédula si se busca
        let tecnicosFiltrados = tecnicos;
        if (buscar && buscar.trim() !== '') {
            tecnicosFiltrados = tecnicos.filter(tecnico => 
                tecnico.ci.toLowerCase().includes(buscar.toLowerCase())
            );
        }
        
        if (tecnicosFiltrados.length === 0) {
            $('#tablaTecnicos').html('<tr><td colspan="5" class="text-center">No se encontraron técnicos con esa cédula</td></tr>');
            return;
        }
        
        let html = '';
        tecnicosFiltrados.forEach(tecnico => {
            html += `
                <tr>
                    <td>${tecnico.nombre}</td>
                    <td>${tecnico.apellido}</td>
                    <td>${tecnico.ci}</td>
                    <td><span class="badge badge-${tecnico.estado_badge}">${tecnico.estado_texto}</span></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm btn-editar" 
                                data-id="${tecnico.id}" 
                                data-nombre="${tecnico.nombre}" 
                                data-apellido="${tecnico.apellido}" 
                                data-ci="${tecnico.ci}" 
                                data-activo="${tecnico.activo}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button type="button" class="btn btn-warning btn-sm btn-cambiar-rol" 
                                data-id="${tecnico.id}" 
                                data-nombre="${tecnico.nombre} ${tecnico.apellido}">
                                <i class="fas fa-user-shield"></i> Rol
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar" 
                                data-id="${tecnico.id}" 
                                data-nombre="${tecnico.nombre} ${tecnico.apellido}">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        $('#tablaTecnicos').html(html);
    }
    
    // Buscar por cédula
    $('#btnBuscar').click(function() {
        const buscar = $('#buscarCedula').val();
        cargarTecnicos(buscar);
    });
    
    $('#buscarCedula').keypress(function(e) {
        if (e.which === 13) {
            $('#btnBuscar').click();
        }
    });
    
    // Abrir modal Agregar
    $('#btnAgregarTecnico').click(function() {
        $('#formAgregarTecnico')[0].reset();
        $('#modalAgregarTecnico').modal('show');
    });
    
    // ============================================
    // EVENTO PARA EDITAR TÉCNICO (CORREGIDO)
    // ============================================
    $(document).on('click', '.btn-editar', function(e) {
        e.preventDefault();
        
        // Obtener los datos del botón
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const apellido = $(this).data('apellido');
        const ci = $(this).data('ci');
        const activo = $(this).data('activo');
        
        // Llenar el formulario del modal
        $('#editId').val(id);
        $('#editNombre').val(nombre);
        $('#editApellido').val(apellido);
        $('#editCedula').val(ci);
        
        // Convertir activo a valor del select: true=Activo(0), false=Inactivo(1)
        if (activo === true || activo === 'true') {
            $('#editEstado').val('0'); // Activo
        } else {
            $('#editEstado').val('1'); // Inactivo
        }
        
        // Abrir el modal
        $('#modalEditarTecnico').modal('show');
    });
    
    // Enviar formulario de agregar
    $('#formAgregarTecnico').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            nombre: $('#nuevoNombre').val(),
            apellido: $('#nuevoApellido').val(),
            cedula: $('#nuevoCedula').val(),
            estado: $('#nuevoEstado').val()
        };
        
        Swal.fire({
            title: 'Registrando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= base_url("admin/api/tecnicos/agregar") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registrado!',
                        html: `Técnico registrado exitosamente.<br><strong>Contraseña predeterminada:</strong> ${response.password_default}<br><small>Recomendamos cambiar la contraseña en el primer inicio de sesión.</small>`,
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        $('#modalAgregarTecnico').modal('hide');
                        cargarTecnicos();
                    });
                } else {
                    let errorMsg = response.message;
                    if (response.errors) {
                        errorMsg = Object.values(response.errors).join('<br>');
                    }
                    Swal.fire('Error', errorMsg, 'error');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al registrar técnico';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });
    
    // Enviar formulario de editar
    $('#formEditarTecnico').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            id: $('#editId').val(),
            nombre: $('#editNombre').val(),
            apellido: $('#editApellido').val(),
            cedula: $('#editCedula').val(),
            estado: $('#editEstado').val()
        };
        
        Swal.fire({
            title: 'Actualizando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= base_url("admin/api/tecnicos/editar") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: response.message,
                        confirmButtonColor: '#17a2b8'
                    }).then(() => {
                        $('#modalEditarTecnico').modal('hide');
                        cargarTecnicos();
                    });
                } else {
                    let errorMsg = response.message;
                    if (response.errors) {
                        errorMsg = Object.values(response.errors).join('<br>');
                    }
                    Swal.fire('Error', errorMsg, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Error al actualizar técnico', 'error');
            }
        });
    });
    
   // Variable global para almacenar el técnico seleccionado
var selectedTecnico = null;

// Cambiar rol - Abrir modal con opciones
$(document).on('click', '.btn-cambiar-rol', function() {
    const id = $(this).data('id');
    const nombre = $(this).data('nombre');
    
    selectedTecnico = { id: id, nombre: nombre };
    $('#nombreUsuarioRol').text(nombre);
    
    // NO establecer valor por defecto, dejar que el usuario elija
    // $('#nuevoRol').val(''); // Comentado para que no fuerce ningún valor
    
    $('#modalCambioRol').modal('show');
});

// Confirmar cambio de rol
$('#btnConfirmarCambioRol').click(function() {
    if (!selectedTecnico) return;
    
    const nuevoRol = $('#nuevoRol').val();
    
    // Validar que se haya seleccionado un rol
    if (!nuevoRol) {
        Swal.fire('Error', 'Por favor selecciona un rol', 'warning');
        return;
    }
    
    const nombreRol = (nuevoRol == '1') ? 'Administrador' : 'Usuario Normal';
    
    // Mostrar confirmación con el rol seleccionado
    Swal.fire({
        title: '¿Estás seguro?',
        html: `Vas a cambiar a <strong>${selectedTecnico.nombre}</strong> a <strong>${nombreRol}</strong>.<br><br>Esta acción modificará sus permisos de acceso inmediatamente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, cambiar rol',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Cambiando rol...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar petición AJAX
            $.ajax({
                url: '<?= base_url("admin/api/tecnicos/cambiar-rol") ?>',
                type: 'POST',
                data: { 
                    id: selectedTecnico.id,
                    nuevo_rol: nuevoRol 
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta del servidor:', response); // Para depuración
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Rol Cambiado!',
                            text: response.message,
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            $('#modalCambioRol').modal('hide');
                            cargarTecnicos(); // Recargar la tabla
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error detallado:', xhr.responseText);
                    Swal.fire('Error', 'Error al cambiar el rol: ' + error, 'error');
                }
            });
        }
    });
});
    
    // Eliminar técnico
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        
        selectedTecnico = { id: id, nombre: nombre };
        $('#nombreTecnicoEliminar').text(nombre);
        $('#modalEliminarTecnico').modal('show');
    });
    
    // Confirmar eliminación
    $('#btnConfirmarEliminar').click(function() {
        if (!selectedTecnico) return;
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '<?= base_url("admin/api/tecnicos/eliminar") ?>',
                    type: 'POST',
                    data: { id: selectedTecnico.id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                $('#modalEliminarTecnico').modal('hide');
                                cargarTecnicos();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al eliminar técnico', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection() ?>