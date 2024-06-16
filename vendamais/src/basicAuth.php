<?php

namespace src;

use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;

use Tuupola\Middleware\HttpBasicAuthentication;

function basicAuth(): HttpBasicAuthentication
{

    $usuarioDAO = new UsuarioDAO();
    $usuarios = $usuarioDAO->getAllUsuarios();
    
    $users = [];
    foreach ($usuarios as $usuario) {
        $users[$usuario['usuario']] = $usuario['senha'];
    }

    return new HttpBasicAuthentication([
        "users" => $users,
        "error" => function ($response, $arguments) {
            // Callback para tratar falhas de autenticação
            $statusCode = $response->getStatusCode();
            if ($statusCode == 401) {
                echo "Senha ou usuário inválidos."; // Ou você pode definir uma view específica aqui
            }
            return $response;
        }
    ]);

    
}