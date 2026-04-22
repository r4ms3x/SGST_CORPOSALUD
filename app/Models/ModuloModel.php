<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuloModel extends Model
{
    protected $table = 'modulo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'numero_modulo', 'fecha_actualizado', 'fecha_creado'];
    protected $useTimestamps = false;
}