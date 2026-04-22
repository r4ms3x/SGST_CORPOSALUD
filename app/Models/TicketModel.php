<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_usuario', 'id_administrador', 'id_tecnico', 
        'id_problematica', 'id_solucion', 'estado_en_proceso', 
        'estado_completado', 'cancelado'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    
    // Obtener tickets con toda la información (JOIN)
    public function getTicketCompleto($id = null)
    {
        $builder = $this->db->table('ticket t');
        $builder->select('t.*, 
                         u.nombre as usuario_nombre, u.apellido as usuario_apellido, u.ci as usuario_ci,
                         u2.nombre as admin_nombre, u2.apellido as admin_apellido,
                         u3.nombre as tecnico_nombre, u3.apellido as tecnico_apellido,
                         p.titulo as problematica_titulo, p.clasificacion,
                         m.nombre as modulo_nombre');
        $builder->join('usuario u', 'u.id = t.id_usuario');
        $builder->join('usuario u2', 'u2.id = t.id_administrador', 'left');
        $builder->join('usuario u3', 'u3.id = t.id_tecnico', 'left');
        $builder->join('problematica p', 'p.id = t.id_problematica');
        $builder->join('modulo m', 'm.id = u.modulo_id');
        
        if ($id) {
            $builder->where('t.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
    
    // Tickets EN ESPERA (creados, sin técnico asignado)
    public function getTicketsEnEspera()
    {
        $builder = $this->db->table('ticket t');
        $builder->select('t.*, 
                         u.nombre as usuario_nombre, u.apellido as usuario_apellido, u.ci as usuario_ci,
                         p.titulo as problematica_titulo, p.clasificacion,
                         m.nombre as modulo_nombre');
        $builder->join('usuario u', 'u.id = t.id_usuario');
        $builder->join('problematica p', 'p.id = t.id_problematica');
        $builder->join('modulo m', 'm.id = u.modulo_id');
        $builder->where('t.estado_en_proceso', null);
        $builder->where('t.estado_completado', null);
        $builder->where('t.cancelado', false);
        $builder->orderBy('t.creacion_del_ticket', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    // Tickets EN REVISION (técnico asignado, no completado)
    public function getTicketsEnRevision()
    {
        $builder = $this->db->table('ticket t');
        $builder->select('t.*, 
                         u.nombre as usuario_nombre, u.apellido as usuario_apellido, u.ci as usuario_ci,
                         u3.nombre as tecnico_nombre, u3.apellido as tecnico_apellido,
                         p.titulo as problematica_titulo, p.clasificacion,
                         m.nombre as modulo_nombre');
        $builder->join('usuario u', 'u.id = t.id_usuario');
        $builder->join('usuario u3', 'u3.id = t.id_tecnico', 'left');
        $builder->join('problematica p', 'p.id = t.id_problematica');
        $builder->join('modulo m', 'm.id = u.modulo_id');
        $builder->where('t.estado_en_proceso !=', null);
        $builder->where('t.estado_completado', null);
        $builder->where('t.cancelado', false);
        $builder->orderBy('t.estado_en_proceso', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    // Tickets COMPLETADOS
    public function getTicketsCompletados()
    {
        $builder = $this->db->table('ticket t');
        $builder->select('t.*, 
                         u.nombre as usuario_nombre, u.apellido as usuario_apellido,
                         u3.nombre as tecnico_nombre, u3.apellido as tecnico_apellido,
                         p.titulo as problematica_titulo,
                         m.nombre as modulo_nombre');
        $builder->join('usuario u', 'u.id = t.id_usuario');
        $builder->join('usuario u3', 'u3.id = t.id_tecnico', 'left');
        $builder->join('problematica p', 'p.id = t.id_problematica');
        $builder->join('modulo m', 'm.id = u.modulo_id');
        $builder->where('t.estado_completado !=', null);
        $builder->where('t.cancelado', false);
        $builder->orderBy('t.estado_completado', 'DESC');
        $builder->limit(20);
        
        return $builder->get()->getResultArray();
    }
    
    // Asignar técnico (mover a REVISION)
    public function asignarTecnico($ticketId, $tecnicoId, $adminId)
    {
        return $this->update($ticketId, [
            'id_tecnico' => $tecnicoId,
            'id_administrador' => $adminId,
            'estado_en_proceso' => date('Y-m-d H:i:s')
        ]);
    }
    
    // Completar ticket (mover a COMPLETADO)
    public function completarTicket($ticketId, $solucionId = null)
    {
        $data = ['estado_completado' => date('Y-m-d H:i:s')];
        if ($solucionId) {
            $data['id_solucion'] = $solucionId;
        }
        return $this->update($ticketId, $data);
    }
    
    // Cancelar ticket
    public function cancelarTicket($ticketId)
    {
        return $this->update($ticketId, ['cancelado' => true]);
    }
}