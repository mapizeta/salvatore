<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Log para debugging
        log_message('info', 'AuthFilter - Verificando autenticación para: ' . $request->getUri()->getPath());
        log_message('info', 'AuthFilter - Session logged_in: ' . (session()->get('logged_in') ? 'true' : 'false'));
        log_message('info', 'AuthFilter - Session data: ' . json_encode(session()->get()));
        
        // Verificar si el usuario está autenticado
        if (!session()->get('logged_in')) {
            // Si es una petición AJAX, devolver JSON
            if ($request->isAJAX()) {
                return service('response')
                    ->setJSON(['error' => 'No autenticado'])
                    ->setStatusCode(401);
            }
            
            // Si no es AJAX, redirigir al login
            log_message('info', 'AuthFilter - Redirigiendo al login');
            return redirect()->to('/login');
        }
        
        log_message('info', 'AuthFilter - Usuario autenticado, continuando');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada después de la petición
    }
} 