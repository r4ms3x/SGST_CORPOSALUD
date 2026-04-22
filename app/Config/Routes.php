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
// NOTA: Temporalmente sin filtro para probar
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
    
    // API ROUTES
    $routes->group('api', function($routes) {
        $routes->post('tickets/asignar', 'Admin::asignarTicket');
        $routes->post('tickets/actualizar', 'Admin::actualizarTicket');
        $routes->post('tickets/finalizar', 'Admin::finalizarTicket');
        $routes->post('tickets/archivar', 'Admin::archivarTicket');
    });
});

// ==============================================
// RUTAS PARA USUARIOS NORMALES
// ==============================================
$routes->group('usuario', function($routes) {
    $routes->get('/', 'User::dashboard');  // NOTA: User, no Usuario
    $routes->get('dashboard', 'User::dashboard');
    $routes->get('mis-tickets', 'User::misTickets');
});

// Rutas de promoción
$routes->get('promover/tecnico/(:num)', 'Auth::promoverATecnico/$1');
$routes->get('promover/admin/(:num)', 'Auth::promoverAAdmin/$1');