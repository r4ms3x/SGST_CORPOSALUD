<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titulo ?? 'Sistema de Tickets' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">

    <style>
        /* Estilo para el contenedor circular del icono */
        .user-icon-circle {
            width: 70px;
            height: 70px;
            background-color: #6c757d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #adb5bd;
            transition: all 0.3s ease;
        }

        .user-icon-circle i {
            color: #ffffff;
            font-size: 30px;
        }

        .user-panel:hover .user-icon-circle {
            transform: scale(1.1);
            border-color: #ffffff;
            background-color: #495057;
        }

        .user-panel .info a {
            color: #c2c7d0 !important;
            margin-top: 5px;
        }
        
        /* ============================================ */
        /* ESTILOS DEL CARRUSEL - AJUSTADO AL CONTENIDO */
        /* ============================================ */
        .carousel {
            position: relative;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            opacity: 0.6 !important;
            z-index: 5;
            width: 35px !important;
            background: rgba(0,0,0,0.4);
            border-radius: 5px;
            top: 50%;
            transform: translateY(-50%);
            height: 50px;
            margin: 0;
        }
        
        .carousel-inner {
            padding: 5px 40px !important;
        }
        
        .carousel-item {
            text-align: center;
        }
        
        .carousel-item .d-flex {
            justify-content: flex-start !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            gap: 15px;
            scrollbar-width: thin;
        }
        
        /* Ocultar scrollbar pero mantener funcionalidad */
        .carousel-item .d-flex::-webkit-scrollbar {
            height: 5px;
        }
        
        .carousel-item .d-flex::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }
        
        .carousel-item .d-flex::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1 !important;
            background: rgba(0,0,0,0.6);
        }
        
        /* ============================================ */
        /* ESTILOS DE TARJETAS - TAMAÑO FIJO */
        /* ============================================ */
        .card.ticket-clickable {
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            display: inline-block !important;
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
            border-radius: 10px !important;
            overflow: hidden;
        }
        
        /* Hover suave - SOLO SOMBRA */
        .card.ticket-clickable:hover {
            transform: none !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
            filter: brightness(0.98) !important;
        }
        
        /* Estilos para la información */
        .info-row {
            font-size: 12px;
            margin-bottom: 6px;
            text-align: left;
            padding: 3px 0;
            line-height: 1.4;
        }
        
        .ticket-title {
            font-size: 15px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            text-align: center;
            font-weight: bold;
        }
        
        .card-body {
            padding: 12px !important;
        }
        
        .separator {
            border-top: 1px solid rgba(255,255,255,0.2);
            margin: 6px 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .card.ticket-clickable {
                width: 260px !important;
                min-width: 260px !important;
            }
            .carousel-inner {
                padding: 5px 30px !important;
            }
        }
        
        @media (max-width: 576px) {
            .card.ticket-clickable {
                width: 240px !important;
                min-width: 240px !important;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notificaciones</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 nuevos mensajes
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 solicitudes
                        <span class="float-right text-muted text-sm">12 horas</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Ver todas</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
                <div class="image">
                    <div class="user-icon-circle elevation-2">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="info mt-2 text-center">
                    <a href="#" class="d-block font-weight-bold">
                        <?= session()->get('user_nombre') ?? session()->get('nombre') ?? 'Usuario' ?>
                        <?= session()->get('user_apellido') ?? session()->get('apellido') ?? '' ?>
                    </a>
                    <span class="text-muted small">
                        <i class="fas fa-circle text-success" style="font-size: 8px;"></i> En línea
                    </span>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <?= $this->renderSection('menu_options') ?>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2026 Equipo Pasantías.</strong>
    </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js"></script>

</body>
</html>