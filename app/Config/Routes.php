<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rutas GET
$routes->get('/', 'Home::index');
$routes->get('registro', 'Auth::registroUsuario');  
$routes->get('login', 'Auth::login');

// Rutas POST
$routes->post('auth/save_user', 'Auth::saveUser');  
$routes->post('auth/check_login', 'Auth::checkLogin');

// Rutas protegidas (solo admins)
$routes->get('promover/tecnico/(:num)', 'Auth::promoverATecnico/$1');
$routes->get('promover/admin/(:num)', 'Auth::promoverAAdmin/$1');

// Rutas existentes
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');