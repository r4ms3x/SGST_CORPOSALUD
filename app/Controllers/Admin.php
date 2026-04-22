<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\UsuarioModel;
use App\Models\ModuloModel;
use App\Models\ProblematicaModel;

class Admin extends BaseController
{
    protected $ticketModel;
    protected $usuarioModel;
    protected $moduloModel;
    protected $problematicaModel;
    
    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->usuarioModel = new UsuarioModel();
        $this->moduloModel = new ModuloModel();
        $this->problematicaModel = new ProblematicaModel();
    }
    
public function dashboard()
{
    if (session()->get('user_rol') != 1) {
        return redirect()->to('/login')->with('error', 'No tienes permisos de administrador');
    }
    
    $data = [
        'ticketsEspera' => $this->ticketModel->getTicketsEnEspera(),
        'ticketsRevision' => $this->ticketModel->getTicketsEnRevision(),
        'ticketsCompletados' => $this->ticketModel->getTicketsCompletados(),
        'tecnicos' => $this->usuarioModel->where('rol_id', 2)->findAll(),
        'problematicas' => $this->problematicaModel->findAll()
    ];
    
    return view('admin/dashboard', $data);
}
    public function tickets()
    {
        $data['tickets'] = $this->ticketModel->findAll();
        return view('admin/tickets', $data);
    }
    
    public function usuarios()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('admin/usuarios', $data);
    }
    
    public function tecnicos()
    {
        $data['tecnicos'] = $this->usuarioModel->where('rol_id', 2)->findAll();
        return view('admin/tecnicos', $data);
    }
    
    public function reportes()
    {
        return view('admin/reportes');
    }
    
    public function historial()
    {
        return view('admin/historial');
    }
    
    public function agenda()
    {
        return view('admin/agenda');
    }
    
    public function auditoria()
    {
        return view('admin/auditoria');
    }
    
    public function documentacion()
    {
        return view('admin/documentacion');
    }
    
    // API Methods
    // API: Asignar técnico (mover a REVISION)
public function asignarTicket()
{
    $ticketId = $this->request->getPost('ticket_id');
    $tecnicoId = $this->request->getPost('tecnico_id');
    $adminId = session()->get('user_id');
    
    if (!$ticketId || !$tecnicoId) {
        return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
    }
    
    $result = $this->ticketModel->asignarTecnico($ticketId, $tecnicoId, $adminId);
    
    if ($result) {
        return $this->response->setJSON(['success' => true, 'message' => 'Ticket asignado a técnico']);
    }
    
    return $this->response->setJSON(['success' => false, 'message' => 'Error al asignar']);
}
    public function actualizarTicket()
    {
        $ticketId = $this->request->getPost('ticket_id');
        $tecnicoId = $this->request->getPost('tecnico_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }
        
        $data = [];
        if ($tecnicoId) {
            $data['id_tecnico'] = $tecnicoId;
        }
        
        $result = $this->ticketModel->update($ticketId, $data);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Ticket actualizado correctamente']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar ticket']);
    }
    
    public function finalizarTicket()
    {
        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }
        
        $result = $this->ticketModel->update($ticketId, [
            'estado_completado' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Ticket finalizado correctamente']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al finalizar ticket']);
    }
    
    public function archivarTicket()
    {
        $ticketId = $this->request->getPost('ticket_id');
        $comentario = $this->request->getPost('comentario');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }
        
        $result = $this->ticketModel->update($ticketId, [
            'estado_completado' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Ticket archivado correctamente']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al archivar ticket']);
    }
}

