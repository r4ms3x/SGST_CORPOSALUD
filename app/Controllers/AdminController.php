<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        // Esta línea le dice a CI4: "Busca en la carpeta Views el archivo dashboard_admin"
        return view('dashboard_admin'); 
    }
}