<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= site_url('dashboard') ?>" class="nav-link">
        <i class="fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('modulo') ?>" class="nav-link active">
        <i class="fas fa-cogs"></i>
        <p>Módulos</p>
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
    
    <div class="col-md-6">
        <div class="card" style="border-top: 4px solid #007bff;">
            <div class="card-header" style="background-color: #007bff; color: white;">
                <h3 class="card-title">
                    <i class="fas fa-cubes"></i> 
                    GESTIÓN DE MÓDULOS
                </h3>
            </div>
            <div class="card-body">
                <!-- Formulario para agregar módulo -->
                <form id="formModulo">
                    <div class="form-group">
                        <label for="modulo_numero">
                            <i class="fas fa-hashtag" style="color: #007bff;"></i> 
                            <strong>Número del Módulo</strong>
                        </label>
                        <input type="text" class="form-control" id="modulo_numero" placeholder="Ej: 01, 02, 03" required>
                    </div>
                    <div class="form-group">
                        <label for="modulo_nombre">
                            <i class="fas fa-tag" style="color: #007bff;"></i> 
                            <strong>Nombre del Módulo</strong>
                        </label>
                        <input type="text" class="form-control" id="modulo_nombre" placeholder="Ej: Salud, Educación, Soporte Técnico" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 8px 25px;">
                            <i class="fas fa-plus-circle"></i> Agregar Módulo
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Lista de módulos -->
                <h5><i class="fas fa-list"></i> Módulos Registrados</h5>
                <div id="listaModulos" class="mt-3">
                    <!-- Ejemplo de módulo existente -->
                    <div class="card mb-2" data-id="1" data-numero="01" data-nombre="Salud">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Número: 01</strong><br>
                                    <span>Nombre: Salud</span>
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm editar-modulo" style="border-radius: 20px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm eliminar-modulo" style="border-radius: 20px;">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" data-id="2" data-numero="02" data-nombre="Educación">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Número: 02</strong><br>
                                    <span>Nombre: Educación</span>
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm editar-modulo" style="border-radius: 20px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm eliminar-modulo" style="border-radius: 20px;">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Problemáticas -->
    <div class="col-md-6">
        <div class="card" style="border-top: 4px solid #28a745;">
            <div class="card-header" style="background-color: #28a745; color: white;">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i> 
                    GESTIÓN DE PROBLEMÁTICAS
                </h3>
            </div>
            <div class="card-body">
                <!-- Formulario para agregar problemática -->
                <form id="formProblematica">
                    <div class="form-group">
                        <label for="problematica_titulo">
                            <i class="fas fa-heading" style="color: #28a745;"></i> 
                            <strong>Título</strong>
                        </label>
                        <input type="text" class="form-control" id="problematica_titulo" placeholder="Ej: Problemas de Red, Software Lento" required>
                    </div>
                    <div class="form-group">
                        <label for="problematica_categoria">
                            <i class="fas fa-folder" style="color: #28a745;"></i> 
                            <strong>Categoría</strong>
                        </label>
                        <input type="text" class="form-control" id="problematica_categoria" placeholder="Ej: Sin Red, Conexión Inestable" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success" style="border-radius: 50px; padding: 8px 25px;">
                            <i class="fas fa-plus-circle"></i> Agregar Problemática
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Lista de problemáticas -->
                <h5><i class="fas fa-list"></i> Problemáticas Registradas</h5>
                <div id="listaProblematicas" class="mt-3">
                    <!-- Ejemplo de problemática existente -->
                    <div class="card mb-2" data-id="1" data-titulo="Redes" data-categoria="Sin Red">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Título: Redes</strong><br>
                                    <span>Categoría: Sin Red</span>
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm editar-problematica" style="border-radius: 20px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm eliminar-problematica" style="border-radius: 20px;">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" data-id="2" data-titulo="Software" data-categoria="Lento">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Título: Software</strong><br>
                                    <span>Categoría: Lento</span>
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm editar-problematica" style="border-radius: 20px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm eliminar-problematica" style="border-radius: 20px;">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR MÓDULO -->
<div class="modal fade" id="modalEditarModulo" tabindex="-1" role="dialog" aria-labelledby="modalEditarModuloLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="modalEditarModuloLabel">
                    <i class="fas fa-edit"></i> Editar Módulo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_modulo_id">
                <div class="form-group">
                    <label for="edit_modulo_numero">Número del Módulo</label>
                    <input type="text" class="form-control" id="edit_modulo_numero" placeholder="Ej: 01, 02, 03">
                </div>
                <div class="form-group">
                    <label for="edit_modulo_nombre">Nombre del Módulo</label>
                    <input type="text" class="form-control" id="edit_modulo_nombre" placeholder="Ej: Salud, Educación">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px;">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarModulo" style="border-radius: 50px;">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR PROBLEMÁTICA -->
