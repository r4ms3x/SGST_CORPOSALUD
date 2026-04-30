<?php

namespace App\Models;

use CodeIgniter\Model;

class ProblematicaModel extends Model
{
    protected $table = 'problematica';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'clasificacion'];
}