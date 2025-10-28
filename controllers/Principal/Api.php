<?php

class Api
{
    /**
     * Endpoint para obtener un nuevo token CSRF
     */
    public function csrfToken()
    {
        header('Content-Type: application/json');
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Generar un nuevo token CSRF
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        
        echo json_encode([
            'token' => $token
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

