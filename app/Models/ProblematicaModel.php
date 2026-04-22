<?php

namespace App\Models;

use CodeIgniter\Model;

class ProblematicaModel extends Model
{
    protected $table = 'problematica';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'titulo', 
        'clasificacion'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    
    // Método para obtener todas las problemáticas
    public function getAllProblematicas()
    {
        return $this->findAll();
    }
    
    // Método para obtener problemática por ID
    public function getProblematicaById($id)
    {
        return $this->find($id);
    }
    
    // Método para buscar por clasificación
    public function getByClasificacion($clasificacion)
    {
        return $this->where('clasificacion', $clasificacion)->findAll();
    }
}