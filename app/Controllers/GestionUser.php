<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class GestionUser extends BaseController
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
     * Muestra la vista principal de gestión de usuarios
     */
    public function index()
    {
        return view('admin/gestion_user');
    }
    
    /**
     * API: Listar todos los usuarios normales (rol_id = 3)
     */
    public function listarUsuarios()
    {
        try {
            // Obtener todos los usuarios con rol_id = 3 (usuarios normales)
            // Excluir eliminados lógicamente
           $usuarios = $this->usuarioModel
    ->select('id, nombre, apellido, ci, modulo_id, rol_id, activo, sesion_bloqueada, fecha_creacion')
    ->where('rol_id', 3)
    ->where('deleted_at IS NULL')
    ->findAll();
            
            // Formatear los datos para la respuesta
            $data = [];
            foreach ($usuarios as $usuario) {
                // Usamos el campo 'activo' para el estado
                $estaActivo = ($usuario['activo'] === true || 
                              $usuario['activo'] === 't' || 
                              $usuario['activo'] === 1 ||
                              $usuario['activo'] === '1');
                
                $data[] = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'ci' => $usuario['ci'],
                    'activo' => $estaActivo,
                    'estado_texto' => $estaActivo ? 'Activo' : 'Inactivo',
                    'estado_badge' => $estaActivo ? 'success' : 'danger',
                    'rol_id' => $usuario['rol_id'],
                    'fecha_creacion' => date('d/m/Y H:i', strtotime($usuario['fecha_creacion']))
                ];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cargar los usuarios: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Agregar un nuevo usuario normal
     */
    public function agregarUsuario()
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
            
            // Convertir estado del formulario correctamente
            // estado=0 (Activo) => activo = true
            // estado=1 (Inactivo) => activo = false
            $estadoPost = $this->request->getPost('estado');
            $activo = ($estadoPost == '0') ? true : false;
            
            // Preparar datos
           // En agregarUsuario, después de $activo = ...
$data = [
    'nombre' => $this->request->getPost('nombre'),
    'apellido' => $this->request->getPost('apellido'),
    'ci' => $this->request->getPost('cedula'),
    'modulo_id' => $this->request->getPost('modulo'), // Campo módulo
    'rol_id' => 3, // Rol de usuario normal
    'activo' => $activo,
    'sesion_bloqueada' => false,
    'password' => $passwordDefault,
    'fecha_creacion' => date('Y-m-d H:i:s')
];
            
            // Guardar usuario
            if ($this->usuarioModel->save($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario registrado exitosamente',
                    'password_default' => $passwordDefault,
                    'activo' => $activo
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar el usuario'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error en agregarUsuario: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Editar usuario existente
     */
    public function editarUsuario()
    {
        try {
            $id = $this->request->getPost('id');
            
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no proporcionado'
                ]);
            }
            
            // Verificar que el usuario existe y es usuario normal (rol_id = 3)
            $usuario = $this->usuarioModel
                            ->where('id', $id)
                            ->where('rol_id', 3)
                            ->where('deleted_at IS NULL')
                            ->first();
                            
            if (!$usuario) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
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
            if ($cedula != $usuario['ci']) {
                $rules['cedula'] .= '|is_unique[usuario.ci]';
            }
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Convertir estado del formulario correctamente
            $estadoPost = $this->request->getPost('estado');
            $activo = ($estadoPost == '0') ? true : false;
            
            // Preparar datos para actualizar
            $data = [
    'nombre' => $this->request->getPost('nombre'),
    'apellido' => $this->request->getPost('apellido'),
    'ci' => $this->request->getPost('cedula'),
    'modulo_id' => $this->request->getPost('modulo'), // Campo módulo
    'activo' => $activo
];
            
            // Actualizar
            if ($this->usuarioModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario actualizado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error en editarUsuario: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Cambiar rol de usuario normal a Técnico
     */
    public function cambiarRol()
    {
        try {
            $id = $this->request->getPost('id');
            $nuevoRol = $this->request->getPost('nuevo_rol');
            
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no proporcionado'
                ]);
            }
            
            // Verificar que el usuario existe y es usuario normal
            $usuario = $this->usuarioModel
                            ->where('id', $id)
                            ->where('rol_id', 3)
                            ->where('deleted_at IS NULL')
                            ->first();
                            
            if (!$usuario) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }
            
            // Validar el nuevo rol (1=Administrador, 2=Técnico)
            if (!in_array($nuevoRol, [1, 2])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Rol no válido. Los roles permitidos son: 1 (Administrador) o 2 (Técnico)'
                ]);
            }
            
            $nombreRol = ($nuevoRol == 1) ? 'Administrador' : 'Técnico';
            
            // Cambiar el rol del usuario
            if ($this->usuarioModel->update($id, ['rol_id' => $nuevoRol])) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => "Rol cambiado exitosamente. El usuario ahora es {$nombreRol}."
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al cambiar el rol'
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
     * API: Eliminar usuario (borrado lógico)
     */
    public function eliminarUsuario()
    {
        try {
            $id = $this->request->getPost('id');
            
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no proporcionado'
                ]);
            }
            
            // Verificar que el usuario existe y es usuario normal
            $usuario = $this->usuarioModel
                            ->where('id', $id)
                            ->where('rol_id', 3)
                            ->where('deleted_at IS NULL')
                            ->first();
                            
            if (!$usuario) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado o ya ha sido eliminado'
                ]);
            }
            
            // Borrado lógico: actualizar el campo deleted_at
            $result = $this->usuarioModel->update($id, [
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario ocultado exitosamente. Ya no aparecerá en la lista.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al ocultar el usuario'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error en eliminarUsuario: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * API: Restaurar usuario eliminado
     */
    public function restaurarUsuario()
    {
        try {
            $id = $this->request->getPost('id');
            
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no proporcionado'
                ]);
            }
            
            // Verificar que el usuario existe y está eliminado
            $usuario = $this->usuarioModel
                            ->withDeleted()
                            ->where('id', $id)
                            ->where('rol_id', 3)
                            ->where('deleted_at IS NOT NULL')
                            ->first();
                            
            if (!$usuario) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado o no está eliminado'
                ]);
            }
            
            // Restaurar: establecer deleted_at como NULL
            $result = $this->usuarioModel->update($id, [
                'deleted_at' => null
            ]);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario restaurado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al restaurar el usuario'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    }
}