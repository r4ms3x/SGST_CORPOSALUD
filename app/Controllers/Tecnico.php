<?php

namespace App\Controllers;

class Tecnico extends BaseController
{
    public function dashboard()
    {
        // Verificar que sea técnico o admin
        $rol = session()->get('user_rol');
        if ($rol != 2 && $rol != 1) {
            return redirect()->to('/login')->with('error', 'No tienes permisos');
        }
        
        $data = [
            'titulo' => 'Panel de Técnico',
            'nombre' => session()->get('user_nombre'),
            'apellido' => session()->get('user_apellido')
        ];
        
        return view('tecnico/dashboard', $data);
    }
    
    public function misTickets()
    {
        $data['titulo'] = 'Mis Tickets Asignados';
        return view('tecnico/mis_tickets', $data);
    }
}