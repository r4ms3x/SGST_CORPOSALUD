<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return view('usuario/dashboard');
        return view('admin/gestion_tec');
    }
}