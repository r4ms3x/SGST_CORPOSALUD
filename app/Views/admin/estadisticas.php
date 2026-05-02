<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('menu_options') ?>
<li class="nav-item">
    <a href="<?= site_url('dashboard') ?>" class="nav-link">
        <i class="fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('modulo') ?>" class="nav-link">
        <i class="fas fa-cogs"></i>
        <p>Módulos</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('auditoria') ?>" class="nav-link">
        <i class="fas fa-clipboard-list"></i>
        <p>Auditoría</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('estadisticas') ?>" class="nav-link active">
        <i class="fas fa-chart-bar"></i>
        <p>Estadísticas</p>
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
        <i class="fas fa-user"></i>
        <p>Mi Perfil</p>
    </a>
</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- PRIMERA GRÁFICA: Reportes por cada módulo -->
    <div class="col-md-12">
        <div class="card" style="border-top: 4px solid #007bff;">
            <div class="card-header" style="background-color: #007bff; color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> 
                        GRÁFICA GENERAL DE REPORTES POR CADA MÓDULO
                    </h3>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <select id="filtroTiempo1" class="form-control form-control-sm" style="width: auto; border-radius: 50px;">
                            <option value="semana">Esta semana</option>
                            <option value="mes">Este mes</option>
                            <option value="anio">Este año</option>
                        </select>
                        <button class="btn btn-light btn-sm" id="btnDescargarGeneral" style="border-radius: 50px; color: #007bff;">
                            <i class="fas fa-download"></i> Descargar reporte general
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="graficaModulos" style="width: 100%; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- SEGUNDA GRÁFICA: Problemas por módulo -->
    <div class="col-md-12">
        <div class="card" style="border-top: 4px solid #28a745;">
            <div class="card-header" style="background-color: #28a745; color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light btn-sm" id="btnSeleccionarModulo" style="border-radius: 50px; color: #28a745;">
                            <i class="fas fa-search"></i> Seleccionar Módulo
                        </button>
                        <h3 class="card-title ml-3">
                            <i class="fas fa-chart-line"></i> 
                            GRÁFICA DE PROBLEMAS POR MÓDULO: <span id="moduloSeleccionadoNombre" class="font-weight-bold">Ninguno</span>
                        </h3>
                    </div>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <select id="filtroTiempo2" class="form-control form-control-sm" style="width: auto; border-radius: 50px;">
                            <option value="semana">Esta semana</option>
                            <option value="mes">Este mes</option>
                            <option value="anio">Este año</option>
                        </select>
                        <button class="btn btn-light btn-sm" id="btnDescargarPorModulo" style="border-radius: 50px; color: #28a745;" disabled>
                            <i class="fas fa-download"></i> Descargar reporte del módulo
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="graficaProblemas" style="width: 100%; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA SELECCIONAR MÓDULO -->
<div class="modal fade" id="modalSeleccionarModulo" tabindex="-1" role="dialog" aria-labelledby="modalSeleccionarModuloLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="modalSeleccionarModuloLabel">
                    <i class="fas fa-cubes"></i> Seleccionar Módulo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="selectModulo">Seleccione un módulo:</label>
                    <select class="form-control form-control-lg" id="selectModulo">
                        <option value="">-- Seleccione --</option>
                        <!-- Los módulos se cargarán dinámicamente -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px;">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnConfirmarModulo" style="border-radius: 50px;">
                    <i class="fas fa-check"></i> Ver Gráfica
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA DESCARGAR REPORTE (PDF/WORD) -->
<div class="modal fade" id="modalDescargar" tabindex="-1" role="dialog" aria-labelledby="modalDescargarLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17a2b8; color: white;">
                <h5 class="modal-title" id="modalDescargarLabel">
                    <i class="fas fa-download"></i> Descargar Reporte
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Seleccione el formato de descarga:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-danger" id="btnDescargarPDF" style="border-radius: 50px;">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </button>
                    <button class="btn btn-primary" id="btnDescargarWord" style="border-radius: 50px;">
                        <i class="fas fa-file-word"></i> Descargar Word
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 50px;">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // ==================== DATOS DE EJEMPLO ====================
    const modulos = [
        { id: 1, nombre: "SALUD", reportes: 45, problemas: { "Sin Red": 12, "Lento": 15, "Error": 10, "Otros": 8 } },
        { id: 2, nombre: "EDUCACIÓN", reportes: 38, problemas: { "Sin Red": 8, "Lento": 14, "Error": 9, "Otros": 7 } },
        { id: 3, nombre: "SOPORTE TÉCNICO", reportes: 52, problemas: { "Sin Red": 15, "Lento": 18, "Error": 12, "Otros": 7 } },
        { id: 4, nombre: "FINANZAS", reportes: 29, problemas: { "Sin Red": 5, "Lento": 8, "Error": 10, "Otros": 6 } },
        { id: 5, nombre: "RECURSOS HUMANOS", reportes: 33, problemas: { "Sin Red": 7, "Lento": 11, "Error": 9, "Otros": 6 } }
    ];
    
    // Variables globales separadas para cada gráfica
    let chartModulos = null;
    let chartProblemas = null;
    let moduloActual = null;
    
    // Datos separados para cada reporte
    let datosGenerales = null;
    let datosModuloEspecifico = null;
    
    // ==================== GRÁFICA 1: REPORTES POR MÓDULO ====================
    function actualizarGraficaModulos() {
        const filtro = document.getElementById('filtroTiempo1').value;
        
        let datosModulos = modulos.map(m => ({
            nombre: m.nombre,
            reportes: m.reportes
        }));
        
        if(filtro === 'semana') {
            datosModulos = datosModulos.map(m => ({ ...m, reportes: Math.floor(m.reportes * 0.25) }));
        } else if(filtro === 'mes') {
            datosModulos = datosModulos.map(m => ({ ...m, reportes: Math.floor(m.reportes * 0.5) }));
        }
        
        const labels = datosModulos.map(m => m.nombre);
        const datos = datosModulos.map(m => m.reportes);
        
        if(chartModulos) {
            chartModulos.destroy();
        }
        
        const ctx = document.getElementById('graficaModulos').getContext('2d');
        chartModulos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad de Reportes',
                    data: datos,
                    backgroundColor: 'rgba(0, 123, 255, 0.7)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Reportes por Módulo' }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Número de Reportes' } },
                    x: { title: { display: true, text: 'Módulos' } }
                }
            }
        });
        
        // Guardar datos para descarga general
        datosGenerales = { labels: labels, datos: datos, titulo: 'Reportes por Módulo' };
    }
    
    // ==================== GRÁFICA 2: PROBLEMAS POR MÓDULO ====================
    function actualizarGraficaProblemas() {
        if(!moduloActual) return;
        
        const filtro = document.getElementById('filtroTiempo2').value;
        const moduloData = modulos.find(m => m.id === moduloActual.id);
        
        if(!moduloData) return;
        
        const problemas = moduloData.problemas;
        const labels = Object.keys(problemas);
        let datos = Object.values(problemas);
        
        if(filtro === 'semana') {
            datos = datos.map(d => Math.floor(d * 0.25));
        } else if(filtro === 'mes') {
            datos = datos.map(d => Math.floor(d * 0.5));
        }
        
        if(chartProblemas) {
            chartProblemas.destroy();
        }
        
        const ctx = document.getElementById('graficaProblemas').getContext('2d');
        chartProblemas = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: `Problemas en ${moduloActual.nombre}`,
                    data: datos,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { 
                        display: true, 
                        text: `Distribución de Problemas en Módulo: ${moduloActual.nombre}`,
                        font: { size: 14 }
                    }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Cantidad de Problemas' } },
                    x: { title: { display: true, text: 'Tipos de Problemas' } }
                }
            }
        });
        
        // Habilitar botón de descarga
        document.getElementById('btnDescargarPorModulo').disabled = false;
        
        // Guardar datos para descarga del módulo específico
        datosModuloEspecifico = { labels: labels, datos: datos, titulo: `Problemas en Módulo: ${moduloActual.nombre}` };
    }
    
    // ==================== CARGAR MÓDULOS EN EL MODAL ====================
    function cargarModulosEnSelect() {
        const select = document.getElementById('selectModulo');
        select.innerHTML = '<option value="">-- Seleccione --</option>';
        
        modulos.forEach(modulo => {
            const option = document.createElement('option');
            option.value = modulo.id;
            option.textContent = `${modulo.nombre} (${modulo.reportes} reportes)`;
            select.appendChild(option);
        });
    }
    
    // ==================== FUNCIONES DE DESCARGA ====================
    function generarContenidoReporte(datos) {
        if(!datos || !datos.labels || datos.labels.length === 0) {
            return `
                <!DOCTYPE html>
                <html>
                <head><meta charset="UTF-8"><title>Reporte</title></head>
                <body>
                    <h1>No hay datos disponibles</h1>
                    <p>Por favor seleccione un módulo y genere la gráfica primero.</p>
                </body>
                </html>
            `;
        }
        
        let html = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Reporte de Estadísticas</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 40px; }
                    h1 { color: #28a745; text-align: center; }
                    .fecha { text-align: center; color: #6c757d; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
                    th { background-color: #28a745; color: white; }
                    .footer { text-align: center; margin-top: 50px; font-size: 10px; color: #6c757d; }
                </style>
            </head>
            <body>
                <h1>${datos.titulo}</h1>
                <div class="fecha">
                    Fecha de generación: ${new Date().toLocaleString('es-ES')}
                </div>
                <table>
                    <thead>
                        <tr><th>Categoría</th><th>Cantidad</th></tr>
                    </thead>
                    <tbody>
        `;
        
        for(let i = 0; i < datos.labels.length; i++) {
            html += `<tr><td>${datos.labels[i]}</td><td>${datos.datos[i]}</td></tr>`;
        }
        
        html += `
                    </tbody>
                </table>
                <div class="footer">
                    <p>Sistema de Tickets - Reporte generado automáticamente</p>
                </div>
            </body>
            </html>
        `;
        
        return html;
    }
    
    function descargarPDF(datos, tipo) {
        const contenido = generarContenidoReporte(datos);
        const elemento = document.createElement('div');
        elemento.innerHTML = contenido;
        
        const opt = {
            margin: [0.5, 0.5, 0.5, 0.5],
            filename: `reporte_${tipo}_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(elemento).save();
    }
    
    function descargarWord(datos, tipo) {
        const contenido = generarContenidoReporte(datos);
        const blob = new Blob([contenido], { type: 'application/msword' });
        saveAs(blob, `reporte_${tipo}_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.doc`);
    }
    
    // ==================== EVENTOS ====================
    
    document.getElementById('filtroTiempo1').addEventListener('change', function() {
        actualizarGraficaModulos();
    });
    
    document.getElementById('filtroTiempo2').addEventListener('change', function() {
        if(moduloActual) {
            actualizarGraficaProblemas();
        }
    });
    
    document.getElementById('btnDescargarGeneral').addEventListener('click', function() {
        if(!datosGenerales) {
            Swal.fire('Error', 'No hay datos para descargar', 'error');
            return;
        }
        
        Swal.fire({
            title: 'Seleccione formato',
            text: '¿Cómo desea descargar el reporte general?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'PDF',
            cancelButtonText: 'Word',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) {
                Swal.fire({ title: 'Generando PDF...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                setTimeout(() => { descargarPDF(datosGenerales, 'general'); Swal.close(); Swal.fire('Éxito', 'PDF generado', 'success'); }, 100);
            } else if(result.dismiss === 'cancel') {
                Swal.fire({ title: 'Generando Word...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                setTimeout(() => { descargarWord(datosGenerales, 'general'); Swal.close(); Swal.fire('Éxito', 'Word generado', 'success'); }, 100);
            }
        });
    });
    
    document.getElementById('btnSeleccionarModulo').addEventListener('click', function() {
        cargarModulosEnSelect();
        $('#modalSeleccionarModulo').modal('show');
    });
    
    document.getElementById('btnConfirmarModulo').addEventListener('click', function() {
        const moduloId = document.getElementById('selectModulo').value;
        
        if(!moduloId) {
            Swal.fire('Error', 'Por favor seleccione un módulo', 'error');
            return;
        }
        
        const modulo = modulos.find(m => m.id == moduloId);
        if(modulo) {
            moduloActual = modulo;
            document.getElementById('moduloSeleccionadoNombre').textContent = modulo.nombre;
            actualizarGraficaProblemas();
            $('#modalSeleccionarModulo').modal('hide');
        }
    });
    
    document.getElementById('btnDescargarPorModulo').addEventListener('click', function() {
        if(!moduloActual) {
            Swal.fire('Aviso', 'Primero seleccione un módulo', 'warning');
            return;
        }
        
        if(!datosModuloEspecifico) {
            Swal.fire('Error', 'No hay datos del módulo para descargar', 'error');
            return;
        }
        
        Swal.fire({
            title: 'Seleccione formato',
            text: `¿Cómo desea descargar el reporte del módulo ${moduloActual.nombre}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'PDF',
            cancelButtonText: 'Word',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) {
                Swal.fire({ title: 'Generando PDF...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                setTimeout(() => { descargarPDF(datosModuloEspecifico, `modulo_${moduloActual.nombre}`); Swal.close(); Swal.fire('Éxito', 'PDF generado', 'success'); }, 100);
            } else if(result.dismiss === 'cancel') {
                Swal.fire({ title: 'Generando Word...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                setTimeout(() => { descargarWord(datosModuloEspecifico, `modulo_${moduloActual.nombre}`); Swal.close(); Swal.fire('Éxito', 'Word generado', 'success'); }, 100);
            }
        });
    });
    
    // Inicializar
    actualizarGraficaModulos();
    
});
</script>

<style>
    .gap-2 { gap: 8px; display: flex; }
    .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .card-header { border-radius: 10px 10px 0 0; }
    .btn-light:hover { transform: translateY(-2px); transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    .btn-light { transition: all 0.3s ease; font-weight: 500; }
    @media (max-width: 768px) {
        .card-header .d-flex { flex-direction: column; gap: 10px; }
        .card-header h3 { font-size: 16px; }
        .btn-sm { font-size: 11px; }
    }
    canvas { max-height: 400px; width: 100% !important; }
</style>

<?= $this->endSection() ?>