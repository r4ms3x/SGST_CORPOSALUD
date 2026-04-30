<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\UsuarioModel;
use App\Models\ProblematicaModel;
use App\Models\ModuloModel;

class User extends BaseController
{// En App/Controllers/User.php - Modificar el método dashboard()
public function dashboard()
{
    // Verificar que el usuario tenga rol 3
    if (session()->get('user_rol') != 3) {
        session()->setFlashdata('error', 'No tienes permisos para acceder a esta sección');
        return redirect()->to('/login');
    }
    
    // Obtener problemáticas de la BD para el select
    $problematicaModel = new ProblematicaModel();
    $problematicas = $problematicaModel->findAll();
    
    // Obtener el nombre del módulo del usuario
    $moduloModel = new ModuloModel();
    $moduloId = session()->get('user_modulo');
    $moduloNombre = 'Soporte Técnico'; // Valor por defecto
    
    if ($moduloId) {
        $modulo = $moduloModel->find($moduloId);
        if ($modulo) {
            $moduloNombre = $modulo['nombre'];
        }
    }
    
    $data['problematicas'] = $problematicas;
    $data['modulo_nombre'] = $moduloNombre; // Agregar el nombre del módulo
    
    return view('usuario/dashboard', $data);
}
    public function misTickets()
    {
        if (session()->get('user_rol') != 3) {
            return redirect()->to('/login')->with('error', 'Sin permisos');
        }
        
        $data['titulo'] = 'Mis Tickets';
        return view('usuario/mis_tickets', $data);
    }

    // Guardar problema inicial
    public function guardarProblema()
    {
        if (session()->get('user_rol') != 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permisos']);
        }

        $categoria = $this->request->getPost('categoria');
        $usuario_id = session()->get('user_id');

        $problematicaModel = new ProblematicaModel();
        $problema = $problematicaModel->where('LOWER(clasificacion)', strtolower($categoria))->first();
        
        if (!$problema) {
            $problema_id = 1;
        } else {
            $problema_id = $problema['id'];
        }

        $ticketModel = new TicketModel();
        
        $data = [
            'id_usuario' => $usuario_id,
            'id_problematica' => $problema_id,
            'creacion_del_ticket' => date('Y-m-d H:i:s'),
            'cancelado' => false,
            'estado' => 'pendiente'
        ];

        try {
            if ($ticketModel->insert($data)) {
                $ticket_id = $ticketModel->insertID();
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Ticket creado exitosamente',
                    'ticket_id' => $ticket_id
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al crear el ticket']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Obtener estado actual del ticket
   // En App/Controllers/User.php - Modificar el método getTicketEstado()
public function getTicketEstado($ticket_id)
{
    if (session()->get('user_rol') != 3) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sin permisos']);
    }

    $usuario_id = session()->get('user_id');
    $ticketModel = new TicketModel();
    
    $ticket = $ticketModel
        ->select('ticket.*, 
                  u.nombre as tecnico_nombre, 
                  u.apellido as tecnico_apellido, 
                  p.clasificacion,
                  p.titulo as problematica_titulo,
                  m.nombre as modulo_nombre')
        // NOTA: Eliminé a.nombre, a.apellido y comentario_admin
        ->join('usuario u', 'u.id = ticket.id_tecnico', 'left')
        ->join('problematica p', 'p.id = ticket.id_problematica', 'left')
        ->join('usuario usu', 'usu.id = ticket.id_usuario')
        ->join('modulo m', 'm.id = usu.modulo_id', 'left')
        ->where('ticket.id', $ticket_id)
        ->where('ticket.id_usuario', $usuario_id)
        ->first();

    if (!$ticket) {
        return $this->response->setJSON(['success' => false, 'message' => 'Ticket no encontrado']);
    }

    return $this->response->setJSON([
        'success' => true,
        'ticket' => $ticket
    ]);
}

    // Marcar ticket como completado (AHORA SOLO EL USUARIO)
    public function completarTicket()
    {
        if (session()->get('user_rol') != 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permisos']);
        }

        $ticket_id = $this->request->getPost('ticket_id');
        $usuario_id = session()->get('user_id');

        $ticketModel = new TicketModel();
        
        $ticket = $ticketModel->where('id', $ticket_id)->where('id_usuario', $usuario_id)->first();
        
        if (!$ticket) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ticket no encontrado']);
        }

        if (empty($ticket['id_tecnico']) || empty($ticket['tiempo_estimado'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'El ticket aún no tiene técnico asignado o tiempo estimado']);
        }

        $updateData = [
            'estado_completado' => date('Y-m-d H:i:s'),
            'estado' => 'completado'
        ];

        if ($ticketModel->update($ticket_id, $updateData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Soporte completado exitosamente']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al completar el ticket']);
        }
    }

    // Obtener historial
    public function getHistorial()
    {
        if (session()->get('user_rol') != 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permisos']);
        }

        $usuario_id = session()->get('user_id');
        $ticketModel = new TicketModel();
        
        $tickets = $ticketModel
            ->select('ticket.*, 
                      p.clasificacion,
                      p.titulo as problematica_titulo,
                      u.nombre as tecnico_nombre,
                      u.apellido as tecnico_apellido')
            ->join('problematica p', 'p.id = ticket.id_problematica', 'left')
            ->join('usuario u', 'u.id = ticket.id_tecnico', 'left')
            ->where('ticket.id_usuario', $usuario_id)
            ->orderBy('ticket.creacion_del_ticket', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'tickets' => $tickets
        ]);
    }
}