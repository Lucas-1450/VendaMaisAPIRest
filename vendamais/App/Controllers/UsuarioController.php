<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;

final class UsuarioController
{
    public function getUsuario(Request $request, Response $response, $args): Response
    {
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->getAllUsuarios();

        if($usuario){
            $response = $response->withJson($usuario);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há Usuários cadastrados.'
            ]);
        }

        return $response;
    }

    public function insertUsuario(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $usuarioDAO = new UsuarioDAO();
        $usuario = new UsuarioModel();
        $usuario->setUsuario($data['usuario'])
                ->setSenha($data['senha']);

        $isInserted = $usuarioDAO->insertUsuario($usuario);
        
        if(!$isInserted){
            $response = $response->withJson([
                'error' => 'true',
                'code' => 100,
                'message' => 'O usuario informado já possui cadastro no sistema.'
            ]);
        }else {
            $response = $response->withJson([
                'message' => 'Usuario inserido com sucesso!'
            ]);
        }


        return $response;
    }

    public function updateUsuario(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $usuarioDAO = new UsuarioDAO();
        $usuario = new UsuarioModel();
        $usuario->setId_usuario((int)$data['id_usuario'])
             ->setUsuario($data['usuario'])
             ->setSenha($data['senha']);

        $usuarioDAO->updateUsuario($usuario);
        $message = 'Usuário atualizado com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }


    public function deleteUsuario(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $usuarioDAO = new UsuarioDAO();
        $usuario = new UsuarioModel();
        $usuario->setId_usuario((int)$data['id_usuario']);

        $usuarioDAO->deleteUsuario($usuario);
        $message = 'Usuario excluído com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

    public function tryLogin($request, $response): bool
    {

        $login = false;
        
        $statusCode = $response->getStatusCode();

        if($statusCode == 200){
            $login = true;
            echo "Parabéns, você fez o login!";
        };
        
        return $login;
    }

}