<div class="modal fade" id="modalEditarProblematica" tabindex="-1" role="dialog" aria-labelledby="modalEditarProblematicaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="modalEditarProblematicaLabel">
                    <i class="fas fa-edit"></i> Editar Problemática
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_problematica_id">
                <div class="form-group">
                    <label for="edit_problematica_titulo">Título</label>
                    <input type="text" class="form-control" id="edit_problematica_titulo" placeholder="Ej: Redes, Software">
                </div>
                <div class="form-group">
                    <label for="edit_problematica_categoria">Categoría</label>
                    <input type="text" class="form-control" id="edit_problematica_categoria" placeholder="Ej: Sin Red, Lento">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px;">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnGuardarProblematica" style="border-radius: 50px;">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // ==================== MÓDULOS ====================
    
    // Agregar Módulo
    const formModulo = document.getElementById('formModulo');
    formModulo.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const numero = document.getElementById('modulo_numero').value;
        const nombre = document.getElementById('modulo_nombre').value;
        
        if(!numero || !nombre) {
            Swal.fire('Error', 'Por favor complete todos los campos', 'error');
            return;
        }
        
        // Crear ID temporal (simular)
        const nuevoId = Date.now();
        
        // Crear elemento de módulo
        const nuevoModulo = crearElementoModulo(nuevoId, numero, nombre);
        document.getElementById('listaModulos').appendChild(nuevoModulo);
        
        // Limpiar formulario
        formModulo.reset();
        
        Swal.fire('Éxito', 'Módulo agregado correctamente', 'success');
    });
    
    // Función para crear elemento módulo
    function crearElementoModulo(id, numero, nombre) {
        const divCard = document.createElement('div');
        divCard.className = 'card mb-2';
        divCard.setAttribute('data-id', id);
        divCard.setAttribute('data-numero', numero);
        divCard.setAttribute('data-nombre', nombre);
        
        divCard.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Número: ${numero}</strong><br>
                        <span>Nombre: ${nombre}</span>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm editar-modulo" style="border-radius: 20px;">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm eliminar-modulo" style="border-radius: 20px;">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar eventos a los nuevos botones
        divCard.querySelector('.editar-modulo').addEventListener('click', function() {
            abrirModalEditarModulo(id, numero, nombre);
        });
        
        divCard.querySelector('.eliminar-modulo').addEventListener('click', function() {
            eliminarModulo(divCard, nombre);
        });
        
        return divCard;
    }
    
    // Editar Módulo
    function abrirModalEditarModulo(id, numero, nombre) {
        document.getElementById('edit_modulo_id').value = id;
        document.getElementById('edit_modulo_numero').value = numero;
        document.getElementById('edit_modulo_nombre').value = nombre;
        $('#modalEditarModulo').modal('show');
    }
    
    document.getElementById('btnGuardarModulo').addEventListener('click', function() {
        const id = document.getElementById('edit_modulo_id').value;
        const nuevoNumero = document.getElementById('edit_modulo_numero').value;
        const nuevoNombre = document.getElementById('edit_modulo_nombre').value;
        
        if(!nuevoNumero || !nuevoNombre) {
            Swal.fire('Error', 'Complete todos los campos', 'error');
            return;
        }
        
        // Actualizar en el DOM
        const elementoModulo = document.querySelector(`#listaModulos .card[data-id="${id}"]`);
        if(elementoModulo) {
            elementoModulo.setAttribute('data-numero', nuevoNumero);
            elementoModulo.setAttribute('data-nombre', nuevoNombre);
            elementoModulo.querySelector('.card-body .d-flex div').innerHTML = `
                <strong>Número: ${nuevoNumero}</strong><br>
                <span>Nombre: ${nuevoNombre}</span>
            `;
        }
        
        $('#modalEditarModulo').modal('hide');
        Swal.fire('Actualizado', 'Módulo modificado correctamente', 'success');
    });
    
    // Eliminar Módulo
    function eliminarModulo(elemento, nombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar el módulo "${nombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                elemento.remove();
                Swal.fire('Eliminado', 'Módulo eliminado correctamente', 'success');
            }
        });
    }
    
    // Asignar eventos a botones de módulos existentes
    document.querySelectorAll('.editar-modulo').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.card');
            const id = card.getAttribute('data-id');
            const numero = card.getAttribute('data-numero');
            const nombre = card.getAttribute('data-nombre');
            abrirModalEditarModulo(id, numero, nombre);
        });
    });
    
    document.querySelectorAll('.eliminar-modulo').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.card');
            const nombre = card.getAttribute('data-nombre');
            eliminarModulo(card, nombre);
        });
    });
    
    // ==================== PROBLEMÁTICAS ====================
    
    // Agregar Problemática
    const formProblematica = document.getElementById('formProblematica');
    formProblematica.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const titulo = document.getElementById('problematica_titulo').value;
        const categoria = document.getElementById('problematica_categoria').value;
        
        if(!titulo || !categoria) {
            Swal.fire('Error', 'Por favor complete todos los campos', 'error');
            return;
        }
        
        const nuevoId = Date.now();
        
        const nuevaProblematica = crearElementoProblematica(nuevoId, titulo, categoria);
        document.getElementById('listaProblematicas').appendChild(nuevaProblematica);
        
        formProblematica.reset();
        
        Swal.fire('Éxito', 'Problemática agregada correctamente', 'success');
    });
    
    // Función para crear elemento problemática
    function crearElementoProblematica(id, titulo, categoria) {
        const divCard = document.createElement('div');
        divCard.className = 'card mb-2';
        divCard.setAttribute('data-id', id);
        divCard.setAttribute('data-titulo', titulo);
        divCard.setAttribute('data-categoria', categoria);
        
        divCard.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Título: ${titulo}</strong><br>
                        <span>Categoría: ${categoria}</span>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm editar-problematica" style="border-radius: 20px;">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm eliminar-problematica" style="border-radius: 20px;">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        divCard.querySelector('.editar-problematica').addEventListener('click', function() {
            abrirModalEditarProblematica(id, titulo, categoria);
        });
        
        divCard.querySelector('.eliminar-problematica').addEventListener('click', function() {
            eliminarProblematica(divCard, titulo);
        });
        
        return divCard;
    }
    
    // Editar Problemática
    function abrirModalEditarProblematica(id, titulo, categoria) {
        document.getElementById('edit_problematica_id').value = id;
        document.getElementById('edit_problematica_titulo').value = titulo;
        document.getElementById('edit_problematica_categoria').value = categoria;
        $('#modalEditarProblematica').modal('show');
    }
    
    document.getElementById('btnGuardarProblematica').addEventListener('click', function() {
        const id = document.getElementById('edit_problematica_id').value;
        const nuevoTitulo = document.getElementById('edit_problematica_titulo').value;
        const nuevaCategoria = document.getElementById('edit_problematica_categoria').value;
        
        if(!nuevoTitulo || !nuevaCategoria) {
            Swal.fire('Error', 'Complete todos los campos', 'error');
            return;
        }
        
        const elementoProblematica = document.querySelector(`#listaProblematicas .card[data-id="${id}"]`);
        if(elementoProblematica) {
            elementoProblematica.setAttribute('data-titulo', nuevoTitulo);
            elementoProblematica.setAttribute('data-categoria', nuevaCategoria);
            elementoProblematica.querySelector('.card-body .d-flex div').innerHTML = `
                <strong>Título: ${nuevoTitulo}</strong><br>
                <span>Categoría: ${nuevaCategoria}</span>
            `;
        }
        
        $('#modalEditarProblematica').modal('hide');
        Swal.fire('Actualizado', 'Problemática modificada correctamente', 'success');
    });
    
    // Eliminar Problemática
    function eliminarProblematica(elemento, titulo) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar la problemática "${titulo}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                elemento.remove();
                Swal.fire('Eliminado', 'Problemática eliminada correctamente', 'success');
            }
        });
    }
    
    // Asignar eventos a problemáticas existentes
    document.querySelectorAll('.editar-problematica').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.card');
            const id = card.getAttribute('data-id');
            const titulo = card.getAttribute('data-titulo');
            const categoria = card.getAttribute('data-categoria');
            abrirModalEditarProblematica(id, titulo, categoria);
        });
    });
    
    document.querySelectorAll('.eliminar-problematica').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.card');
            const titulo = card.getAttribute('data-titulo');
            eliminarProblematica(card, titulo);
        });
    });
    
});
</script>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .btn-sm {
        margin: 0 2px;
    }
    hr {
        margin: 20px 0;
        border-top: 2px solid #e9ecef;
    }
    label {
        font-weight: 600;
    }
    .form-control {
        border-radius: 8px;
    }
    .modal-content {
        border-radius: 15px;
    }
    .modal-header {
        border-radius: 15px 15px 0 0;
    }
</style>

<?= $this->endSection() ?>