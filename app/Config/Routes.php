<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('prueba-admin', 'Admin::dashboard');

// Rutas GET públicas
$routes->get('/', 'Home::index');
$routes->get('registro', 'Auth::registroUsuario');  
$routes->get('login', 'Auth::login');

// Rutas POST públicas
$routes->post('auth/save_user', 'Auth::saveUser');  
$routes->post('auth/check_login', 'Auth::checkLogin');

// Rutas de autenticación
$routes->get('logout', 'Auth::logout');

// Dashboard general (redirige según rol)
$routes->get('dashboard', 'Dashboard::index');

// ==============================================
// RUTAS PARA ADMIN (Rol ID = 1)
// ==============================================
$routes->group('admin', function($routes) {
    // Dashboard principal
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Gestión de tickets
    $routes->get('tickets', 'Admin::tickets');
    
    // Gestión de usuarios
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('tecnicos', 'Admin::tecnicos');
    
    // Reportes y estadísticas
    $routes->get('reportes', 'Admin::reportes');
    $routes->get('historial', 'Admin::historial');
    $routes->get('agenda', 'Admin::agenda');
    $routes->get('auditoria', 'Admin::auditoria');
    $routes->get('documentacion', 'Admin::documentacion');
    
    // ==============================================
    // API ROUTES PARA TIEMPO REAL
    // ==============================================
    $routes->get('getTicketsActualizados', 'Admin::getTicketsActualizados');
    $routes->post('asignarTicket', 'Admin::asignarTicket');
    $routes->post('actualizarTicket', 'Admin::actualizarTicket');
    $routes->post('archivarTicket', 'Admin::archivarTicket');
    $routes->post('archivarTicketEspera', 'Admin::archivarTicketEspera');
    
    // ==============================================
    // RUTAS PARA BLOQUEO DE TICKETS
    // ==============================================
    $routes->post('bloquearTicket', 'Admin::bloquearTicket');
    $routes->post('verificarBloqueo', 'Admin::verificarBloqueo');
    $routes->post('verificarBloqueoHuerfano', 'Admin::verificarBloqueoHuerfano');
    $routes->post('limpiarBloqueoHuerfano', 'Admin::limpiarBloqueoHuerfano');
    $routes->post('desbloquearTicket', 'Admin::desbloquearTicket');
    $routes->post('getTecnicosAsignados', 'Admin::getTecnicosAsignados');
    
    // API ROUTES (con prefijo api)
    $routes->group('api', function($routes) {
        $routes->post('tickets/asignar', 'Admin::asignarTicket');
        $routes->post('tickets/actualizar', 'Admin::actualizarTicket');
        $routes->post('tickets/finalizar', 'Admin::finalizarTicket');
        $routes->post('tickets/archivar', 'Admin::archivarTicket');
        $routes->get('tickets/actualizados', 'Admin::getTicketsActualizados');
        $routes->post('tickets/bloquear', 'Admin::bloquearTicket');
        $routes->post('tickets/verificarBloqueo', 'Admin::verificarBloqueo');
        $routes->post('tickets/desbloquear', 'Admin::desbloquearTicket');
    });
});

// ==============================================
// RUTAS PARA USUARIOS NORMALES (Rol 3)
// ==============================================
$routes->group('usuario', function($routes) {
    $routes->get('/', 'User::dashboard');
    $routes->get('dashboard', 'User::dashboard');
    $routes->get('mis-tickets', 'User::misTickets');
    $routes->get('historial', 'HistorialUsuario::index');
    
    // ==============================================
    // RUTA PARA DETALLE DE TICKET - ¡ESTA FALTABA!
    // ==============================================
    $routes->get('detalleTicket/(:num)', 'HistorialUsuario::detalleTicket/$1');
    
    // API routes para el usuario
    $routes->post('guardarProblema', 'User::guardarProblema');
    $routes->get('getTicketEstado/(:num)', 'User::getTicketEstado/$1');
    $routes->post('completarTicket', 'User::completarTicket');
    $routes->get('getHistorial', 'User::getHistorial');
});

// ==============================================
// RUTAS PARA TÉCNICOS (Rol ID = 2)
// ==============================================
$routes->group('tecnico', function($routes) {
    $routes->get('/', 'Tecnico::dashboard');
    $routes->get('dashboard', 'Tecnico::dashboard');
    $routes->get('mis-tickets', 'Tecnico::misTickets');
});

// Rutas de promoción
$routes->get('promover/tecnico/(:num)', 'Auth::promoverATecnico/$1');
$routes->get('promover/admin/(:num)', 'Auth::promoverAAdmin/$1');

// ==============================================
// RUTA POR SI ALGO REDIRIGE A 'user' (compatibilidad)
// ==============================================
$routes->get('user/dashboard', function() {
    return redirect()->to('/usuario/dashboard');
});
$routes->get('user', function() {
    return redirect()->to('/usuario/dashboard');
});