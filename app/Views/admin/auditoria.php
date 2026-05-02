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
    <a href="<?= site_url('auditoria') ?>" class="nav-link active">
        <i class="fas fa-clipboard-list"></i>
        <p>Auditoría</p>
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
        <div class="card" style="border-top: 4px solid #17a2b8;">
            <div class="card-header" style="background-color: #17a2b8; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> 
                        MOVIMIENTOS DEL SISTEMA
                    </h3>
                    <button class="btn btn-light" id="btnDescargar" style="border-radius: 50px; color: #17a2b8;">
                        <i class="fas fa-download"></i> Descargar Reporte PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tablaAuditoria">
                        <thead style="background-color: #17a2b8; color: white;">
                            <tr>
                                <th style="width: 30%;">
                                    <i class="fas fa-calendar-alt"></i> FECHA
                                </th>
                                <th style="width: 40%;">
                                    <i class="fas fa-cogs"></i> ACCIÓN
                                </th>
                                <th style="width: 30%;">
                                    <i class="fas fa-user"></i> USUARIO
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Ejemplo de datos vacíos o con información -->
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                <small><i class="fas fa-info-circle"></i> Registro de actividades realizadas en el sistema</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // Botón de descarga con alerta de confirmación
    const btnDescargar = document.getElementById('btnDescargar');
    
    btnDescargar.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Mostrar alerta de confirmación
        Swal.fire({
            title: '¿Seguro que desea descargar el documento?',
            text: 'Se generará un reporte PDF con todos los movimientos del sistema.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, descargar PDF',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Generando PDF...',
                    text: 'Por favor espere un momento',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Pequeño timeout para permitir que se muestre el loading
                setTimeout(() => {
                    descargarPDF();
                }, 100);
            }
        });
    });
    
    // Función para descargar el reporte en PDF
    function descargarPDF() {
        // Obtener la tabla y clonarla para no afectar la original
        const tablaOriginal = document.getElementById('tablaAuditoria');
        const tablaClon = tablaOriginal.cloneNode(true);
        
        // Obtener datos de la tabla para verificar si hay contenido real
        const filas = tablaClon.querySelectorAll('tbody tr');
        let tieneDatos = false;
        
        filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td');
            if(celdas.length === 3) {
                const fecha = celdas[0].textContent.trim();
                const accion = celdas[1].textContent.trim();
                const usuario = celdas[2].textContent.trim();
                if(fecha !== '&nbsp;' && fecha !== '' && accion !== '&nbsp;' && accion !== '' && usuario !== '&nbsp;' && usuario !== '') {
                    tieneDatos = true;
                }
            }
        });
        
        // Crear un contenedor para el PDF
        const elementoPDF = document.createElement('div');
        elementoPDF.style.padding = '20px';
        elementoPDF.style.fontFamily = 'Arial, sans-serif';
        
        // Agregar encabezado del reporte
        elementoPDF.innerHTML = `
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #17a2b8; margin-bottom: 10px;">MOVIMIENTOS DEL SISTEMA</h1>
                <p style="color: #6c757d; font-size: 14px;">
                    Fecha de generación: ${new Date().toLocaleString('es-ES')}
                </p>
                <hr style="border: 1px solid #17a2b8;">
            </div>
        `;
        
        // Agregar la tabla clonada al elemento
        elementoPDF.appendChild(tablaClon);
        
        // Agregar pie de página
        const footer = document.createElement('div');
        footer.style.textAlign = 'center';
        footer.style.marginTop = '30px';
        footer.style.paddingTop = '10px';
        footer.style.borderTop = '1px solid #dee2e6';
        footer.style.fontSize = '10px';
        footer.style.color = '#6c757d';
        footer.innerHTML = `
            <p>© ${new Date().getFullYear()} Sistema de Tickets - Reporte de Auditoría</p>
            <p>Este documento es generado automáticamente por el sistema</p>
        `;
        elementoPDF.appendChild(footer);
        
        // Estilos para la tabla en el PDF
        const estilo = document.createElement('style');
        estilo.textContent = `
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 12px;
            }
            th {
                background-color: #17a2b8;
                color: white;
                padding: 12px;
                text-align: center;
                border: 1px solid #dee2e6;
            }
            td {
                padding: 10px;
                text-align: center;
                border: 1px solid #dee2e6;
            }
            tr:nth-child(even) {
                background-color: #f8f9fa;
            }
            .table-responsive {
                overflow-x: auto;
            }
        `;
        elementoPDF.appendChild(estilo);
        
        // Configuración para html2pdf
        const opt = {
            margin: [0.5, 0.5, 0.5, 0.5],
            filename: `reporte_auditoria_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, letterRendering: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
        };
        
        // Generar PDF
        html2pdf().set(opt).from(elementoPDF).save().then(() => {
            // Cerrar el SweetAlert de loading
            Swal.close();
            // Mostrar mensaje de éxito
            Swal.fire(
                '¡Descarga completada!',
                'El reporte PDF se ha generado correctamente.',
                'success'
            );
        }).catch(error => {
            Swal.close();
            Swal.fire(
                'Error',
                'Hubo un problema al generar el PDF. Intente nuevamente.',
                'error'
            );
        });
    }
    
});
</script>

<style>
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .table thead th {
        border-bottom: none;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    
    .table tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 12px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(23, 162, 184, 0.1);
        transition: background-color 0.3s ease;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    
    .btn-light:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .btn-light {
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 10px 10px;
    }
    
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
        }
        
        .btn-light {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .card-header h3 {
            font-size: 16px;
        }
    }
</style>

<?= $this->endSection() ?>