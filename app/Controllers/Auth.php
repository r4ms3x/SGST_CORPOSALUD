<?php

namespace App\Controllers;

// Importante: No debe haber NINGÚN espacio antes del <?php arriba

class Auth extends BaseController
{
    public function registroAdmin()
    {
        // Verifica que la carpeta sea 'auth' y el archivo 'register_admin'
        return view('auth/register_admin');
    }

    public function login()
    {
        return view('auth/login');
    }
}