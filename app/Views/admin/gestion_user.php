<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
  <li class="nav-item">
    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>Dashboard</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/gestion-tecnicos') ?>" class="nav-link">
      <i class="nav-icon fas fa-user-cog"></i>
      <p>Gestionar Técnicos</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="<?= base_url('admin/gestion-usuarios') ?>" class="nav-link active">
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

<div class="container-fluid mb-5">
    <h1>Gestión de Usuarios</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header border-transparent">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users mr-2"></i> Gestión de Usuarios del Sistema</h3>

                <div class="card-tools">
                    <button class="btn btn-success btn-sm mr-2" id="btnAgregarUsuario">
                        <i class="fas fa-plus"></i> Agregar Usuario
                    </button>
                    
                    <button class="btn btn-navy btn-sm mr-2" data-toggle="modal" data-target="#modalDescargarUsuarios" style="background-color: #001f3f; color: white;">
                        <i class="fas fa-download"></i> Descargar
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
                            <th>Módulo</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                        <tr>
                            <td colspan="6" class="text-center">Cargando usuarios...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <small class="text-muted">Mostrando todos los usuarios registrados en el sistema.</small>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AGREGAR USUARIO -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-user-plus mr-2"></i> Registrar Nuevo Usuario
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAgregarUsuario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevoNombre">Nombre *</label>
                                <input type="text" class="form-control" id="nuevoNombre" name="nombre" placeholder="Ej: Juan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevoApellido">Apellido *</label>
                                <input type="text" class="form-control" id="nuevoApellido" name="apellido" placeholder="Ej: Pérez" required>
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
                        <label for="nuevoModulo">Módulo del Usuario *</label>
                        <select class="form-control custom-select" id="nuevoModulo" name="modulo" required>
                            <option value="">Seleccione un módulo</option>
                            <option value="1">Módulo 1</option>
                            <option value="2">Módulo 2</option>
                            <option value="3">Módulo 3</option>
                            <option value="4">Módulo 4</option>
                            <option value="5">Módulo 5</option>
                            <option value="6">Módulo 6</option>
                            <option value="7">Módulo 7</option>
                            <option value="8">Módulo 8</option>
                            <option value="9">Módulo 9</option>
                            <option value="10">Módulo 10</option>
                            <option value="11">Módulo 11</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nuevoEstado">Estado Inicial</label>
                        <select class="form-control custom-select" id="nuevoEstado" name="estado">
                            <option value="0" selected>Activo</option>
                            <option value="1">Inactivo (Suspendido)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Editar Información del Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarUsuario">
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNombre">Nombre *</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editApellido">Apellido *</label>
                                <input type="text" class="form-control" id="editApellido" name="apellido" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCedula">Cédula de Identidad *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="editCedula" name="cedula" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editModulo">Módulo del Usuario</label>
                        <select class="form-control custom-select" id="editModulo" name="modulo">
                            <option value="1">Módulo 1</option>
                            <option value="2">Módulo 2</option>
                            <option value="3">Módulo 3</option>
                            <option value="4">Módulo 4</option>
                            <option value="5">Módulo 5</option>
                            <option value="6">Módulo 6</option>
                            <option value="7">Módulo 7</option>
                            <option value="8">Módulo 8</option>
                            <option value="9">Módulo 9</option>
                            <option value="10">Módulo 10</option>
                            <option value="11">Módulo 11</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editEstado">Estado en el Sistema</label>
                        <select class="form-control custom-select" id="editEstado" name="estado">
                            <option value="0" class="text-success">Activo</option>
                            <option value="1" class="text-danger">Inactivo (Suspendido)</option>
                        </select>
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

