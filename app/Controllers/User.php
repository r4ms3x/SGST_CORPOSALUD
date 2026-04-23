<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\ProblematicaModel;

class User extends BaseController
{
    protected $ticketModel;
    protected $problematicaModel;
    
    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->problematicaModel = new ProblematicaModel();
    }
    
    public function dashboard()
    {
        if (session()->get('user_rol') != 3) {
            return redirect()->to('/login');
        }
        
        // Tickets del usuario logueado
        $data = [
            'titulo' => 'Mis Tickets',
            'ticketsActivos' => $this->ticketModel->where('id_usuario', session()->get('user_id'))
                                                  ->where('estado_completado', null)
                                                  ->where('cancelado', false)
                                                  ->findAll(),
            'ticketsCompletados' => $this->ticketModel->where('id_usuario', session()->get('user_id'))
                                                     ->where('estado_completado !=', null)
                                                     ->findAll(),
            'problematicas' => $this->problematicaModel->findAll()
        ];
        
        return view('user/dashboard', $data);
    }
    
    // Crear nuevo ticket
    public function crearTicket()
    {
        $data = [
            'id_usuario' => session()->get('user_id'),
            'id_problematica' => $this->request->getPost('problematica_id'),
            'creacion_del_ticket' => date('Y-m-d H:i:s'),
            'cancelado' => false
        ];
        
        if ($this->ticketModel->insert($data)) {
            return redirect()->to('/user/dashboard')->with('success', 'Ticket creado exitosamente');
        }
        
        return redirect()->back()->with('error', 'Error al crear ticket');
    }
    
    // Confirmar solución (marcar como completado)
    public function confirmarSolucion($ticketId)
    {
        $ticket = $this->ticketModel->find($ticketId);
        
        if ($ticket && $ticket['id_usuario'] == session()->get('user_id')) {
            $this->ticketModel->completarTicket($ticketId);
            return redirect()->to('/user/dashboard')->with('success', 'Ticket completado');
        }
        
        return redirect()->back()->with('error', 'No puedes completar este ticket');
    }
}