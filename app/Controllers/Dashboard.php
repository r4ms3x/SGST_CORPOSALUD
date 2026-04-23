<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        echo "Dashboard::index - Llegué aquí";
        echo "<br>isLoggedIn: " . (session()->get('isLoggedIn') ? 'true' : 'false');
        echo "<br>user_rol: " . session()->get('user_rol');
        
        if (!session()->get('isLoggedIn')) {
            echo "<br>Redirigiendo a login...";
            return redirect()->to('/login');
        }
        
        $rol = session()->get('user_rol');
        echo "<br>Rol detectado: " . $rol;
        
        if ($rol == 1) {
            echo "<br>Redirigiendo a /admin/dashboard";
            return redirect()->to('/admin/dashboard');
        } else {
            echo "<br>Redirigiendo a /user/dashboard";
            return redirect()->to('/user/dashboard');
        }
    }
}