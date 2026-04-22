<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('usuario/dashboard');
        // Esta es la ruta a la vista que creaste en app/Views/usuario/dashboard.php
        return view('admin/gestion_tec');
    }
}