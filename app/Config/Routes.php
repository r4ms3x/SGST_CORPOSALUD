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

$routes->group('admin', function($routes) {
    
    // ==============================================
    // RUTAS PARA GESTION DE USUARIOS (GestionUser)
    // ==============================================
    // Vista principal
    $routes->get('gestion_user', 'GestionUser::index');
    $routes->get('gestion-usuarios', 'GestionUser::index'); // Por si usas guión
    
    // API Routes para usuarios
    $routes->group('api/usuarios', function($routes) {
        $routes->get('listar', 'GestionUser::listarUsuarios');
        $routes->post('agregar', 'GestionUser::agregarUsuario');
        $routes->post('editar', 'GestionUser::editarUsuario');
        $routes->post('eliminar', 'GestionUser::eliminarUsuario');
    });
    
    // ==============================================
    // RUTAS PARA GESTION DE TECNICOS (GestionTec)
    // ==============================================
    $routes->get('gestion_tec', 'GestionTec::index');
    $routes->get('gestion-tecnicos', 'GestionTec::index');
    
    $routes->group('api/tecnicos', function($routes) {
        $routes->get('listar', 'GestionTec::listarTecnicos');
        $routes->post('agregar', 'GestionTec::agregarTecnico');
        $routes->post('editar', 'GestionTec::editarTecnico');
        $routes->post('cambiar-rol', 'GestionTec::cambiarRol');
        $routes->post('eliminar', 'GestionTec::eliminarTecnico');
        $routes->post('restaurar', 'GestionTec::restaurarTecnico');
    });
    
    // ==============================================
    // TUS RUTAS EXISTENTES DE ADMIN
    // ==============================================
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('reportes', 'Admin::reportes');
    $routes->get('historial', 'Admin::historial');
    $routes->get('agenda', 'Admin::agenda');
    $routes->get('auditoria', 'Admin::auditoria');
    $routes->get('documentacion', 'Admin::documentacion');
    
    // API para tickets (tus rutas existentes)
    $routes->get('getTicketsActualizados', 'Admin::getTicketsActualizados');
    $routes->post('asignarTicket', 'Admin::asignarTicket');
    $routes->post('actualizarTicket', 'Admin::actualizarTicket');
    $routes->post('archivarTicket', 'Admin::archivarTicket');
    $routes->post('archivarTicketEspera', 'Admin::archivarTicketEspera');
    $routes->post('bloquearTicket', 'Admin::bloquearTicket');
    $routes->post('verificarBloqueo', 'Admin::verificarBloqueo');
    $routes->post('verificarBloqueoHuerfano', 'Admin::verificarBloqueoHuerfano');
    $routes->post('limpiarBloqueoHuerfano', 'Admin::limpiarBloqueoHuerfano');
    $routes->post('desbloquearTicket', 'Admin::desbloquearTicket');
    $routes->post('getTecnicosAsignados', 'Admin::getTecnicosAsignados');
});

// ==============================================
// RUTAS PARA USUARIOS NORMALES (Rol 3)
// ==============================================
// GESTIÓN DE USUARIOS NORMALES (NUEVO)
    // ==============================================
    $routes->get('gestion-usuarios', 'GestionUser::index');
     $routes->get('gestion_user', 'GestionUser::index'); // Compatibilidad
    
    // API Routes para gestión de usuarios
    $routes->group('api/usuarios', function($routes) {
        $routes->get('listar', 'GestionUser::listarUsuarios');
        $routes->post('agregar', 'GestionUser::agregarUsuario');
        $routes->post('editar', 'GestionUser::editarUsuario');
        $routes->post('eliminar', 'GestionUser::eliminarUsuario');
        $routes->post('restaurar', 'GestionUser::restaurarUsuario');
    });

// Rutas de promoción
$routes->get('promover/tecnico/(:num)', 'Auth::promoverATecnico/$1');
$routes->get('promover/admin/(:num)', 'Auth::promoverAAdmin/$1');

// Rutas de compatibilidad
$routes->get('user/dashboard', function() {
    return redirect()->to('/usuario/dashboard');
});
$routes->get('user', function() {
    return redirect()->to('/usuario/dashboard');
});