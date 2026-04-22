<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthUsuarioFilter implements FilterInterface
{
    /**
     * Verifica que el usuario esté logueado y sea usuario normal (rol_id = 3) o admin (rol_id = 1)
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Verificar si está logueado
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Por favor inicia sesión primero');
        }
        
        // Verificar rol (usuario normal o admin pueden acceder)
        $rol_id = $session->get('rol_id');
        if ($rol_id != 3 && $rol_id != 1) {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de usuario');
        }
        
        // Verificar expiración de sesión
        $lastActivity = $session->get('last_activity');
        if ($lastActivity && (time() - $lastActivity > 7200)) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Tu sesión ha expirado por inactividad');
        }
        
        // Actualizar timestamp
        $session->set('last_activity', time());
        
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}