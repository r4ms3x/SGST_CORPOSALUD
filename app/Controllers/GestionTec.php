<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class GestionTec extends BaseController
{
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        
        // Verificar que el usuario sea administrador
        if (session()->get('user_rol') != 1) {
            die(json_encode(['error' => 'No autorizado']));
        }
    }
    
    /**
     * Muestra la vista principal de gestión de técnicos
     */
    public function index()
    {
        return view('admin/gestion_tec');
    }
    
    /**
     * API: Listar todos los técnicos
     */
   public function listarTecnicos()
{
    try {
        // Obtener todos los usuarios con rol_id = 2 (técnicos) y que NO estén eliminados
        $tecnicos = $this->usuarioModel
            ->select('id, nombre, apellido, ci, rol_id, activo, sesion_bloqueada')
            ->where('rol_id', 2)
            ->where('deleted_at IS NULL')  // Excluir eliminados
            ->findAll();
        
        // Formatear los datos para la respuesta
        $data = [];
        foreach ($tecnicos as $tecnico) {
            // Usamos el campo 'activo' para el estado
            $estaActivo = ($tecnico['activo'] === true || 
                          $tecnico['activo'] === 't' || 
                          $tecnico['activo'] === 1 ||
                          $tecnico['activo'] === '1');
            
            $data[] = [
                'id' => $tecnico['id'],
                'nombre' => $tecnico['nombre'],
                'apellido' => $tecnico['apellido'],
                'ci' => $tecnico['ci'],
                'activo' => $estaActivo,
                'estado_texto' => $estaActivo ? 'Activo' : 'Inactivo',
                'estado_badge' => $estaActivo ? 'success' : 'danger',
                'rol_id' => $tecnico['rol_id']
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
        
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al cargar los técnicos: ' . $e->getMessage()
        ]);
    }
}
    
    /**
     * API: Agregar un nuevo técnico
     */
    public function agregarTecnico()
    {
        try {
            // Validar datos
            $rules = [
                'nombre' => 'required|min_length[2]|max_length[100]',
                'apellido' => 'required|min_length[2]|max_length[100]',
                'cedula' => 'required|is_unique[usuario.ci]|min_length[6]|max_length[20]',
                'estado' => 'required|in_list[0,1]'
            ];
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Generar contraseña por defecto (la cédula)
            $passwordDefault = $this->request->getPost('cedula');
            
            // Convertir estado del formulario al campo 'activo' de la BD
            // estado=0 (Activo) => activo=true
            // estado=1 (Inactivo) => activo=false
            $estadoPost = $this->request->getPost('estado');
            $activo = ($estadoPost == '0') ? true : false;
            
            // Preparar datos
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'ci' => $this->request->getPost('cedula'),
                'rol_id' => 2, // Rol de técnico
                'activo' => $activo, // Estado activo/inactivo
                'sesion_bloqueada' => false, // Por defecto, sesión no bloqueada
                'password' => $passwordDefault,
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];
            
            // Guardar usuario
            if ($this->usuarioModel->save($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Técnico registrado exitosamente',
                    'password_default' => $passwordDefault
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar el técnico'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Editar técnico existente
     */
    public function editarTecnico()
    {
        try {
            $id = $this->request->getPost('id');
            
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de técnico no proporcionado'
                ]);
            }
            
            // Verificar que el técnico existe y es técnico
            $tecnico = $this->usuarioModel->where('id', $id)->where('rol_id', 2)->first();
            if (!$tecnico) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Técnico no encontrado'
                ]);
            }
            
            // Validar datos
            $rules = [
                'nombre' => 'required|min_length[2]|max_length[100]',
                'apellido' => 'required|min_length[2]|max_length[100]',
                'cedula' => 'required|min_length[6]|max_length[20]',
                'estado' => 'required|in_list[0,1]'
            ];
            
            // Validar cédula única (excluyendo el mismo usuario)
            $cedula = $this->request->getPost('cedula');
            if ($cedula != $tecnico['ci']) {
                $rules['cedula'] .= '|is_unique[usuario.ci]';
            }
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Convertir estado del formulario al campo 'activo' de la BD
            // estado=0 (Activo) => activo=true
            // estado=1 (Inactivo) => activo=false
            $estadoPost = $this->request->getPost('estado');
            $activo = ($estadoPost == '0') ? true : false;
            
            // Preparar datos para actualizar
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'ci' => $this->request->getPost('cedula'),
                'activo' => $activo // Actualizamos solo el campo activo, no sesion_bloqueada
            ];
            
            // Actualizar
            if ($this->usuarioModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Técnico actualizado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el técnico'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Cambiar rol de técnico a usuario normal
     */
   public function cambiarRol()
{
    try {
        // Obtener datos del POST
        $id = $this->request->getPost('id');
        $nuevoRol = $this->request->getPost('nuevo_rol');
        
        // Log para depuración
        log_message('debug', 'Cambiando rol - ID: ' . $id . ', Nuevo Rol: ' . $nuevoRol);
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de técnico no proporcionado'
            ]);
        }
        
        if (!$nuevoRol) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debe seleccionar un nuevo rol'
            ]);
        }
        
        // Verificar que el técnico existe y es técnico (rol_id = 2)
        $tecnico = $this->usuarioModel->where('id', $id)->where('rol_id', 2)->first();
        if (!$tecnico) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Técnico no encontrado o no es un técnico válido'
            ]);
        }
        
        // Validar el nuevo rol (1=Administrador, 3=Usuario Normal)
        if (!in_array($nuevoRol, [1, 3])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Rol no válido. Los roles permitidos son: 1 (Administrador) o 3 (Usuario Normal)'
            ]);
        }
        
        $nombreRol = ($nuevoRol == 1) ? 'Administrador' : 'Usuario Normal';
        
        // Cambiar el rol del usuario
        if ($this->usuarioModel->update($id, ['rol_id' => $nuevoRol])) {
            // Verificar que se actualizó correctamente
            $usuarioActualizado = $this->usuarioModel->find($id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => "Rol cambiado exitosamente. El usuario {$tecnico['nombre']} {$tecnico['apellido']} ahora es {$nombreRol} (Rol ID: {$nuevoRol}).",
                'nuevo_rol' => $usuarioActualizado['rol_id']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cambiar el rol en la base de datos'
            ]);
        }
        
    } catch (\Exception $e) {
        log_message('error', 'Error en cambiarRol: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error en el servidor: ' . $e->getMessage()
        ]);
    }
}
    
    /**
     * API: Eliminar técnico (borrado físico)
     */
    public function eliminarTecnico()
{
    try {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de técnico no proporcionado'
            ]);
        }
        
        // Verificar que el técnico existe y es técnico (y no está eliminado)
        $tecnico = $this->usuarioModel
                        ->where('id', $id)
                        ->where('rol_id', 2)
                        ->where('deleted_at IS NULL')
                        ->first();
        
        if (!$tecnico) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Técnico no encontrado o ya ha sido eliminado'
            ]);
        }
        
        // Borrado lógico: actualizar el campo deleted_at
        $result = $this->usuarioModel->update($id, [
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Técnico ocultado exitosamente. Ya no aparecerá en la lista.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al ocultar el técnico'
            ]);
        }
        
    } catch (\Exception $e) {
        log_message('error', 'Error en eliminarTecnico: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error en el servidor: ' . $e->getMessage()
        ]);
    }
}

 public function usuarios() {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('admin/gestion_user', $data);
    }

}