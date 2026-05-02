<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 
        'apellido', 
        'ci', 
        'modulo_id', 
        'rol_id',
        'activo',
        'password_hash',
        'sesion_bloqueada',
        'fecha_creacion',
        'deleted_at',
    ];
    protected $useTimestamps = false;
    
    protected $useSoftDeletes = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = null;
    protected $deletedField = 'deleted_at';
   
    public function save($data): bool
    {
       
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }
        
        return parent::save($data);
    }
    
    // Verificar credenciales para login
    public function verificarCredenciales($ci, $password)
    {
        $usuario = $this->where('ci', $ci)->first();
        
        if ($usuario && isset($usuario['password_hash'])) {
            if (password_verify($password, $usuario['password_hash'])) {
                return $usuario;
            }
        }
        return false;
    }
}