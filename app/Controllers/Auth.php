<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ModuloModel;

class Auth extends BaseController
{
  
    public function registroUsuario()
    {
        $moduloModel = new ModuloModel();
        $modulos = $moduloModel->findAll();
        
        $data = [
            'titulo' => 'Registro de Usuario',
            'modulos' => $modulos
        ];
        return view('auth/register_admin', $data);
    }

    
    public function saveUser()
    {
        // Recibir datos del formulario
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $ci = $this->request->getPost('cedula');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');
        $modulo_id = $this->request->getPost('modulo_id');
        
        // Validar datos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[2]|max_length[255]',
            'apellido' => 'required|min_length[2]|max_length[255]',
            'cedula' => 'required|numeric|is_unique[usuario.ci]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'modulo_id' => 'required|numeric'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        
        $rol_id = 3;
        
        // Preparar datos para guardar
        $usuarioModel = new UsuarioModel();
        $datos = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ci' => $ci,
            'password' => $password,
            'modulo_id' => $modulo_id,
            'rol_id' => $rol_id,
            'sesion_bloqueada' => false,
            'activo' => true,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];
        
        // Guardar en la base de datos
        try {
            if ($usuarioModel->save($datos)) {
                session()->setFlashdata('success', 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.');
                return redirect()->to('/login');
            } else {
                session()->setFlashdata('error', 'Error al registrar el usuario.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error de base de datos: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // Mostrar formulario de login
    public function login()
    {
        return view('auth/login');
    }
    
    // Procesar login
    public function checkLogin()
    {
        $ci = $this->request->getPost('cedula');
        $password = $this->request->getPost('password');
        
        if (empty($ci) || empty($password)) {
            session()->setFlashdata('error', 'Completa todos los campos');
            return redirect()->back()->withInput();
        }
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->verificarCredenciales($ci, $password);
        
        if ($usuario) {
            // Verificar si está activo
            if (isset($usuario['activo']) && $usuario['activo'] == false) {
                session()->setFlashdata('error', 'Cuenta desactivada');
                return redirect()->back()->withInput();
            }
            
            // PRIMERO: Guardar la sesión
            session()->set([
                'user_id' => $usuario['id'],
                'user_nombre' => $usuario['nombre'],
                'user_apellido' => $usuario['apellido'],
                'user_ci' => $usuario['ci'],
                'user_rol' => $usuario['rol_id'],
                'user_modulo' => $usuario['modulo_id'],
                'isLoggedIn' => true,
                'last_activity' => time(),
                'rol_id' => $usuario['rol_id'],
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'ci' => $usuario['ci']
            ]);
            
            // SEGUNDO: Verificar que la sesión se guardó
            if (!session()->get('isLoggedIn')) {
                echo "Error: No se pudo guardar la sesión";
                return;
            }
            
            // TERCERO: Redirigir según el rol
            if ($usuario['rol_id'] == 1) {
                // Administrador
                return redirect()->to('/admin/dashboard');
            } elseif ($usuario['rol_id'] == 2) {
                // Técnico
                return redirect()->to('/tecnico/dashboard');
            } else {
                // Usuario normal (rol 3)
                return redirect()->to('/usuario/dashboard');
            }
            
        } else {
            session()->setFlashdata('error', 'Cédula o contraseña incorrectos');
            return redirect()->back()->withInput();
        }
    }
    
    // Promover usuario normal a técnico
    public function promoverATecnico($usuario_id)
    {
        if (session()->get('user_rol') != 1) {
            session()->setFlashdata('error', 'Sin permisos');
            return redirect()->back();
        }
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuario_id);
        
        if (!$usuario || $usuario['rol_id'] != 3) {
            session()->setFlashdata('error', 'No se puede promover');
            return redirect()->back();
        }
        
        $usuarioModel->update($usuario_id, [
            'rol_id' => 2,
            'modulo_id' => null
        ]);
        
        session()->setFlashdata('success', 'Promovido a técnico');
        return redirect()->back();
    }
    
    // Promover técnico a administrador
    public function promoverAAdmin($usuario_id)
    {
        if (session()->get('user_rol') != 1) {
            session()->setFlashdata('error', 'Sin permisos');
            return redirect()->back();
        }
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuario_id);
        
        if (!$usuario || $usuario['rol_id'] != 2) {
            session()->setFlashdata('error', 'No se puede promover');
            return redirect()->back();
        }
        
        $usuarioModel->update($usuario_id, ['rol_id' => 1]);
        
        session()->setFlashdata('success', 'Promovido a administrador');
        return redirect()->back();
    }
    
    // Cerrar sesión
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada');
    }
}