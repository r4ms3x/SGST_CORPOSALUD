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
        
        // Limpiar bloqueos huérfanos al cargar el dashboard
        $this->ticketModel->where('bloqueado_por IS NOT NULL')
            ->where('bloqueado_nombre IS NULL')
            ->set(['bloqueado_por' => null, 'bloqueado_nombre' => null, 'bloqueado_en' => null])
            ->update();
        
        $data = [
            'ticketsEspera' => $this->ticketModel->getTicketsEnEspera(),
            'ticketsRevision' => $this->ticketModel->getTicketsEnRevision(),
            'ticketsCompletados' => $this->ticketModel->getTicketsCompletados(),
            'tecnicos' => $this->usuarioModel->where('rol_id', 2)->findAll(),
            'problematicas' => $this->problematicaModel->findAll()
        ];
        
        return view('admin/dashboard', $data);
    }
    
    // API: Obtener tickets actualizados
    public function getTicketsActualizados()
    {
        try {
            $tickets = [
                'espera' => $this->ticketModel->getTicketsEnEspera(),
                'revision' => $this->ticketModel->getTicketsEnRevision(),
                'completados' => $this->ticketModel->getTicketsCompletados()
            ];
            
            return $this->response->setJSON(['success' => true, 'tickets' => $tickets]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // API: Bloquear ticket
    public function bloquearTicket()
    {
        $ticketId = $this->request->getPost('ticket_id');
        $adminId = session()->get('user_id');
        $adminNombre = session()->get('user_nombre') . ' ' . session()->get('user_apellido');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de ticket requerido']);
        }
        
        // Verificar si ya está bloqueado por otro admin
        $ticket = $this->ticketModel->find($ticketId);
        
        if ($ticket && !empty($ticket['bloqueado_por']) && $ticket['bloqueado_por'] != $adminId) {
            $nombreBloqueador = $ticket['bloqueado_nombre'];
            if (empty($nombreBloqueador)) {
                $usuario = $this->usuarioModel->find($ticket['bloqueado_por']);
                $nombreBloqueador = $usuario ? ($usuario['nombre'] . ' ' . $usuario['apellido']) : 'Otro administrador';
            }
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Ticket ya está bloqueado por: ' . $nombreBloqueador
            ]);
        }
        
        // Bloquear el ticket
        $result = $this->ticketModel->update($ticketId, [
            'bloqueado_por' => $adminId,
            'bloqueado_nombre' => $adminNombre,
            'bloqueado_en' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al bloquear ticket']);
        }
    }
    
    // API: Verificar si un ticket está bloqueado (VERSIÓN CORREGIDA)
    public function verificarBloqueo()
    {
        // Forzar respuesta JSON y evitar caché
        $this->response->setContentType('application/json');
        $this->response->setHeader('Cache-Control', 'no-cache');
        
        $ticketId = $this->request->getPost('ticket_id');
        
        // Si no hay ticket_id, devolver no bloqueado
        if (!$ticketId) {
            return $this->response->setJSON(['bloqueado' => false]);
        }
        
        $ticket = $this->ticketModel->find($ticketId);
        
        // Si no existe el ticket, devolver no bloqueado
        if (!$ticket) {
            return $this->response->setJSON(['bloqueado' => false]);
        }
        
        // Verificar si está bloqueado
        if (!empty($ticket['bloqueado_por'])) {
            $nombreBloqueador = $ticket['bloqueado_nombre'];
            
            // Si el nombre está vacío pero hay ID, intentar obtener el nombre del usuario
            if (empty($nombreBloqueador)) {
                $usuario = $this->usuarioModel->find($ticket['bloqueado_por']);
                if ($usuario) {
                    $nombreBloqueador = $usuario['nombre'] . ' ' . $usuario['apellido'];
                    // Actualizar el campo para futuras consultas
                    $this->ticketModel->update($ticketId, ['bloqueado_nombre' => $nombreBloqueador]);
                } else {
                    $nombreBloqueador = 'Administrador (ID: ' . $ticket['bloqueado_por'] . ')';
                }
            }
            
            return $this->response->setJSON([
                'bloqueado' => true,
                'bloqueado_por' => $nombreBloqueador
            ]);
        }
        
        return $this->response->setJSON(['bloqueado' => false]);
    }
    
    // API: Verificar si el ticket tiene bloqueo huérfano (sin nombre)
    public function verificarBloqueoHuerfano()
    {
        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['huérfano' => false]);
        }
        
        $ticket = $this->ticketModel->find($ticketId);
        
        if ($ticket && !empty($ticket['bloqueado_por']) && empty($ticket['bloqueado_nombre'])) {
            return $this->response->setJSON(['huérfano' => true]);
        }
        
        return $this->response->setJSON(['huérfano' => false]);
    }
    
    // API: Limpiar bloqueo huérfano
    public function limpiarBloqueoHuerfano()
    {
        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false]);
        }
        
        $ticket = $this->ticketModel->find($ticketId);
        
        if ($ticket && !empty($ticket['bloqueado_por']) && empty($ticket['bloqueado_nombre'])) {
            $this->ticketModel->update($ticketId, [
                'bloqueado_por' => null,
                'bloqueado_nombre' => null,
                'bloqueado_en' => null
            ]);
            return $this->response->setJSON(['success' => true]);
        }
        
        return $this->response->setJSON(['success' => false]);
    }
    
    // API: Desbloquear ticket
    public function desbloquearTicket()
    {
        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de ticket requerido']);
        }
        
        $result = $this->ticketModel->update($ticketId, [
            'bloqueado_por' => null,
            'bloqueado_nombre' => null,
            'bloqueado_en' => null
        ]);
        
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al desbloquear ticket']);
        }
    }
    
    // API: Obtener técnicos asignados a un ticket
    public function getTecnicosAsignados()
    {
        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON(['success' => false, 'tecnicos' => []]);
        }
        
        $tecnicos = $this->ticketModel->getTecnicosAsignados($ticketId);
        return $this->response->setJSON(['success' => true, 'tecnicos' => $tecnicos]);
    }
    
    // API: Asignar técnico
    public function asignarTicket()
    {
        try {
            $ticketId = $this->request->getPost('ticket_id');
            $tecnicoId = $this->request->getPost('tecnico_id');
            $adminId = session()->get('user_id');
            $tiempoEstimado = $this->request->getPost('tiempo');
            $adminNombre = session()->get('user_nombre') . ' ' . session()->get('user_apellido');
            
            if (!$ticketId || !$tecnicoId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
            }
            
            $result = $this->ticketModel->asignarTecnico($ticketId, $tecnicoId, $adminId, $tiempoEstimado, $adminNombre);
            
            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Técnico asignado correctamente']);
            }
            
            return $this->response->setJSON(['success' => false, 'message' => 'Error al asignar']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // API: Actualizar ticket (agregar más técnicos)
    public function actualizarTicket()
    {
        try {
            $ticketId = $this->request->getPost('ticket_id');
            $tecnicoId = $this->request->getPost('tecnico_id');
            $adminId = session()->get('user_id');
            
            if (!$ticketId || !$tecnicoId) {
                return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
            }
            
            $result = $this->ticketModel->asignarTecnico($ticketId, $tecnicoId, $adminId, null);
            
            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Técnico agregado correctamente']);
            }
            
            return $this->response->setJSON(['success' => false, 'message' => 'Error al agregar técnico']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // API: Archivar ticket completado
    public function archivarTicket()
    {
        try {
            $ticketId = $this->request->getPost('ticket_id');
            $comentario = $this->request->getPost('comentario');
            $adminNombre = session()->get('user_nombre') . ' ' . session()->get('user_apellido');
            
            if (!$ticketId) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID de ticket requerido']);
            }
            
            $result = $this->ticketModel->update($ticketId, [
                'estado_completado' => date('Y-m-d H:i:s'),
                'comentario_admin' => $comentario,
                'admin_archivo' => $adminNombre,
                'cancelado' => false,
                'estado' => 'archivado'
            ]);
            
            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Ticket archivado correctamente']);
            }
            
            return $this->response->setJSON(['success' => false, 'message' => 'Error al archivar ticket']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // API: Archivar ticket desde espera
    public function archivarTicketEspera()
    {
        try {
            $ticketId = $this->request->getPost('ticket_id');
            $comentario = $this->request->getPost('comentario');
            $adminNombre = session()->get('user_nombre') . ' ' . session()->get('user_apellido');
            
            if (!$ticketId) {
                return $this->response->setJSON(['success' => false, 'message' => 'ID de ticket requerido']);
            }
            
            $result = $this->ticketModel->update($ticketId, [
                'estado_completado' => date('Y-m-d H:i:s'),
                'cancelado' => true,
                'comentario_admin' => $comentario,
                'admin_archivo' => $adminNombre,
                'estado' => 'archivado'
            ]);
            
            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Ticket archivado exitosamente']);
            }
            
            return $this->response->setJSON(['success' => false, 'message' => 'Error al archivar ticket']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // Otros métodos
    public function tickets() {
        $data['tickets'] = $this->ticketModel->findAll();
        return view('admin/dashboard', $data);
    }
    
    public function usuarios() {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('admin/gestion_user', $data);
    }
     public function gestion_tec()
    {
        // Reutilizamos la misma consulta de técnicos para la vista
        $data['tecnicos'] = $this->usuarioModel->where('rol_id', 2)->findAll();
        return view('admin/gestion_tec', $data);
    }
    
    public function reportes() {
        return view('admin/reportes');
    }
    
    public function historial() {
        return view('admin/historial');
    }
    
    public function agenda() {
        return view('admin/agenda');
    }
    
    public function auditoria() {
        return view('admin/auditoria');
    }
    
    public function documentacion() {
        return view('admin/documentacion');
    }
}