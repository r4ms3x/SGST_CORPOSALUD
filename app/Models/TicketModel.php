<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_usuario', 'id_administrador', 'id_tecnico', 
        'id_problematica', 'id_solucion', 'creacion_del_ticket',
        'estado_en_proceso', 'estado_completado', 'cancelado',
        'tiempo_estimado', 'estado', 'bloqueado_por', 'bloqueado_nombre',
   
        'bloqueado_en', 'comentario_admin', 'admin_archivo', 'admin_asignador' 

    ];
    protected $useTimestamps = false;
    
    // Obtener tickets en espera
    public function getTicketsEnEspera()
    {
        return $this->select('ticket.*, 
                              u.nombre as usuario_nombre, 
                              u.apellido as usuario_apellido,
                              u.ci as usuario_ci,
                              m.nombre as modulo_nombre,
                              p.titulo as problematica_titulo,
                              p.clasificacion,
                              ticket.bloqueado_nombre')
                    ->join('usuario u', 'u.id = ticket.id_usuario')
                    ->join('modulo m', 'm.id = u.modulo_id', 'left')
                    ->join('problematica p', 'p.id = ticket.id_problematica', 'left')
                    ->where('ticket.id_tecnico IS NULL')
                    ->where('ticket.cancelado', false)
                    ->where('ticket.estado_completado IS NULL')
                    ->orderBy('ticket.creacion_del_ticket', 'ASC')
                    ->findAll();
    }
    
    // Obtener tickets en revisión con múltiples técnicos
    public function getTicketsEnRevision()
    {
        $tickets = $this->select('ticket.*, 
                              u.nombre as usuario_nombre, 
                              u.apellido as usuario_apellido,
                              u.ci as usuario_ci,
                              a.nombre as admin_nombre,
                              a.apellido as admin_apellido,
                              p.titulo as problematica_titulo,
                              p.clasificacion,
                              ticket.bloqueado_nombre,
                              (SELECT STRING_AGG(CONCAT(tec.nombre, \' \', tec.apellido), \', \')
                               FROM ticket_tecnicos tt
                               JOIN usuario tec ON tec.id = tt.tecnico_id
                               WHERE tt.ticket_id = ticket.id) as tecnicos_asignados,
                              (SELECT STRING_AGG(CONCAT(tec.nombre, \' \', tec.apellido), \', \')
                               FROM ticket_tecnicos tt
                               JOIN usuario tec ON tec.id = tt.tecnico_id
                               WHERE tt.ticket_id = ticket.id AND tt.asignado_por = ticket.id_administrador) as tecnicos_del_admin')
                    ->join('usuario u', 'u.id = ticket.id_usuario')
                    ->join('usuario a', 'a.id = ticket.id_administrador', 'left')
                    ->join('problematica p', 'p.id = ticket.id_problematica', 'left')
                    ->where('ticket.id_tecnico IS NOT NULL')
                    ->where('ticket.cancelado', false)
                    ->where('ticket.estado_completado IS NULL')
                    ->orderBy('ticket.estado_en_proceso', 'DESC')
                    ->findAll();
                    
        return $tickets;
    }
    
    // Obtener tickets completados// En App/Models/TicketModel.php
// Modificar el método getTicketsCompletados()

public function getTicketsCompletados()
{
    return $this->select('ticket.*, 
                          u.nombre as usuario_nombre, 
                          u.apellido as usuario_apellido,
                          u.ci as usuario_ci,
                          m.nombre as modulo_nombre,
                          p.titulo as problematica_titulo,
                          p.clasificacion,
                          (SELECT STRING_AGG(CONCAT(tec.nombre, \' \', tec.apellido), \', \')
                           FROM ticket_tecnicos tt
                           JOIN usuario tec ON tec.id = tt.tecnico_id
                           WHERE tt.ticket_id = ticket.id) as tecnicos_asignados,
                          a.nombre as admin_nombre,
                          a.apellido as admin_apellido')
                ->join('usuario u', 'u.id = ticket.id_usuario')
                ->join('modulo m', 'm.id = u.modulo_id', 'left')
                ->join('problematica p', 'p.id = ticket.id_problematica', 'left')
                ->join('usuario a', 'a.id = ticket.id_administrador', 'left')
                ->where('ticket.estado_completado IS NOT NULL')
                ->where('ticket.cancelado', false)
                ->where('ticket.estado !=', 'archivado')  // ← AGREGAR ESTA LÍNEA
                ->orderBy('ticket.estado_completado', 'DESC')
                ->findAll();
}
    
    // Asignar técnico a un ticket (agrega a la tabla de múltiples técnicos)
    public function asignarTecnico($ticketId, $tecnicoId, $adminId, $tiempoEstimado = null, $adminNombre = null)
    {
        // Primero, verificar si ya existe la asignación
        $db = \Config\Database::connect();
        $builder = $db->table('ticket_tecnicos');
        
        $exists = $builder->where('ticket_id', $ticketId)
                          ->where('tecnico_id', $tecnicoId)
                          ->get()
                          ->getRow();
        
        if (!$exists) {
            $builder->insert([
                'ticket_id' => $ticketId,
                'tecnico_id' => $tecnicoId,
                'asignado_por' => $adminId,
                'fecha_asignacion' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Actualizar el ticket principal (mantener compatibilidad)
        $data = [
            'id_tecnico' => $tecnicoId,
            'id_administrador' => $adminId,
            'estado_en_proceso' => date('Y-m-d H:i:s'),
            'estado' => 'en_proceso'
        ];
        
        if ($tiempoEstimado) {
            $data['tiempo_estimado'] = $tiempoEstimado;
        }
        
        if ($adminNombre) {
            $data['admin_asignador'] = $adminNombre;
        }
        
        return $this->update($ticketId, $data);
    }
    
    // Obtener técnicos asignados a un ticket
 public function getTecnicosAsignados($ticketId)
{
    $db = \Config\Database::connect();
    $builder = $db->table('ticket_tecnicos tt');
    
    return $builder->select('u.id, u.nombre, u.apellido, u.ci, tt.asignado_por, tt.fecha_asignacion, a.nombre as admin_nombre, a.apellido as admin_apellido')
                   ->join('usuario u', 'u.id = tt.tecnico_id')
                   ->join('usuario a', 'a.id = tt.asignado_por', 'left')
                   ->where('tt.ticket_id', $ticketId)
                   ->get()
                   ->getResultArray();
}
    
    // Bloquear ticket
    public function bloquearTicket($ticketId, $adminId, $adminNombre)
    {
        $ticket = $this->find($ticketId);
        if ($ticket && !$ticket['bloqueado_por']) {
            return $this->update($ticketId, [
                'bloqueado_por' => $adminId,
                'bloqueado_nombre' => $adminNombre,
                'bloqueado_en' => date('Y-m-d H:i:s')
            ]);
        }
        return false;
    }
    
    // Desbloquear ticket
    public function desbloquearTicket($ticketId)
    {
        return $this->update($ticketId, [
            'bloqueado_por' => null,
            'bloqueado_nombre' => null,
            'bloqueado_en' => null
        ]);
    }
    
    // Archivar ticket completado (lo mueve a historial)
    public function archivarTicketCompletado($ticketId, $comentario = null)
    {
        return $this->update($ticketId, [
            'estado_completado' => date('Y-m-d H:i:s')
        ]);
    }
}