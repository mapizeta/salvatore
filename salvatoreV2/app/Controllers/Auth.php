<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Si ya está logueado, redirigir al dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Log antes de la validación
        log_message('info', "Auth::login - Iniciando login para usuario: {$username}");

        // Validar credenciales
        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Log antes de crear la sesión
            log_message('info', "Auth::login - Credenciales válidas, creando sesión");
            
            // Crear sesión
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $user['role'],
                'logged_in' => true
            ]);

            // Log después de crear la sesión
            log_message('info', "Auth::login - Sesión creada - Session ID: " . session()->get('__ci_last_regenerate'));
            log_message('info', "Auth::login - Datos de sesión completos: " . json_encode(session()->get()));
            log_message('info', "Auth::login - Cookie name: " . session()->getCookieName());
            log_message('info', "Auth::login - Cookie path: " . session()->getCookiePath());

            // Forzar el guardado de la sesión
            session()->regenerate();

            return redirect()->to('/dashboard');
        } else {
            log_message('info', "Auth::login - Credenciales inválidas para usuario: {$username}");
            session()->setFlashdata('error', 'Usuario o contraseña incorrectos');
            return redirect()->back();
        }
    }

    public function logout()
    {
        // Log de salida
        $username = session()->get('username');
        log_message('info', "Usuario {$username} cerró sesión");

        // Destruir sesión
        session()->destroy();
        
        return redirect()->to('/login');
    }

    // API para verificar autenticación
    public function checkAuth()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'authenticated' => false,
                'message' => 'No autenticado'
            ])->setStatusCode(401);
        }

        return $this->response->setJSON([
            'authenticated' => true,
            'user' => [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ]);
    }
} 