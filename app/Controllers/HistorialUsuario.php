<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\ProblematicaModel;
use App\Models\UsuarioModel;

class HistorialUsuario extends BaseController
{
    protected $ticketModel;
    protected $problematicaModel;
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->problematicaModel = new ProblematicaModel();
        $this->usuarioModel = new UsuarioModel();
    }
    
    public function index()
    {
        // Verificar que el usuario tenga rol 3
        if (session()->get('user_rol') != 3) {
            session()->setFlashdata('error', 'No tienes permisos para acceder a esta sección');
            return redirect()->to('/login');
        }
        
        $usuario_id = session()->get('user_id');
        
        // Obtener tickets ACTIVOS (pendientes o en proceso, no completados ni archivados)
        $activos = $this->ticketModel
            ->select('ticket.*, problematica.clasificacion as categoria')
            ->join('problematica', 'problematica.id = ticket.id_problematica')
            ->where('ticket.id_usuario', $usuario_id)
            ->where('ticket.estado_completado IS NULL')
            ->where('ticket.cancelado', false)
            ->where('ticket.estado !=', 'archivado')
            ->orderBy('ticket.creacion_del_ticket', 'DESC')
            ->findAll();
        
        // Obtener tickets COMPLETADOS
        $completados = $this->ticketModel
            ->select('ticket.*, problematica.clasificacion as categoria')
            ->join('problematica', 'problematica.id = ticket.id_problematica')
            ->where('ticket.id_usuario', $usuario_id)
            ->where('ticket.estado_completado IS NOT NULL')
            ->where('ticket.cancelado', false)
            ->orderBy('ticket.estado_completado', 'DESC')
            ->findAll();
        
        $data = [
            'titulo' => 'Historial de Reportes',
            'activos' => $activos,
            'completados' => $completados
        ];
        
        return view('usuario/historial', $data);
    }
    
    // API para obtener detalle de un ticket (SIN comentario del admin)
    public function detalleTicket($ticketId)
    {
        // Verificar que el usuario tenga rol 3
        if (session()->get('user_rol') != 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permisos']);
        }
        
        $usuario_id = session()->get('user_id');
        
        $ticket = $this->ticketModel
            ->select('ticket.*, 
                      problematica.clasificacion as categoria,
                      problematica.titulo as problematica_titulo,
                      u.nombre as tecnico_nombre,
                      u.apellido as tecnico_apellido,
                      a.nombre as admin_nombre,
                      a.apellido as admin_apellido')
            // NOTA: NO incluyo ticket.comentario_admin
            ->join('problematica', 'problematica.id = ticket.id_problematica', 'left')
            ->join('usuario u', 'u.id = ticket.id_tecnico', 'left')
            ->join('usuario a', 'a.id = ticket.id_administrador', 'left')
            ->where('ticket.id', $ticketId)
            ->where('ticket.id_usuario', $usuario_id)
            ->first();
        
        if (!$ticket) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ticket no encontrado']);
        }
        
        // Verificar si el ticket está activo (no completado)
        $estaActivo = ($ticket['estado_completado'] === null);
        
        // Verificar si tiene técnico asignado
        $tieneTecnico = !empty($ticket['id_tecnico']);
        
        // Verificar si tiene tiempo estimado
        $tieneTiempo = !empty($ticket['tiempo_estimado']);
        
        // Mostrar botón finalizar solo si: está activo, tiene técnico y tiene tiempo estimado
        $mostrarBotonFinalizar = ($estaActivo && $tieneTecnico && $tieneTiempo);
        
        // Formatear la respuesta (SIN comentario del admin)
        $data = [
            'success' => true,
            'ticket' => [
                'id' => $ticket['id'],
                'categoria' => $ticket['categoria'] ?? 'N/A',
                'fecha' => date('d/m/Y H:i', strtotime($ticket['creacion_del_ticket'])),
                'fecha_cierre' => $ticket['estado_completado'] ? date('d/m/Y H:i', strtotime($ticket['estado_completado'])) : null,
                'estado' => $estaActivo ? 'activo' : 'completado',
                'tecnico_nombre' => $ticket['tecnico_nombre'] ?? '',
                'tecnico_apellido' => $ticket['tecnico_apellido'] ?? '',
                'tecnico' => ($ticket['tecnico_nombre'] ? $ticket['tecnico_nombre'] . ' ' . ($ticket['tecnico_apellido'] ?? '') : 'No asignado'),
                'admin' => $ticket['admin_nombre'] ? $ticket['admin_nombre'] . ' ' . ($ticket['admin_apellido'] ?? '') : 'N/A',
              'descripcion' => $ticket['categoria'] ?? 'Sin descripción',
                'tiempo_estimado' => $ticket['tiempo_estimado'] ?? 'No estimado',
                'tiene_tecnico' => $tieneTecnico,
                'tiene_tiempo' => $tieneTiempo,
                'mostrar_boton_finalizar' => $mostrarBotonFinalizar
            ]
        ];
        
        return $this->response->setJSON($data);
    }
}