<!-- MODAL ELIMINAR USUARIO -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-trash-alt mr-2"></i> Confirmar Ocultar Usuario
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-circle fa-4x"></i>
                </div>
                
                <h4 class="font-weight-bold">¿Deseas ocultar a este usuario?</h4>
                <p class="text-muted">
                    Estás a punto de ocultar a <strong><span id="nombreUsuarioEliminar"></span></strong>. 
                    Esta acción no elimina el registro de la base de datos, solo lo oculta del sistema.
                </p>

                <div class="alert alert-warning py-2">
                    <small><i class="fas fa-info-circle"></i> El usuario oculto no aparecerá en la lista, pero sus datos permanecen en la base de datos.</small>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4 mr-2" data-dismiss="modal">No, cancelar</button>
                <button type="button" class="btn btn-danger px-4 shadow" id="btnConfirmarEliminar">
                    <i class="fas fa-eye-slash mr-1"></i> Sí, ocultar usuario
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DESCARGAR USUARIOS -->
<div class="modal fade" id="modalDescargarUsuarios" tabindex="-1" role="dialog" aria-labelledby="labelDescargar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-file-download mr-2"></i> Descargar Lista de Usuarios
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('usuarios/exportar') ?>" method="POST">
                <div class="modal-body text-center">
                    <p class="text-muted">Seleccione el formato y los criterios para generar el reporte de usuarios registrados en el sistema.</p>
                    
                    <div class="row mt-4">
                        <div class="col-6">
                            <input type="radio" name="formato" value="pdf" id="pdf_opt" class="d-none" checked>
                            <label for="pdf_opt" class="format-card p-4 w-100 text-center rounded border shadow-sm pointer">
                                <div class="icon-circle bg-light-danger mb-3 mx-auto">
                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                </div>
                                <span class="d-block font-weight-bold text-dark">Documento PDF</span>
                                <small class="text-muted">Ideal para imprimir</small>
                                <div class="check-mark"><i class="fas fa-check-circle"></i></div>
                            </label>
                        </div>
                        
                        <div class="col-6">
                            <input type="radio" name="formato" value="excel" id="excel_opt" class="d-none">
                            <label for="excel_opt" class="format-card p-4 w-100 text-center rounded border shadow-sm pointer">
                                <div class="icon-circle bg-light-success mb-3 mx-auto">
                                    <i class="fas fa-file-excel fa-3x text-success"></i>
                                </div>
                                <span class="d-block font-weight-bold text-dark">Hoja de Excel</span>
                                <small class="text-muted">Para análisis de datos</small>
                                <div class="check-mark"><i class="fas fa-check-circle"></i></div>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group text-left">
                        <label for="filtroModulo">Filtrar por Módulo (Opcional)</label>
                        <select class="form-control custom-select" id="filtroModulo" name="modulo_reporte">
                            <option value="todos" selected>Todos los módulos</option>
                            <option value="1">Módulo 1</option>
                            <option value="2">Módulo 2</option>
                            <option value="3">Módulo 3</option>
                            <option value="4">Módulo 4</option>
                            <option value="5">Módulo 5</option>
                            <option value="6">Módulo 6</option>
                            <option value="7">Módulo 7</option>
                            <option value="8">Módulo 8</option>
                            <option value="9">Módulo 9</option>
                            <option value="10">Módulo 10</option>
                            <option value="11">Módulo 11</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-navy font-weight-bold" style="background-color: #001f3f; color: white;">
                        <i class="fas fa-download mr-1"></i> Generar Reporte
                    </button>
                </div>
            </form>
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
    
    .format-card {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        border: 2px solid #f4f6f9 !important;
    }

    .format-card:hover {
        transform: translateY(-5px);
        background-color: #f8f9fa;
        border-color: #dee2e6 !important;
    }

    input[type="radio"]:checked + .format-card {
        border-color: #001f3f !important;
        background-color: #f0f7ff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .bg-light-danger { background-color: #ffeef0; }
    .bg-light-success { background-color: #e8fadf; }

    .check-mark {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #001f3f;
        opacity: 0;
        transition: opacity 0.3s;
    }
    input[type="radio"]:checked + .format-card .check-mark {
        opacity: 1;
    }

    .pointer { cursor: pointer; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var selectedUsuario = null;
    
    cargarUsuarios();
    
    function cargarUsuarios(buscar = '') {
        $('#tablaUsuarios').html('<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin mr-2"></i>Cargando usuarios...</td></table>');
        
        $.ajax({
            url: '<?= base_url("admin/api/usuarios/listar") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    mostrarUsuarios(response.data, buscar);
                } else {
                    $('#tablaUsuarios').html('<tr><td colspan="6" class="text-center text-danger">Error al cargar usuarios</td></tr>');
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                $('#tablaUsuarios').html('<tr><td colspan="6" class="text-center text-danger">Error de conexión</td></tr>');
                Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
            }
        });
    }
    
    function mostrarUsuarios(usuarios, buscar) {
        if (usuarios.length === 0) {
            $('#tablaUsuarios').html('<tr><td colspan="6" class="text-center">No hay usuarios registrados</td></tr>');
            return;
        }
        
        let usuariosFiltrados = usuarios;
        if (buscar && buscar.trim() !== '') {
            usuariosFiltrados = usuarios.filter(usuario => 
                usuario.ci.toLowerCase().includes(buscar.toLowerCase())
            );
        }
        
        if (usuariosFiltrados.length === 0) {
            $('#tablaUsuarios').html('<tr><td colspan="6" class="text-center">No se encontraron usuarios con esa cédula</td></tr>');
            return;
        }
        
        let html = '';
        usuariosFiltrados.forEach(usuario => {
            html += `
                <tr>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.apellido}</td>
                    <td>${usuario.ci}</td>
                    <td><span class="badge badge-primary">Módulo ${usuario.modulo_id || '1'}</span></td>
                    <td><span class="badge badge-${usuario.estado_badge}">${usuario.estado_texto}</span></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm btn-editar" 
                                data-id="${usuario.id}" 
                                data-nombre="${usuario.nombre}" 
                                data-apellido="${usuario.apellido}" 
                                data-ci="${usuario.ci}" 
                                data-modulo="${usuario.modulo_id || 1}"
                                data-activo="${usuario.activo}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar" 
                                data-id="${usuario.id}" 
                                data-nombre="${usuario.nombre} ${usuario.apellido}">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        $('#tablaUsuarios').html(html);
    }
    
    $('#btnBuscar').click(function() {
        const buscar = $('#buscarCedula').val();
        cargarUsuarios(buscar);
    });
    
    $('#buscarCedula').keypress(function(e) {
        if (e.which === 13) {
            $('#btnBuscar').click();
        }
    });
    
    $('#btnAgregarUsuario').click(function() {
        $('#formAgregarUsuario')[0].reset();
        $('#modalAgregarUsuario').modal('show');
    });
    
    $(document).on('click', '.btn-editar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const apellido = $(this).data('apellido');
        const ci = $(this).data('ci');
        const modulo = $(this).data('modulo');
        const activo = $(this).data('activo');
        
        $('#editId').val(id);
        $('#editNombre').val(nombre);
        $('#editApellido').val(apellido);
        $('#editCedula').val(ci);
        $('#editModulo').val(modulo);
        $('#editEstado').val(activo === true || activo === 'true' ? '0' : '1');
        
        $('#modalEditarUsuario').modal('show');
    });
    
    $('#formAgregarUsuario').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            nombre: $('#nuevoNombre').val(),
            apellido: $('#nuevoApellido').val(),
            cedula: $('#nuevoCedula').val(),
            modulo: $('#nuevoModulo').val(),
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
            url: '<?= base_url("admin/api/usuarios/agregar") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registrado!',
                        html: `Usuario registrado exitosamente.<br><strong>Contraseña predeterminada:</strong> ${response.password_default}`,
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        $('#modalAgregarUsuario').modal('hide');
                        cargarUsuarios();
                    });
                } else {
                    let errorMsg = response.message;
                    if (response.errors) {
                        errorMsg = Object.values(response.errors).join('<br>');
                    }
                    Swal.fire('Error', errorMsg, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al registrar usuario', 'error');
            }
        });
    });
    
    $('#formEditarUsuario').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            id: $('#editId').val(),
            nombre: $('#editNombre').val(),
            apellido: $('#editApellido').val(),
            cedula: $('#editCedula').val(),
            modulo: $('#editModulo').val(),
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
            url: '<?= base_url("admin/api/usuarios/editar") ?>',
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
                        $('#modalEditarUsuario').modal('hide');
                        cargarUsuarios();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al actualizar usuario', 'error');
            }
        });
    });
    
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        
        selectedUsuario = { id: id, nombre: nombre };
        $('#nombreUsuarioEliminar').text(nombre);
        $('#modalEliminarUsuario').modal('show');
    });
    
    $('#btnConfirmarEliminar').click(function() {
        if (!selectedUsuario) return;
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción ocultará al usuario pero no lo eliminará permanentemente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, ocultar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Ocultando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '<?= base_url("admin/api/usuarios/eliminar") ?>',
                    type: 'POST',
                    data: { id: selectedUsuario.id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Ocultado!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                $('#modalEliminarUsuario').modal('hide');
                                cargarUsuarios();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al ocultar usuario', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection() ?>